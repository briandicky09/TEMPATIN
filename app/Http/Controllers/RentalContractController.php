<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RentalContract;
use App\Notifications\TempatinNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RentalContractController extends Controller
{
    /**
     * Tampilkan dokumen kontrak sewa digital di layar.
     */
    public function show(string $contractNumber)
    {
        $contract = RentalContract::with(['booking.kos.owner', 'booking.customer', 'booking.room'])
            ->where('contract_number', $contractNumber)
            ->firstOrFail();

        $this->authorizeAccess($contract);

        $user = auth()->user();
        $isCustomer = (int) $contract->booking->customer_id === (int) $user->id;
        $isOwner = (int) $contract->booking->kos->owner_id === (int) $user->id;

        return view('contracts.show', compact('contract', 'isCustomer', 'isOwner'));
    }

    /**
     * Tanda tangani / setujui kontrak sewa secara digital oleh customer.
     */
    public function sign(Request $request, string $contractNumber)
    {
        $contract = RentalContract::with(['booking.kos.owner', 'booking.customer'])
            ->where('contract_number', $contractNumber)
            ->firstOrFail();

        // Otorisasi: Hanya customer terkait yang berhak menyetujui
        if ((int) $contract->booking->customer_id !== (int) auth()->id()) {
            abort(403, 'Hanya penyewa terdaftar yang dapat menandatangani kontrak sewa ini.');
        }

        if ($contract->isSigned()) {
            return back()->with('info', 'Kontrak sewa digital ini sudah disepakati sebelumnya.');
        }

        $request->validate([
            'agree' => ['required', 'accepted'],
        ], [
            'agree.accepted' => 'Anda wajib mencentang persetujuan syarat dan ketentuan kontrak.',
        ]);

        $contract->update([
            'signed_at' => now(),
            'signer_ip' => $request->ip(),
            'status' => 'active',
        ]);

        // Notifikasi ke pemilik kos
        if ($contract->booking->kos->owner) {
            $contract->booking->kos->owner->notify(new TempatinNotification(
                'Kontrak Sewa Ditandatangani',
                ($contract->booking->customer->name ?? 'Penyewa') . ' telah menyetujui kontrak sewa digital untuk ' . $contract->booking->kos->title . '.',
                route('contracts.show', $contract->contract_number),
                'contract',
                'fa-file-signature'
            ));
        }

        return back()->with('success', 'Kontrak sewa digital berhasil ditandatangani dan telah aktif.');
    }

    /**
     * Unduh kontrak sewa resmi dalam format PDF.
     */
    public function downloadPdf(string $contractNumber)
    {
        $contract = RentalContract::with(['booking.kos.owner', 'booking.customer', 'booking.room'])
            ->where('contract_number', $contractNumber)
            ->firstOrFail();

        $this->authorizeAccess($contract);

        $pdf = Pdf::loadView('contracts.pdf', compact('contract'));
        $pdf->setPaper('a4', 'portrait');

        $safeCode = preg_replace('/[^A-Za-z0-9\-]/', '', $contract->contract_number);
        return $pdf->download("Kontrak-Sewa-{$safeCode}.pdf");
    }

    /**
     * Akses atau generate kontrak dari booking code.
     */
    public function forBooking(string $bookingCode)
    {
        $booking = Booking::with(['kos.owner', 'customer', 'room'])
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        $user = auth()->user();
        $isCustomer = (int) $booking->customer_id === (int) $user->id;
        $isOwner = (int) $booking->kos->owner_id === (int) $user->id;
        $isAdmin = $user->role === 'admin';

        if (!$isCustomer && !$isOwner && !$isAdmin) {
            abort(403, 'Akses ditolak.');
        }

        $contract = RentalContract::firstOrCreateForBooking($booking);

        return redirect()->route('contracts.show', $contract->contract_number);
    }

    /**
     * Helper otorisasi anti-IDOR.
     */
    protected function authorizeAccess(RentalContract $contract): void
    {
        $user = auth()->user();
        $isCustomer = (int) $contract->booking->customer_id === (int) $user->id;
        $isOwner = (int) $contract->booking->kos->owner_id === (int) $user->id;
        $isAdmin = $user->role === 'admin';

        if (!$isCustomer && !$isOwner && !$isAdmin) {
            abort(403, 'Akses ditolak. Anda tidak berhak mengakses dokumen kontrak sewa ini.');
        }
    }
}
