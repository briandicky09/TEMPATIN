@extends('layouts.admin')

@section('title', 'Audit Transaksi Booking - TEMPATIN')

@section('admin-content')
<div>
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                Audit Transaksi &amp; Pemesanan
            </h1>
            <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                Log transaksi pemesanan sewa dan verifikasi pembayaran seluruh platform (read-only).
            </p>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card" style="border: var(--border-hairline); border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden; background: #ffffff;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                <thead style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); font-weight: 600; border-bottom: var(--border-hairline);">
                    <tr>
                        <th class="py-3 px-3">Kode Booking</th>
                        <th class="py-3 px-3">Penyewa</th>
                        <th class="py-3 px-3">Properti &amp; Pemilik</th>
                        <th class="py-3 px-3">Nilai Transaksi</th>
                        <th class="py-3 px-3">Status Booking</th>
                        <th class="py-3 px-3 text-right">Tanggal Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                        <tr style="border-bottom: var(--border-hairline);">
                            <td class="py-3 px-3 font-weight-bold" style="font-family: monospace; color: var(--color-midnight-ink);">
                                {{ $b->booking_code }}
                            </td>
                            <td class="py-3 px-3">
                                <div class="font-weight-600 text-dark">{{ $b->tenant_name ?? $b->customer->name }}</div>
                                <div class="text-muted small">{{ $b->tenant_email ?? $b->customer->email }}</div>
                            </td>
                            <td class="py-3 px-3">
                                <div class="font-weight-600 text-dark">{{ $b->kos->title }}</div>
                                <div class="text-muted small">Pemilik: {{ $b->kos->owner->name ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-3 font-weight-600 text-dark">
                                Rp {{ number_format($b->total_amount, 0, ',', '.') }}
                                <div class="text-muted small">
                                    {{ $b->duration_months }} Bulan
                                </div>
                            </td>
                            <td class="py-3 px-3">
                                <span class="badge badge-light border px-2 py-1 font-weight-600">
                                    {{ ucfirst($b->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right text-muted small">
                                {{ $b->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Belum ada riwayat transaksi pemesanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3 d-flex justify-content-center">
            {{ $bookings->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
