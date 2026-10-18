@extends('layouts.admin')

@section('title', 'Dashboard Superadmin - TEMPATIN')

@section('admin-content')
<div>
    <!-- HEADER -->
    <div class="mb-4">
        <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
            Ringkasan Eksekutif Platform
        </h1>
        <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
            Metrik operasional, pertumbuhan pengguna, dan performa transaksi platform TEMPATIN.
        </p>
    </div>

    <!-- METRICS 5 CARDS -->
    <div class="row mb-4">
        <div class="col-md-4 col-xl mb-3">
            <div class="p-3 rounded h-100" style="background: #ffffff; border: var(--border-hairline); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div class="text-muted small mb-1">Total Penyewa</div>
                <div class="font-weight-bold" style="font-size: 24px; color: var(--color-midnight-ink);">
                    {{ number_format($totalCustomers) }}
                </div>
                <div class="text-muted small mt-1"><i class="fa fa-user mr-1 text-primary"></i> Akun Customer</div>
            </div>
        </div>
        <div class="col-md-4 col-xl mb-3">
            <div class="p-3 rounded h-100" style="background: #ffffff; border: var(--border-hairline); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div class="text-muted small mb-1">Total Mitra Pemilik</div>
                <div class="font-weight-bold" style="font-size: 24px; color: var(--color-midnight-ink);">
                    {{ number_format($totalOwners) }}
                </div>
                <div class="text-muted small mt-1"><i class="fa fa-user-tie mr-1 text-info"></i> Akun Owner</div>
            </div>
        </div>
        <div class="col-md-4 col-xl mb-3">
            <div class="p-3 rounded h-100" style="background: #ffffff; border: var(--border-hairline); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div class="text-muted small mb-1">Properti Listing Kos</div>
                <div class="font-weight-bold" style="font-size: 24px; color: var(--color-midnight-ink);">
                    {{ number_format($totalKos) }}
                </div>
                <div class="text-muted small mt-1"><i class="fa fa-building mr-1 text-warning"></i> Kos Terdaftar</div>
            </div>
        </div>
        <div class="col-md-6 col-xl mb-3">
            <div class="p-3 rounded h-100" style="background: #ffffff; border: var(--border-hairline); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div class="text-muted small mb-1">Total Booking</div>
                <div class="font-weight-bold" style="font-size: 24px; color: var(--color-midnight-ink);">
                    {{ number_format($totalBookings) }}
                </div>
                <div class="text-muted small mt-1"><i class="fa fa-calendar-check mr-1 text-success"></i> Transaksi Sewa</div>
            </div>
        </div>
        <div class="col-md-6 col-xl mb-3">
            <div class="p-3 rounded h-100" style="background: #ffffff; border: var(--border-hairline); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                <div class="text-muted small mb-1">Omzet Transaksi Lunas</div>
                <div class="font-weight-bold" style="font-size: 20px; color: #059669; font-variant-numeric: tabular-nums;">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </div>
                <div class="text-muted small mt-1"><i class="fa fa-check-circle mr-1 text-success"></i> Pembayaran Sah</div>
            </div>
        </div>
    </div>

    <!-- RECENT KOS & RECENT BOOKINGS -->
    <div class="row">
        <!-- RECENT LISTINGS -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100" style="border: var(--border-hairline); border-radius: 14px; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="background-color: var(--surface-page-canvas);">
                    <h6 class="font-weight-bold mb-0" style="color: var(--color-midnight-ink);">
                        <i class="fa fa-building mr-2" style="color: var(--color-notion-blue);"></i>Listing Kos Terbaru
                    </h6>
                    <a href="{{ route('admin.kos.index') }}" class="small font-weight-600 text-decoration-none text-primary">Lihat Semua &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <tbody>
                            @forelse($recentKos as $k)
                                <tr>
                                    <td class="py-2 px-3">
                                        <div class="font-weight-600 text-dark">{{ $k->title }}</div>
                                        <div class="text-muted small">{{ $k->city }} &bull; Pemilik: {{ $k->owner->name ?? '-' }}</div>
                                    </td>
                                    <td class="py-2 px-3 text-right">
                                        <span class="badge {{ $k->status === 'active' ? 'badge-success' : 'badge-secondary' }} px-2 py-1">
                                            {{ ucfirst($k->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center py-3 text-muted">Belum ada listing kos</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- RECENT BOOKINGS -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100" style="border: var(--border-hairline); border-radius: 14px; background: #ffffff; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden;">
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="background-color: var(--surface-page-canvas);">
                    <h6 class="font-weight-bold mb-0" style="color: var(--color-midnight-ink);">
                        <i class="fa fa-receipt mr-2" style="color: var(--color-notion-blue);"></i>Pemesanan Terbaru
                    </h6>
                    <a href="{{ route('admin.bookings.index') }}" class="small font-weight-600 text-decoration-none text-primary">Lihat Semua &rarr;</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <tbody>
                            @forelse($recentBookings as $b)
                                <tr>
                                    <td class="py-2 px-3">
                                        <div class="font-weight-600 text-dark">{{ $b->booking_code }}</div>
                                        <div class="text-muted small">{{ $b->tenant_name ?? $b->customer->name }} &bull; {{ $b->kos->title }}</div>
                                    </td>
                                    <td class="py-2 px-3 text-right">
                                        <div class="font-weight-600 text-dark">Rp {{ number_format($b->total_amount, 0, ',', '.') }}</div>
                                        <span class="badge badge-light border px-2 py-1 small">
                                            {{ ucfirst($b->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center py-3 text-muted">Belum ada transaksi booking</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
