<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Kos;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Form booking kos.
     */
    public function booking(string $slug): View
    {
        $kos = $this->findKos($slug);

        return view('member.booking.index', compact('kos'));
    }

    /**
     * Menyimpan data booking baru ke database.
     */
    public function store(StoreBookingRequest $request, string $slug): RedirectResponse
    {
        $kos = $this->findKos($slug);
        $validated = $request->validated();

        $durationMonths = (int) $validated['duration_months'];
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = $startDate->copy()->addMonths($durationMonths);

        // Perhitungan finansial strictly server-side
        $kosPrice = (float) $kos->price;
        $subtotal = $kosPrice * $durationMonths;
        $adminFee = Booking::DEFAULT_ADMIN_FEE;
        $totalAmount = $subtotal + $adminFee;

        $booking = DB::transaction(function () use (
            $request,
            $kos,
            $validated,
            $durationMonths,
            $startDate,
            $endDate,
            $kosPrice,
            $subtotal,
            $adminFee,
            $totalAmount
        ) {
            $booking = Booking::create([
                'customer_id' => $request->user()->id,
                'kos_id' => $kos->id,
                'booking_code' => Booking::generateBookingCode(),
                'tenant_name' => $validated['tenant_name'],
                'tenant_phone' => $validated['tenant_phone'],
                'tenant_email' => $validated['tenant_email'],
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'duration_months' => $durationMonths,
                'kos_price' => $kosPrice,
                'subtotal' => $subtotal,
                'admin_fee' => $adminFee,
                'total_amount' => $totalAmount,
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);

            // Buat Invoice secara otomatis di dalam DB::transaction yang sama
            Invoice::createFromBooking($booking);

            return $booking;
        });

        return redirect()
            ->route('member.booking.show', $booking->booking_code)
            ->with('success', 'Booking berhasil dibuat! Pesanan Anda saat ini berstatus pending.');
    }

    /**
     * Halaman detail booking untuk customer.
     */
    public function show(string $bookingCode): View
    {
        $booking = Booking::with(['kos.owner', 'customer'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        // Otorisasi: Customer hanya berhak melihat booking miliknya sendiri
        if ((int) $booking->customer_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat booking ini.');
        }

        return view('member.booking.show', compact('booking'));
    }

    /**
     * Ringkasan pembayaran setelah form booking diisi.
     */
    public function payment(Request $request, string $slug): View
    {
        $kos = $this->findKos($slug);
        $booking = $request->validate([
            'tenant_name' => ['required', 'string', 'max:100'],
            'tenant_email' => ['required', 'email', 'max:150'],
            'tenant_phone' => ['required', 'string', 'max:30'],
            'check_in' => ['required', 'date'],
            'duration' => ['required', 'integer', 'min:1', 'max:12'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $booking['duration_label'] = $booking['duration'] . ' Bulan';
        $booking['subtotal'] = $kos['price'] * $booking['duration'];
        $booking['admin_fee'] = 25000;
        $booking['total'] = $booking['subtotal'] + $booking['admin_fee'];

        return view('member.booking.payment', compact('kos', 'booking'));
    }

    /**
     * Konfirmasi pembayaran dan kembali ke daftar invoice.
     */
    public function confirmPayment(Request $request)
    {
        $request->validate([
            'payment_method' => ['required', 'string', 'max:50'],
        ]);

        return redirect()->route('member.invoice.index')->with('success', 'Booking berhasil dibuat. Silakan ikuti instruksi pembayaran pada invoice Anda.');
    }

    private function findKos(string $slug): Kos
    {
        return Kos::with('owner')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();
    }

    /**
     * Halaman profil member.
     */
    public function profile(): View
    {
        return view('member.profile.index', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update profil member.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'avatar.image' => 'File foto profil harus berupa gambar.',
            'avatar.mimes' => 'Format foto profil harus jpeg, png, jpg, webp, atau svg.',
            'avatar.max' => 'Ukuran foto profil maksimal 2MB.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user->name = $validated['name'];
        if (isset($validated['phone'])) {
            $user->phone = $validated['phone'];
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        if (!empty($validated['password'])) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('member.profile')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Halaman favorit kos member.
     */
    public function favorit(): View
    {
        $favoriteSlugs = session('member_favorites', []);

        $favoriteKos = Kos::with(['facilities', 'owner', 'photos'])
            ->whereIn('slug', $favoriteSlugs)
            ->where('status', 'active')
            ->get();

        $recommendedKos = Kos::with(['facilities', 'owner', 'photos'])
            ->where('status', 'active')
            ->whereNotIn('slug', $favoriteSlugs)
            ->latest('id')
            ->take(6)
            ->get();

        return view('member.favorit.index', [
            'favoriteKos' => $favoriteKos,
            'recommendedKos' => $recommendedKos,
        ]);
    }

    /**
     * Toggle status simpan kos ke favorit (AJAX).
     */
    public function toggleFavorit(Request $request): \Illuminate\Http\JsonResponse
    {
        $slug = $request->input('slug');
        if (!$slug) {
            return response()->json(['success' => false, 'message' => 'Slug kos tidak valid.'], 400);
        }

        $favorites = session('member_favorites', []);

        if (in_array($slug, $favorites)) {
            $favorites = array_values(array_diff($favorites, [$slug]));
            session(['member_favorites' => $favorites]);
            $isFavorite = false;
            $message = 'Kos berhasil dihapus dari daftar favorit.';
        } else {
            $favorites[] = $slug;
            session(['member_favorites' => $favorites]);
            $isFavorite = true;
            $message = 'Kos berhasil ditambahkan ke daftar favorit!';
        }

        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite,
            'message' => $message,
            'count' => count($favorites),
        ]);
    }

    /**
     * Halaman daftar invoice member (berdasarkan customer yang sedang login).
     */
    public function invoice(): View
    {
        $invoices = Invoice::with(['booking', 'kos'])
            ->where('customer_id', Auth::id())
            ->latest('id')
            ->get();

        return view('member.invoice.index', compact('invoices'));
    }

    /**
     * Halaman detail invoice member (dengan proteksi otorisasi anti-IDOR).
     */
    public function invoiceDetail(string $nomor): View
    {
        $invoice = Invoice::with(['booking.kos', 'kos', 'customer', 'payments'])
            ->where(function ($query) use ($nomor) {
                $query->where('invoice_number', $nomor);
                if (is_numeric($nomor)) {
                    $query->orWhere('id', $nomor);
                }
            })
            ->firstOrFail();

        // Otorisasi: Customer hanya berhak melihat invoice miliknya sendiri
        if ((int) $invoice->customer_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat invoice ini.');
        }

        return view('member.invoice.show', compact('invoice'));
    }

    /**
     * Halaman notifikasi member.
     */
    public function notifikasi(): View
    {
        $notifications = [
            [
                'title' => 'Tagihan Baru',
                'message' => 'Tagihan untuk Kos Putri Melati bulan ini telah terbit. Segera lakukan pembayaran.',
                'time' => '2 jam yang lalu',
                'is_read' => false,
                'icon' => 'fa-file-invoice text-danger',
            ],
            [
                'title' => 'Pengingat Pembayaran',
                'message' => 'Jatuh tempo pembayaran tagihan Kos Putri Melati adalah 3 hari lagi.',
                'time' => '1 hari yang lalu',
                'is_read' => true,
                'icon' => 'fa-clock text-warning',
            ],
            [
                'title' => 'Booking Dikonfirmasi',
                'message' => 'Booking Anda untuk Kos Putri Melati telah dikonfirmasi oleh pemilik.',
                'time' => '3 hari yang lalu',
                'is_read' => true,
                'icon' => 'fa-check text-success',
            ],
        ];

        return view('member.notifikasi.index', compact('notifications'));
    }
}
