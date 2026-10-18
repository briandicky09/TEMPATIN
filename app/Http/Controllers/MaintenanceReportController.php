<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\MaintenanceReport;
use App\Notifications\TempatinNotification;
use Illuminate\Http\Request;

class MaintenanceReportController extends Controller
{
    /**
     * Daftar laporan kerusakan milik customer/penghuni yang sedang login.
     */
    public function customerIndex()
    {
        $reports = MaintenanceReport::with(['kos', 'room', 'booking'])
            ->where('customer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('member.maintenance.index', compact('reports'));
    }

    /**
     * Tampilkan formulir pengajuan laporan kerusakan baru.
     */
    public function create()
    {
        // Hanya booking berstatus sewa yang sah (confirmed / active)
        $activeBookings = Booking::with(['kos', 'room'])
            ->where('customer_id', auth()->id())
            ->whereIn('status', ['confirmed', 'active'])
            ->latest()
            ->get();

        if ($activeBookings->isEmpty()) {
            return redirect()
                ->route('member.maintenance.index')
                ->with('warning', 'Anda belum memiliki masa sewa aktif untuk mengajukan laporan kerusakan kamar.');
        }

        return view('member.maintenance.create', compact('activeBookings'));
    }

    /**
     * Simpan pengajuan laporan kerusakan dari penghuni.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'exists:bookings,id'],
            'title' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:1000'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ]);

        $booking = Booking::with('kos.owner')->findOrFail($validated['booking_id']);

        // Otorisasi: Customer harus pemilik booking ini
        if ((int) $booking->customer_id !== (int) auth()->id()) {
            abort(403, 'Akses ditolak. Booking ini bukan milik Anda.');
        }

        // Cek status sewa yang sah
        if (!in_array($booking->status, ['confirmed', 'active', 'completed'])) {
            return back()->with('error', 'Laporan kerusakan hanya dapat diajukan untuk hunian yang telah terkonfirmasi pembayarannya.');
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('maintenance', 'public');
        }

        $report = MaintenanceReport::create([
            'booking_id' => $booking->id,
            'customer_id' => auth()->id(),
            'kos_id' => $booking->kos_id,
            'room_id' => $booking->room_id,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'photo' => $photoPath,
            'status' => 'open',
        ]);

        // Kirim notifikasi ke pemilik kos
        if ($booking->kos->owner) {
            $booking->kos->owner->notify(new TempatinNotification(
                'Laporan Kerusakan Baru',
                auth()->user()->name . ' melaporkan kerusakan: ' . $report->title . ' di ' . $booking->kos->title . '.',
                route('owner.maintenance.index'),
                'maintenance',
                'fa-tools'
            ));
        }

        return redirect()
            ->route('member.maintenance.index')
            ->with('success', 'Laporan kerusakan berhasil dikirimkan. Pemilik kos akan segera meninjau tiket Anda.');
    }

    /**
     * Daftar laporan kerusakan properti untuk pemilik kos.
     */
    public function ownerIndex(Request $request)
    {
        $ownerId = auth()->id();
        $status = $request->query('status');

        $query = MaintenanceReport::with(['customer', 'kos', 'room', 'booking'])
            ->whereHas('kos', function ($q) use ($ownerId) {
                $q->where('owner_id', $ownerId);
            });

        if ($status && in_array($status, ['open', 'in_progress', 'resolved', 'rejected'])) {
            $query->where('status', $status);
        }

        $reports = $query->latest()->paginate(15)->withQueryString();

        return view('owner.maintenance.index', compact('reports', 'status'));
    }

    /**
     * Pemilik memperbarui status penanganan laporan kerusakan.
     */
    public function ownerUpdateStatus(Request $request, MaintenanceReport $report)
    {
        // Otorisasi: Pemilik kos yang berhak
        if ((int) $report->kos->owner_id !== (int) auth()->id()) {
            abort(403, 'Akses ditolak. Properti ini bukan milik Anda.');
        }

        $validated = $request->validate([
            'status' => ['required', 'in:open,in_progress,resolved,rejected'],
            'owner_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $report->update([
            'status' => $validated['status'],
            'owner_notes' => $validated['owner_notes'] ?? $report->owner_notes,
        ]);

        // Notifikasi ke penghuni
        if ($report->customer) {
            $statusLabel = match ($validated['status']) {
                'in_progress' => 'sedang dalam proses penanganan',
                'resolved' => 'telah berhasil diselesaikan',
                'rejected' => 'ditolak',
                default => 'diperbarui',
            };

            $report->customer->notify(new TempatinNotification(
                'Status Laporan Kerusakan Diperbarui',
                'Tiket perbaikan "' . $report->title . '" Anda ' . $statusLabel . '.',
                route('member.maintenance.index'),
                'maintenance',
                $validated['status'] === 'resolved' ? 'fa-check-circle' : 'fa-tools'
            ));
        }

        return back()->with('success', 'Status laporan kerusakan berhasil diperbarui.');
    }
}
