<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use GuzzleHttp\Client as GuzzleClient;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\InvalidStateException;

class GoogleAuthController extends Controller
{
    /**
     * Dapatkan instance Socialite driver Google dengan konfigurasi CA certificate
     * untuk mencegah cURL error 60 di environment Windows.
     */
    protected function getGoogleDriver()
    {
        $driver = Socialite::driver('google');

        if ($driver instanceof AbstractProvider) {
            $caPath = storage_path('cacert.pem');
            if (!file_exists($caPath)) {
                $caPath = ini_get('curl.cainfo') ?: (ini_get('openssl.cafile') ?: 'C:\\laragon\\etc\\ssl\\cacert.pem');
            }

            if ($caPath && file_exists($caPath)) {
                $driver->setHttpClient(new GuzzleClient([
                    'verify' => $caPath,
                ]));
            }
        }

        return $driver;
    }

    /**
     * Arahkan pengguna ke halaman otorisasi Google OAuth.
     */
    public function redirectToGoogle(Request $request): RedirectResponse
    {
        $action = $request->query('action', 'login');
        $rawRole = $request->query('role', $request->input('role', 'customer'));
        $role = ($rawRole === 'owner') ? 'owner' : 'customer';

        session([
            'google_oauth_action' => $action,
            'google_oauth_role' => $role,
        ]);

        return $this->getGoogleDriver()
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Tangani callback otentikasi dari Google OAuth.
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        $action = session('google_oauth_action', 'login');
        $fallbackRoute = ($action === 'register') ? 'register' : 'login';

        // 1. Tangani pembatalan atau error dari Google
        if ($request->has('error')) {
            $error = $request->input('error');
            Log::info('Pengguna membatalkan autentikasi Google OAuth', ['error' => $error]);
            session()->forget(['google_oauth_action', 'google_oauth_role']);

            return redirect()->route($fallbackRoute)->with('error', 'Autentikasi dengan Google dibatalkan.');
        }

        // 2. Ambil informasi akun Google melalui Socialite
        try {
            $googleUser = $this->getGoogleDriver()->user();
        } catch (InvalidStateException $e) {
            Log::warning('Google OAuth state tidak valid', ['message' => $e->getMessage()]);
            session()->forget(['google_oauth_action', 'google_oauth_role']);

            return redirect()->route($fallbackRoute)->with('error', 'Sesi autentikasi telah kedaluwarsa atau tidak valid. Silakan coba kembali.');
        } catch (\Exception $e) {
            Log::error('Google OAuth callback error', ['message' => $e->getMessage()]);
            session()->forget(['google_oauth_action', 'google_oauth_role']);

            return redirect()->route($fallbackRoute)->with('error', 'Terjadi kesalahan saat berkomunikasi dengan layanan Google. Silakan coba beberapa saat lagi.');
        }

        // 3. Validasi Google ID dan Email
        $googleId = $googleUser->getId();
        $email = $googleUser->getEmail();

        if (empty($googleId) || empty($email)) {
            Log::warning('Data profil Google tidak lengkap');
            session()->forget(['google_oauth_action', 'google_oauth_role']);

            return redirect()->route($fallbackRoute)->with('error', 'Informasi akun Google tidak lengkap (ID atau email tidak tersedia).');
        }

        // 4. Validasi status verifikasi email Google jika tersedia
        $rawUser = $googleUser->user ?? [];
        $isEmailVerified = $rawUser['email_verified'] ?? $rawUser['verified_email'] ?? true;
        if (!$isEmailVerified) {
            Log::warning('Email Google belum terverifikasi', ['email' => $email]);
            session()->forget(['google_oauth_action', 'google_oauth_role']);

            return redirect()->route($fallbackRoute)->with('error', 'Alamat email Google Anda belum terverifikasi oleh Google.');
        }

        $role = session('google_oauth_role');
        session()->forget(['google_oauth_action', 'google_oauth_role']);

        // 5. Cek apakah Google ID sudah terdaftar
        $userWithGoogleId = User::where('google_id', $googleId)->first();
        if ($userWithGoogleId) {
            // Jika avatar user belum ada atau masih berupa URL Google eksternal, simpan secara lokal
            if (!$userWithGoogleId->avatar || Str::startsWith($userWithGoogleId->avatar, ['http://', 'https://'])) {
                $localAvatar = $this->saveAvatarLocally($googleUser->getAvatar(), $googleId);
                if ($localAvatar && !Str::startsWith($localAvatar, ['http://', 'https://'])) {
                    $userWithGoogleId->update(['avatar' => $localAvatar]);
                }
            }

            Auth::login($userWithGoogleId);
            $request->session()->regenerate();

            if ($userWithGoogleId->role === 'owner') {
                return redirect()->intended(route('owner.dashboard'))->with('success', 'Selamat datang kembali di TEMPATIN, ' . $userWithGoogleId->name . '!');
            }

            return redirect()->intended(route('member.home'))->with('success', 'Selamat datang kembali di TEMPATIN, ' . $userWithGoogleId->name . '!');
        }

        // 6. Cek apakah email sudah terdaftar sebelumnya dengan metode lain
        $userWithEmail = User::where('email', $email)->first();
        if ($userWithEmail) {
            Log::warning('Percobaan Google OAuth pada email yang sudah terdaftar tanpa Google ID', ['email' => $email]);

            return redirect()->route('login')->with('error', 'Email ' . $email . ' sudah terdaftar menggunakan kata sandi biasa. Silakan masuk menggunakan email dan kata sandi Anda.');
        }

        // 7. Pengguna baru: Buat akun baru secara otomatis melalui Google OAuth dari form login
        $displayName = $googleUser->getName() ?: ($googleUser->getNickname() ?: 'Pengguna TEMPATIN');
        $avatar = $this->saveAvatarLocally($googleUser->getAvatar(), $googleId);
        $finalRole = in_array($role, ['customer', 'owner'], true) ? $role : 'customer';

        $newUser = User::create([
            'name' => $displayName,
            'email' => $email,
            'google_id' => $googleId,
            'phone' => null,
            'avatar' => $avatar,
            'password' => Hash::make(Str::random(32)),
            'role' => $finalRole,
            'email_verified_at' => now(),
        ]);

        Auth::login($newUser);
        $request->session()->regenerate();

        if ($newUser->role === 'owner') {
            return redirect()->intended(route('owner.dashboard'))->with('success', 'Selamat datang di TEMPATIN, ' . $newUser->name . '!');
        }

        return redirect()->intended(route('member.home'))->with('success', 'Selamat datang di TEMPATIN, ' . $newUser->name . '!');
    }

    /**
     * Unduh avatar dari Google dan simpan secara lokal agar tidak terkendala referrer/CORS.
     */
    protected function saveAvatarLocally(?string $avatarUrl, string $googleId): ?string
    {
        if (empty($avatarUrl)) {
            return null;
        }

        try {
            $contents = @file_get_contents($avatarUrl);
            if ($contents) {
                $filename = 'avatars/google_' . $googleId . '.png';
                Storage::disk('public')->put($filename, $contents);
                return $filename;
            }
        } catch (\Exception $e) {
            Log::warning('Gagal mengunduh avatar Google: ' . $e->getMessage());
        }

        return $avatarUrl;
    }
}
