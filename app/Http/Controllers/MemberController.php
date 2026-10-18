<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Favorite;
use App\Models\Invoice;
use App\Models\Kos;
use App\Models\Payment;
use App\Services\MidtransService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class MemberController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Form booking kos.
     */
    public function booking(string $slug): View
    {
        $kos = $this->findKos($slug);

        return view('member.booking.index', compact('kos'));
    }

    /**
     * Menyimpan data booking baru ke database dan menyiapkan transaksi Midtrans.
     */
    public function store(StoreBookingRequest $request, string $slug): RedirectResponse
    {
        $kos = $this->findKos($slug);
        $validated = $request->validated();

        $durationMonths = (int) $validated['duration_months'];
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = $startDate->copy()->addMonths($durationMonths);

        // Perhitungan finansial strictly server-side berdasarkan harga database
        $kosPrice = (float) $kos->price;
        $subtotal = $kosPrice * $durationMonths;
        $adminFee = Booking::DEFAULT_ADMIN_FEE;
        $totalAmount = $subtotal + $adminFee;

        // Proteksi cegah double submission akibat tombol diklik berulang kali
        $existingBooking = Booking::with('invoice')
            ->where('customer_id', $request->user()->id)
            ->where('kos_id', $kos->id)
            ->where('start_date', $startDate->format('Y-m-d'))
            ->where('duration_months', $durationMonths)
            ->where('status', 'pending')
            ->where('created_at', '>=', now()->subMinutes(5))
            ->latest('id')
            ->first();

        if ($existingBooking && $existingBooking->invoice) {
            $booking = $existingBooking;
            $invoice = $existingBooking->invoice;
        } else {
            [$booking, $invoice] = DB::transaction(function () use (
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
                $invoice = Invoice::createFromBooking($booking);

                // Kirim notifikasi pengajuan sewa baru ke pemilik kos
                try {
                    $kos->owner?->notify(new \App\Notifications\TempatinNotification(
                        'Booking Baru Masuk',
                        'Pengajuan sewa baru dari ' . $booking->tenant_name . ' untuk ' . $kos->title . '.',
                        route('owner.bookings.show', $booking->booking_code),
                        'booking',
                        'fa-calendar-check'
                    ));
                } catch (\Throwable $e) {
                    // Abaikan jika background notification gagal
                }

                return [$booking, $invoice];
            });
        }

        // Buat atau gunakan kembali Snap Token dari Midtrans Sandbox
        try {
            $this->midtransService->getOrCreateSnapTransaction($booking, $invoice);
        } catch (\Throwable $e) {
            Log::error('Midtrans transaction error saat booking store', [
                'booking_code' => $booking->booking_code,
                'message' => $e->getMessage(),
            ]);
            // Tetap redirect ke halaman pembayaran agar user melihat petunjuk dan dapat retry
        }

        return redirect()
            ->route('member.booking.payment', ['slug' => $kos->slug, 'booking_code' => $booking->booking_code])
            ->with('success', 'Booking berhasil dibuat! Silakan selesaikan pembayaran melalui Midtrans.');
    }

    /**
     * Halaman detail booking untuk customer.
     */
    public function show(string $bookingCode): View
    {
        $booking = Booking::with(['kos.owner', 'customer', 'invoice.payments'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        // Otorisasi: Customer hanya berhak melihat booking miliknya sendiri
        if ((int) $booking->customer_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk melihat booking ini.');
        }

        $invoice = $booking->invoice;
        $snapToken = null;
        $redirectUrl = null;

        if ($booking->status === 'pending' && $invoice) {
            $payment = Payment::where('invoice_id', $invoice->id)
                ->where('status', 'pending')
                ->whereNotNull('snap_token')
                ->latest('id')
                ->first();

            // Auto-sinkronisasi status dengan Midtrans API saat halaman dibuka
            if ($payment && $payment->order_id) {
                try {
                    $statusObj = $this->midtransService->fetchTransactionStatus($payment->order_id);
                    if ($statusObj && in_array($statusObj->transaction_status ?? '', ['settlement', 'capture', 'expire', 'deny', 'cancel'])) {
                        $this->midtransService->handleNotification((array) $statusObj);
                        $booking->refresh();
                        $invoice->refresh();
                    }
                } catch (\Throwable $e) {
                    // Abaikan jika network issue
                }
            }

            if ($booking->status === 'pending') {
                if ($payment && $payment->status === 'pending') {
                    $snapToken = $payment->snap_token;
                    $redirectUrl = $payment->snap_redirect_url;
                } else {
                    try {
                        $midtransData = $this->midtransService->getOrCreateSnapTransaction($booking, $invoice);
                        $snapToken = $midtransData['snap_token'];
                        $redirectUrl = $midtransData['redirect_url'];
                    } catch (\Throwable $e) {
                        // Abaikan error pada view show
                    }
                }
            }
        }

        $clientKey = config('services.midtrans.client_key') ?: config('midtrans.client_key');

        return view('member.booking.show', compact('booking', 'invoice', 'snapToken', 'redirectUrl', 'clientKey'));
    }

    /**
     * Unduh nota bukti pembayaran resmi dalam format PDF.
     */
    public function downloadNota(Request $request, string $bookingCode)
    {
        $booking = Booking::with(['kos.owner', 'customer', 'invoice.payments'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        // Otorisasi anti-IDOR: Customer hanya berhak mengunduh nota miliknya sendiri
        if ((int) $booking->customer_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengunduh nota booking ini.');
        }

        $invoice = $booking->invoice ?? Invoice::where('booking_id', $booking->id)->first();

        // Auto-sinkronisasi status dengan Midtrans API jika masih berstatus pending
        if ($booking->status === 'pending') {
            $pendingPayment = $invoice ? $invoice->payments()->whereNotNull('order_id')->latest('id')->first() : null;
            if ($pendingPayment && $pendingPayment->order_id) {
                try {
                    $statusObj = $this->midtransService->fetchTransactionStatus($pendingPayment->order_id);
                    if ($statusObj && in_array($statusObj->transaction_status ?? '', ['settlement', 'capture', 'expire', 'deny', 'cancel'])) {
                        $this->midtransService->handleNotification((array) $statusObj);
                        $booking->refresh();
                        if ($invoice) {
                            $invoice->refresh();
                        }
                    }
                } catch (\Throwable $e) {
                    // Abaikan jika network issue
                }
            }
        }

        // Jika status masih pending, arahkan kembali dengan notifikasi
        if ($booking->status === 'pending') {
            return redirect()
                ->route('member.booking.show', $booking->booking_code)
                ->with('error', 'Nota pembayaran belum tersedia karena pesanan belum selesai dibayar.');
        }

        if (in_array($booking->status, ['cancelled', 'rejected'])) {
            return redirect()
                ->route('member.booking.show', $booking->booking_code)
                ->with('error', 'Nota tidak tersedia untuk pesanan yang telah dibatalkan.');
        }

        if (!$invoice) {
            $invoice = Invoice::createFromBooking($booking);
        }

        $payment = $invoice->payments()->whereIn('status', ['paid', 'settlement', 'capture', 'success'])->latest('id')->first()
            ?? $invoice->payments()->latest('id')->first();

        $pdf = Pdf::loadView('member.booking.nota_pdf', compact('booking', 'invoice', 'payment'));
        $pdf->setPaper('a4', 'portrait');

        $filename = 'Nota-Pembayaran-' . preg_replace('/[^A-Za-z0-9\-]/', '', $booking->booking_code) . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Redirect langsung ke gerbang pembayaran Midtrans resmi (tanpa halaman perantara).
     */
    public function payment(Request $request, string $slug): RedirectResponse
    {
        $kos = $this->findKos($slug);

        // Jika request membawa input form booking lengkap (alur direct POST ke payment)
        if ($request->isMethod('post') && ($request->has('start_date') || $request->has('check_in'))) {
            return $this->store(app(\App\Http\Requests\StoreBookingRequest::class), $slug);
        }

        // Ambil booking_code dari query string / request input
        $bookingCode = $request->input('booking_code') ?? $request->query('booking_code');

        $booking = null;
        if ($bookingCode) {
            $booking = Booking::with(['kos.owner', 'customer', 'invoice.payments'])
                ->where('booking_code', $bookingCode)
                ->first();
        }

        // Jika booking_code tidak spesifik, cari booking berstatus pending milik customer saat ini
        if (!$booking) {
            $booking = Booking::with(['kos.owner', 'customer', 'invoice.payments'])
                ->where('customer_id', Auth::id())
                ->where('kos_id', $kos->id)
                ->where('status', 'pending')
                ->latest('id')
                ->first();
        }

        if (!$booking) {
            return redirect()
                ->route('member.booking.create', $kos->slug)
                ->with('error', 'Silakan lengkapi data pemesanan terlebih dahulu.');
        }

        // Otorisasi anti-IDOR: Customer hanya berhak membayar booking miliknya sendiri
        if ((int) $booking->customer_id !== (int) Auth::id()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk membayar booking ini.');
        }

        // Jika booking ditolak oleh pemilik
        if ($booking->status === 'rejected') {
            return redirect()
                ->route('member.booking.show', $booking->booking_code)
                ->with('error', 'Pemesanan ini telah ditolak oleh pemilik kos dan tidak dapat dibayar.');
        }

        // Jika booking dibatalkan
        if ($booking->status === 'cancelled') {
            return redirect()
                ->route('member.booking.show', $booking->booking_code)
                ->with('error', 'Pemesanan ini telah dibatalkan.');
        }

        // Jika booking sudah confirmed / invoice lunas, arahkan langsung ke halaman detail
        if (in_array($booking->status, ['confirmed', 'active', 'completed'])) {
            return redirect()
                ->route('member.booking.show', $booking->booking_code)
                ->with('success', 'Pemesanan ini sudah berhasil dibayar dan dikonfirmasi.');
        }

        // Dapatkan invoice terkait
        $invoice = $booking->invoice ?? Invoice::where('booking_id', $booking->id)->first();
        if (!$invoice) {
            $invoice = Invoice::createFromBooking($booking);
        }

        // Alur persetujuan owner sebelum pembayaran untuk booking baru
        if ($booking->status === 'pending') {
            // Backward compatibility: izinkan jika transaksi snap sudah ada sebelumnya
            $hasExistingSnap = $invoice->payments()->whereNotNull('snap_token')->exists();
            if (!$hasExistingSnap) {
                return redirect()
                    ->route('member.booking.show', $booking->booking_code)
                    ->with('info', 'Pemesanan Anda sedang menunggu persetujuan dari pemilik kos sebelum pembayaran dapat dilakukan.');
            }
        }

        // Ambil atau buat transaksi Midtrans Snap token & redirect URL
        try {
            $midtransData = $this->midtransService->getOrCreateSnapTransaction($booking, $invoice);
            $redirectUrl = $midtransData['redirect_url'] ?? null;

            if (!empty($redirectUrl)) {
                return redirect()->away($redirectUrl);
            }
        } catch (\Throwable $e) {
            Log::error('Gagal mendapatkan redirect URL Midtrans saat menuju payment gateway', [
                'booking_code' => $booking->booking_code,
                'message' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('member.booking.show', $booking->booking_code)
            ->with('error', 'Gagal membuka gerbang pembayaran Midtrans. Silakan coba beberapa saat lagi.');
    }

    /**
     * Konfirmasi pembayaran dan kembali ke daftar invoice atau detail booking.
     */
    public function confirmPayment(Request $request): RedirectResponse
    {
        $bookingCode = $request->input('booking_code');
        if ($bookingCode) {
            return redirect()->route('member.booking.show', $bookingCode)
                ->with('success', 'Pembayaran sedang diproses dan diverifikasi.');
        }

        return redirect()->route('member.invoice.index')
            ->with('success', 'Booking berhasil dibuat. Silakan ikuti instruksi pembayaran pada invoice Anda.');
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
        $sessionFavorites = session('member_favorites', []);
        $dbFavorites = [];

        if (Auth::check()) {
            $dbFavorites = Auth::user()->favoritedKos()->pluck('slug')->toArray();
        }

        $favoriteSlugs = array_values(array_unique(array_merge($sessionFavorites, $dbFavorites)));

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

        $kos = Kos::where('slug', $slug)->first();
        if (!$kos) {
            return response()->json(['success' => false, 'message' => 'Kos tidak ditemukan.'], 404);
        }

        $sessionFavorites = session('member_favorites', []);
        $isFavorite = false;

        if (Auth::check()) {
            $existing = Favorite::where('user_id', Auth::id())
                ->where('kos_id', $kos->id)
                ->first();

            if ($existing) {
                $existing->delete();
                $isFavorite = false;
                $message = 'Kos berhasil dihapus dari daftar favorit.';
                $sessionFavorites = array_values(array_diff($sessionFavorites, [$slug]));
            } else {
                Favorite::firstOrCreate([
                    'user_id' => Auth::id(),
                    'kos_id' => $kos->id,
                ]);
                $isFavorite = true;
                $message = 'Kos berhasil ditambahkan ke daftar favorit!';
                if (!in_array($slug, $sessionFavorites)) {
                    $sessionFavorites[] = $slug;
                }
            }
            session(['member_favorites' => $sessionFavorites]);
            $count = Auth::user()->favorites()->count();
        } else {
            if (in_array($slug, $sessionFavorites)) {
                $sessionFavorites = array_values(array_diff($sessionFavorites, [$slug]));
                $isFavorite = false;
                $message = 'Kos berhasil dihapus dari daftar favorit.';
            } else {
                $sessionFavorites[] = $slug;
                $isFavorite = true;
                $message = 'Kos berhasil ditambahkan ke daftar favorit!';
            }
            session(['member_favorites' => $sessionFavorites]);
            $count = count($sessionFavorites);
        }

        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite,
            'message' => $message,
            'count' => $count,
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

        // Auto-sinkronisasi status dengan Midtrans API jika invoice masih berstatus unpaid
        if ($invoice->status === 'unpaid') {
            $pendingPayment = $invoice->payments()->where('status', 'pending')->whereNotNull('order_id')->latest('id')->first();
            if ($pendingPayment && $pendingPayment->order_id) {
                try {
                    $statusObj = $this->midtransService->fetchTransactionStatus($pendingPayment->order_id);
                    if ($statusObj && in_array($statusObj->transaction_status ?? '', ['settlement', 'capture', 'expire', 'deny', 'cancel'])) {
                        $this->midtransService->handleNotification((array) $statusObj);
                        $invoice->refresh();
                    }
                } catch (\Throwable $e) {
                    // Abaikan jika network issue
                }
            }
        }

        return view('member.invoice.show', compact('invoice'));
    }

    /**
     * Halaman notifikasi member.
     */
    public function notifikasi(): View
    {
        $user = Auth::user();
        $dbNotifs = $user->notifications()->latest()->take(30)->get();

        $notifications = $dbNotifs->map(function ($n) {
            return [
                'id' => $n->id,
                'title' => $n->data['title'] ?? 'Pemberitahuan',
                'message' => $n->data['message'] ?? '',
                'time' => $n->created_at->diffForHumans(),
                'is_read' => $n->read_at !== null,
                'icon' => ($n->data['icon'] ?? 'fa-bell') . ' text-primary',
                'action_url' => $n->data['action_url'] ?? null,
            ];
        })->toArray();

        // Tandai seluruh notifikasi unread sebagai sudah dibaca saat membuka halaman ini
        $user->unreadNotifications->markAsRead();

        return view('member.notifikasi.index', compact('notifications'));
    }
}
