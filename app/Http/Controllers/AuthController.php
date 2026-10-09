<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'owner') {
                return redirect()->intended(route('owner.dashboard'));
            }

            return redirect()->intended(route('member.home'));
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan form register.
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi pengguna baru.
     * Mendukung pilihan role: 'owner' (Owner) atau 'member' (dipetakan ke 'customer' di database).
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $role = ($request->role === 'owner') ? 'owner' : 'customer';

        $user = User::create([
            'name' => $request->nama,
            'phone' => $request->handphone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'owner') {
            return redirect()->route('owner.dashboard')->with('success', 'Selamat datang di TEMPATIN! Akun Owner Anda berhasil didaftarkan.');
        }

        return redirect()->route('member.home')->with('success', 'Selamat datang di TEMPATIN! Akun Anda berhasil didaftarkan.');
    }

    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    /**
     * Tampilkan form lupa password.
     */
    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }
}
