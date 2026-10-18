@extends('layouts.owner')

@section('title', 'Daftar Penghuni & Siklus Sewa - TEMPATIN')

@section('owner-content')
<div class="container">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            @include('partials.owner-sidebar')
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-lg-9">

            <!-- HEADER -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-ink-black); font-size: 11px; font-weight: 600;">
                        <i class="fa fa-users mr-1"></i> MANAJEMEN PENYEWA
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Penghuni &amp; Siklus Sewa
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Pantau daftar penyewa aktif, periode hunian kamar, dan proses check-in / check-out.
                    </p>
                </div>
            </div>

            <!-- STATS CARDS -->
            <div class="row mb-4">
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <div class="p-3 rounded" style="background: #ffffff; border: var(--border-hairline); border-radius: 12px;">
                        <div class="text-muted small mb-1">Penghuni Aktif (Check-in)</div>
                        <div class="font-weight-bold" style="font-size: 24px; color: var(--color-midnight-ink);">
                            {{ $activeCount }}
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <div class="p-3 rounded" style="background: #ffffff; border: var(--border-hairline); border-radius: 12px;">
                        <div class="text-muted small mb-1">Menunggu Check-in (Lunas)</div>
                        <div class="font-weight-bold" style="font-size: 24px; color: #d97706;">
                            {{ $confirmedCount }}
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="p-3 rounded" style="background: #ffffff; border: var(--border-hairline); border-radius: 12px;">
                        <div class="text-muted small mb-1">Selesai Masa Sewa</div>
                        <div class="font-weight-bold" style="font-size: 24px; color: #6b7280;">
                            {{ $completedCount }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- STATUS FILTER PILLS -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('owner.penghuni.index', ['status' => 'active']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'active' ? 'background-color: var(--color-midnight-ink); color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Penghuni Aktif ({{ $activeCount }})
                </a>
                <a href="{{ route('owner.penghuni.index', ['status' => 'confirmed']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'confirmed' ? 'background-color: #d97706; color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Siap Check-in ({{ $confirmedCount }})
                </a>
                <a href="{{ route('owner.penghuni.index', ['status' => 'completed']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'completed' ? 'background-color: #6b7280; color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Riwayat Selesai ({{ $completedCount }})
                </a>
            </div>

            <!-- TABLE CARD -->
            <div class="card" style="border: var(--border-hairline); border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.03); overflow: hidden; background: #ffffff;">
                @if($tenants->isEmpty())
                    <div class="text-center py-5">
                        <i class="fa fa-user-friends mb-3" style="font-size: 40px; color: var(--color-stone);"></i>
                        <h6 class="font-weight-bold" style="color: var(--color-midnight-ink);">Tidak Ada Data Penyewa</h6>
                        <p class="text-muted small mb-0">Belum ada penyewa pada kategori status yang dipilih.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 13.5px;">
                            <thead style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); font-weight: 600; border-bottom: var(--border-hairline);">
                                <tr>
                                    <th class="py-3 px-3">Penyewa</th>
                                    <th class="py-3 px-3">Properti &amp; Kamar</th>
                                    <th class="py-3 px-3">Periode Sewa</th>
                                    <th class="py-3 px-3">Status Hunian</th>
                                    <th class="py-3 px-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tenants as $tenant)
                                    <tr style="border-bottom: var(--border-hairline);">
                                        <td class="py-3 px-3">
                                            <div class="font-weight-bold text-dark">
                                                {{ $tenant->tenant_name ?? $tenant->customer->name }}
                                            </div>
                                            <div class="text-muted small">
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tenant->tenant_phone ?? $tenant->customer->phone) }}" target="_blank" style="color: #059669; text-decoration: none;">
                                                    <i class="fab fa-whatsapp mr-1"></i> {{ $tenant->tenant_phone ?? $tenant->customer->phone }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="font-weight-600 text-dark">
                                                {{ $tenant->kos->title }}
                                            </div>
                                            <div class="text-muted small">
                                                @if($tenant->room)
                                                    <span class="badge badge-light border">Kamar #{{ $tenant->room->room_number }} (Lt {{ $tenant->room->floor }})</span>
                                                @else
                                                    <span class="text-muted">Kamar Standar</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            <div class="text-dark font-weight-600">
                                                {{ $tenant->start_date ? $tenant->start_date->format('d M Y') : '-' }} s/d {{ $tenant->end_date ? $tenant->end_date->format('d M Y') : '-' }}
                                            </div>
                                            <div class="text-muted small">
                                                {{ $tenant->duration_months }} Bulan
                                            </div>
                                        </td>
                                        <td class="py-3 px-3">
                                            @if($tenant->status === 'active')
                                                <span class="badge px-2 py-1" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                    <i class="fa fa-key mr-1"></i> Aktif Menghuni
                                                </span>
                                            @elseif($tenant->status === 'confirmed')
                                                <span class="badge px-2 py-1" style="background: #fffbeb; color: #92400e; border: 1px solid #fde68a; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                    <i class="fa fa-clock mr-1"></i> Siap Check-in
                                                </span>
                                            @else
                                                <span class="badge px-2 py-1" style="background: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb; font-size: 11.5px; font-weight: 600; border-radius: 6px;">
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-3 text-right">
                                            <div class="d-inline-flex gap-1">
                                                <a href="{{ route('owner.bookings.show', $tenant->booking_code) }}" class="btn btn-sm btn-outline-secondary font-weight-600" style="border-radius: 6px; font-size: 12px;">
                                                    Rincian
                                                </a>
                                                @if($tenant->status === 'confirmed')
                                                    <form action="{{ route('owner.bookings.checkin', $tenant->booking_code) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success font-weight-600 ml-1" style="border-radius: 6px; font-size: 12px;" onclick="return confirm('Proses check-in untuk penghuni ini?')">
                                                            Check-in
                                                        </button>
                                                    </form>
                                                @elseif($tenant->status === 'active')
                                                    <form action="{{ route('owner.bookings.checkout', $tenant->booking_code) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-danger font-weight-600 ml-1" style="border-radius: 6px; font-size: 12px;" onclick="return confirm('Proses check-out untuk penghuni ini? Kamar akan dikembalikan berstatus tersedia.')">
                                                            Check-out
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 d-flex justify-content-center">
                        {{ $tenants->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
