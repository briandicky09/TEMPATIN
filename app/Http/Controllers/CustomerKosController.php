<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerKosController extends Controller
{
    /**
     * Halaman kos yang sedang disewa customer (Data aktual dari database).
     */
    public function index(): View
    {
        $userId = Auth::id();

        // Hanya tampilkan kos yang sudah terkonfirmasi (sudah bayar) atau aktif dihuni
        $confirmedBookings = Booking::with(['kos', 'room'])
            ->where('customer_id', $userId)
            ->whereIn('status', ['confirmed', 'active'])
            ->latest('id')
            ->get();

        // Booking yang masih dalam proses persetujuan atau menunggu pembayaran
        $pendingBookings = Booking::with(['kos', 'room'])
            ->where('customer_id', $userId)
            ->whereIn('status', ['pending', 'approved'])
            ->latest('id')
            ->get();

        $rentedKos = $confirmedBookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'booking_code' => $booking->booking_code,
                'title' => $booking->kos->title ?? 'Kos Pilihan',
                'slug' => $booking->kos->slug ?? '#',
                'price' => (float) ($booking->kos_price ?? $booking->kos?->price ?? 0),
                'city' => $booking->kos->city ?? '-',
                'type' => $booking->kos->type ?? 'Campur',
                'thumbnail' => $booking->kos->thumbnail ?? 'assets/img/kos/1.png',
                'room_number' => $booking->room?->room_number,
                'status' => $booking->status,
                'status_label' => $booking->status_label,
                'start_date' => $booking->start_date ? $booking->start_date->format('d M Y') : '-',
                'periode' => $booking->end_date ? 'Berakhir ' . $booking->end_date->translatedFormat('d F Y') : '-',
            ];
        });

        return view('customer.kos.index', compact('rentedKos', 'pendingBookings'));
    }

    /**
     * Halaman tagihan/invoice customer (Mengambil data aktual dari database).
     */
    public function invoice(): View
    {
        $invoices = Invoice::with(['booking', 'kos'])
            ->where('customer_id', Auth::id())
            ->latest('id')
            ->get();

        return view('customer.invoice.index', compact('invoices'));
    }
}
