<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Room;
use App\Notifications\TempatinNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OwnerBookingController extends Controller
{
    /**
     * Halaman daftar booking masuk untuk pemilik kos.
     */
    public function index(Request $request): View
    {
        $owner = $request->user();
        $ownerKosIds = $owner->kos()->pluck('id');

        $query = Booking::with(['customer', 'kos', 'room', 'invoice.payments'])
            ->whereIn('kos_id', $ownerKosIds);

        // Filter status jika ada
        $status = $request->query('status');
        if ($status && in_array($status, ['pending', 'approved', 'confirmed', 'active', 'completed', 'rejected', 'cancelled'])) {
            $query->where('status', $status);
        }

        // Pencarian berdasarkan kode booking, nama penyewa, atau nama kos
        $search = $request->query('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhere('tenant_name', 'like', "%{$search}%")
                  ->orWhereHas('kos', function ($kq) use ($search) {
                      $kq->where('title', 'like', "%{$search}%");
                  });
            });
        }

        $bookings = $query->latest('id')->paginate(10)->withQueryString();

        // Hitung ringkasan status booking
        $counts = [
            'all' => Booking::whereIn('kos_id', $ownerKosIds)->count(),
            'pending' => Booking::whereIn('kos_id', $ownerKosIds)->where('status', 'pending')->count(),
            'approved' => Booking::whereIn('kos_id', $ownerKosIds)->where('status', 'approved')->count(),
            'confirmed' => Booking::whereIn('kos_id', $ownerKosIds)->where('status', 'confirmed')->count(),
            'active' => Booking::whereIn('kos_id', $ownerKosIds)->where('status', 'active')->count(),
            'rejected' => Booking::whereIn('kos_id', $ownerKosIds)->where('status', 'rejected')->count(),
        ];

        return view('owner.booking.index', compact('bookings', 'counts', 'status', 'search'));
    }

    /**
     * Halaman detail booking kos untuk pemilik kos.
     */
    public function show(Request $request, string $bookingCode): View
    {
        $owner = $request->user();

        $booking = Booking::with(['customer', 'kos.owner', 'room', 'invoice.payments', 'contract'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        // Otorisasi Anti-IDOR: Owner hanya boleh melihat booking properti miliknya
        if ((int) $booking->kos->owner_id !== (int) $owner->id) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengelola booking ini.');
        }

        // Ambil daftar kamar yang tersedia di kos ini (untuk penugasan kamar jika belum ada)
        $availableRooms = $booking->kos->rooms()->where('status', 'available')->get();

        return view('owner.booking.show', compact('booking', 'availableRooms'));
    }

    /**
     * Setujui pengajuan booking baru oleh pemilik kos.
     */
    public function approve(Request $request, string $bookingCode): RedirectResponse
    {
        $owner = $request->user();

        $booking = Booking::with(['customer', 'kos'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        // Otorisasi Anti-IDOR
        if ((int) $booking->kos->owner_id !== (int) $owner->id) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menyetujui booking ini.');
        }

        // Validasi transisi status: hanya pending yang bisa disetujui
        if ($booking->status !== 'pending') {
            return redirect()
                ->route('owner.bookings.show', $booking->booking_code)
                ->with('error', 'Hanya booking berstatus "Menunggu Persetujuan" yang dapat disetujui.');
        }

        // Opsi penugasan kamar individual jika dipilih owner
        $roomId = $request->input('room_id');
        if ($roomId) {
            $room = Room::where('kos_id', $booking->kos_id)->where('id', $roomId)->first();
            if ($room && $room->status !== 'available') {
                return redirect()
                    ->route('owner.bookings.show', $booking->booking_code)
                    ->with('error', 'Kamar nomor ' . $room->room_number . ' saat ini tidak tersedia.');
            }
        }

        DB::transaction(function () use ($booking, $roomId) {
            $updateData = ['status' => 'approved'];
            if ($roomId) {
                $updateData['room_id'] = $roomId;
            }

            $booking->update($updateData);

            // Pastikan invoice sudah terbit
            $invoice = $booking->invoice ?? Invoice::where('booking_id', $booking->id)->first();
            if (!$invoice) {
                Invoice::createFromBooking($booking);
            }

            // Kirim notifikasi ke customer
            $booking->customer?->notify(new TempatinNotification(
                'Booking Disetujui!',
                'Pengajuan sewa Anda untuk ' . $booking->kos->title . ' telah disetujui oleh pemilik. Silakan selesaikan pembayaran.',
                route('member.booking.show', $booking->booking_code),
                'booking',
                'fa-check-circle'
            ));
        });

        return redirect()
            ->route('owner.bookings.show', $booking->booking_code)
            ->with('success', 'Booking berhasil disetujui! Customer kini dapat melanjutkan pembayaran melalui Midtrans.');
    }

    /**
     * Tolak pengajuan booking oleh pemilik kos dengan mencantumkan alasan.
     */
    public function reject(Request $request, string $bookingCode): RedirectResponse
    {
        $owner = $request->user();

        $booking = Booking::with(['customer', 'kos', 'invoice'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        // Otorisasi Anti-IDOR
        if ((int) $booking->kos->owner_id !== (int) $owner->id) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk menolak booking ini.');
        }

        // Cegah penolakan jika booking sudah dibayar/selesai
        if (in_array($booking->status, ['confirmed', 'active', 'completed'])) {
            return redirect()
                ->route('owner.bookings.show', $booking->booking_code)
                ->with('error', 'Booking yang sudah dibayar atau sedang aktif tidak dapat ditolak.');
        }

        if ($booking->status === 'rejected') {
            return redirect()
                ->route('owner.bookings.show', $booking->booking_code)
                ->with('error', 'Booking ini sudah ditolak sebelumnya.');
        }

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'min:3', 'max:500'],
        ], [
            'rejection_reason.required' => 'Mohon cantumkan alasan penolakan booking untuk informasi penyewa.',
            'rejection_reason.min' => 'Alasan penolakan minimal 3 karakter.',
            'rejection_reason.max' => 'Alasan penolakan maksimal 500 karakter.',
        ]);

        DB::transaction(function () use ($booking, $validated) {
            $booking->update([
                'status' => 'rejected',
                'rejection_reason' => $validated['rejection_reason'],
            ]);

            // Batalkan invoice jika belum dibayar
            if ($booking->invoice && $booking->invoice->status === 'unpaid') {
                $booking->invoice->update(['status' => 'cancelled']);
            }

            // Kirim notifikasi penolakan ke customer
            $booking->customer?->notify(new TempatinNotification(
                'Booking Ditolak',
                'Pemesanan Anda untuk ' . $booking->kos->title . ' tidak dapat disetujui: ' . $validated['rejection_reason'],
                route('member.booking.show', $booking->booking_code),
                'booking',
                'fa-times-circle'
            ));
        });

        return redirect()
            ->route('owner.bookings.show', $booking->booking_code)
            ->with('success', 'Booking berhasil ditolak dan notifikasi telah dikirimkan ke penyewa.');
    }

    /**
     * Check-in penyewa ke kamar kos (hanya untuk booking yang sudah lunas/confirmed).
     */
    public function checkIn(Request $request, string $bookingCode): RedirectResponse
    {
        $owner = $request->user();

        $booking = Booking::with(['customer', 'kos', 'room'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        if ((int) $booking->kos->owner_id !== (int) $owner->id) {
            abort(403, 'Akses ditolak.');
        }

        if ($booking->status !== 'confirmed') {
            return redirect()
                ->route('owner.bookings.show', $booking->booking_code)
                ->with('error', 'Check-in hanya dapat dilakukan untuk pesanan yang telah dikonfirmasi pembayarannya.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'active']);

            if ($booking->room_id) {
                Room::where('id', $booking->room_id)->update(['status' => 'occupied']);
            }

            $booking->customer?->notify(new TempatinNotification(
                'Check-in Berhasil',
                'Selamat! Status sewa Anda untuk ' . $booking->kos->title . ' kini telah aktif.',
                route('customer.kos.index'),
                'booking',
                'fa-key'
            ));
        });

        return redirect()
            ->route('owner.bookings.show', $booking->booking_code)
            ->with('success', 'Penyewa berhasil di-check-in. Status hunian kini telah Aktif.');
    }

    /**
     * Check-out penyewa setelah masa sewa berakhir.
     */
    public function checkOut(Request $request, string $bookingCode): RedirectResponse
    {
        $owner = $request->user();

        $booking = Booking::with(['customer', 'kos', 'room'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        if ((int) $booking->kos->owner_id !== (int) $owner->id) {
            abort(403, 'Akses ditolak.');
        }

        if ($booking->status !== 'active') {
            return redirect()
                ->route('owner.bookings.show', $booking->booking_code)
                ->with('error', 'Check-out hanya dapat dilakukan untuk hunian yang sedang aktif.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update(['status' => 'completed']);

            if ($booking->room_id) {
                Room::where('id', $booking->room_id)->update(['status' => 'available']);
            }

            $booking->customer?->notify(new TempatinNotification(
                'Masa Sewa Berakhir',
                'Masa sewa Anda untuk ' . $booking->kos->title . ' telah diselesaikan. Terima kasih atas kepercayaan Anda di TEMPATIN.',
                route('customer.kos.index'),
                'booking',
                'fa-door-open'
            ));
        });

        return redirect()
            ->route('owner.bookings.show', $booking->booking_code)
            ->with('success', 'Check-out berhasil diproses. Kamar kini kembali berstatus Tersedia.');
    }
}
