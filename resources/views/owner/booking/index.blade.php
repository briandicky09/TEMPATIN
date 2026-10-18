@extends('layouts.owner')

@section('title', 'Daftar Booking Masuk - TEMPATIN')

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
                        <i class="fa fa-calendar-check mr-1"></i> MANAJEMEN TRANSAKSI
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Pemesanan &amp; Booking Masuk
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Tinjau dan setujui pengajuan sewa calon penghuni sebelum pembayaran dilakukan.
                    </p>
                </div>
            </div>

            <!-- STATUS FILTER PILLS -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ route('owner.bookings.index') }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ empty($status) ? 'background-color: var(--color-midnight-ink); color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Semua ({{ $counts['all'] }})
                </a>
                <a href="{{ route('owner.bookings.index', ['status' => 'pending']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'pending' ? 'background-color: #d97706; color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Menunggu Persetujuan ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('owner.bookings.index', ['status' => 'approved']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'approved' ? 'background-color: var(--color-notion-blue); color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Disetujui / Menunggu Bayar ({{ $counts['approved'] }})
                </a>
                <a href="{{ route('owner.bookings.index', ['status' => 'confirmed']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'confirmed' ? 'background-color: #059669; color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Sudah Dibayar ({{ $counts['confirmed'] }})
                </a>
                <a href="{{ route('owner.bookings.index', ['status' => 'active']) }}"
                   class="btn btn-sm px-3 py-2 rounded-pill text-decoration-none"
                   style="{{ $status === 'active' ? 'background-color: #4f46e5; color: #ffffff;' : 'background-color: #ffffff; color: var(--color-charcoal); border: var(--border-hairline);' }} font-weight: 600; font-size: 12.5px;">
                    Penghuni Aktif ({{ $counts['active'] }})
                </a>
            </div>

            <!-- SEARCH BAR -->
            <div class="p-3 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <form action="{{ route('owner.bookings.index') }}" method="GET" class="row g-2 align-items-center">
                    @if(!empty($status))
                        <input type="hidden" name="status" value="{{ $status }}">
                    @endif
                    <div class="col-md-9 mb-2 mb-md-0">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0" style="border-color: rgba(0,0,0,0.12); color: var(--color-stone);">
                                <i class="fa fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="Cari kode booking, nama penyewa, atau nama kos..." value="{{ $search ?? '' }}" style="font-size: 13.5px; border-color: rgba(0,0,0,0.12);">
                        </div>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn w-100" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); border: none;">
                            Cari
                        </button>
                        @if(!empty($search))
                            <a href="{{ route('owner.bookings.index', array_filter(['status' => $status])) }}" class="btn btn-light" style="font-size: 13px; border: var(--border-hairline);">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- BOOKING TABLE / LIST -->
            <div class="rounded overflow-hidden mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                @if($bookings->isNotEmpty())
                    <div class="table-responsive mb-0">
                        <table class="table mb-0 align-middle">
                            <thead style="background-color: var(--surface-page-canvas); border-bottom: var(--border-hairline);">
                                <tr>
                                    <th style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 18px; border-top: none;">Kode Booking</th>
                                    <th style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 18px; border-top: none;">Calon Penyewa</th>
                                    <th style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 18px; border-top: none;">Kos &amp; Kamar</th>
                                    <th style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 18px; border-top: none;">Periode</th>
                                    <th style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 18px; border-top: none;">Total</th>
                                    <th style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 18px; border-top: none;">Status</th>
                                    <th style="font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 18px; border-top: none; text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $item)
                                    @php
                                        $badgeBg = match($item->status) {
                                            'pending' => '#fef3c7',
                                            'approved' => 'var(--color-sky-tint)',
                                            'confirmed' => '#dcfce7',
                                            'active' => 'var(--color-midnight-ink)',
                                            'completed' => '#e0e7ff',
                                            'rejected', 'cancelled' => '#fee2e2',
                                            default => '#f3f4f6',
                                        };
                                        $badgeColor = match($item->status) {
                                            'pending' => '#92400e',
                                            'approved' => 'var(--color-notion-blue)',
                                            'confirmed' => '#166534',
                                            'active' => '#ffffff',
                                            'completed' => '#3730a3',
                                            'rejected', 'cancelled' => '#991b1b',
                                            default => '#374151',
                                        };
                                    @endphp
                                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                                        <td style="padding: 14px 18px;">
                                            <a href="{{ route('owner.bookings.show', $item->booking_code) }}" style="font-family: monospace; font-weight: 700; color: var(--color-notion-blue); text-decoration: none;">
                                                {{ $item->booking_code }}
                                            </a>
                                            <div style="font-size: 11px; color: var(--color-stone);">
                                                {{ $item->created_at->format('d M Y, H:i') }}
                                            </div>
                                        </td>
                                        <td style="padding: 14px 18px;">
                                            <div style="font-weight: 600; color: var(--color-midnight-ink); font-size: 13.5px;">
                                                {{ $item->tenant_name }}
                                            </div>
                                            <div style="font-size: 12px; color: var(--color-stone);">
                                                <i class="fa fa-phone-alt mr-1"></i> {{ $item->tenant_phone }}
                                            </div>
                                        </td>
                                        <td style="padding: 14px 18px;">
                                            <div style="font-weight: 600; color: var(--color-midnight-ink); font-size: 13.5px;">
                                                {{ $item->kos->title ?? '-' }}
                                            </div>
                                            <div style="font-size: 12px; color: var(--color-stone);">
                                                @if($item->room)
                                                    <span class="badge" style="background-color: #f1f5f9; color: var(--color-charcoal); font-size: 10.5px; border: var(--border-hairline);">
                                                        Kamar {{ $item->room->room_number }}
                                                    </span>
                                                @else
                                                    <span style="font-style: italic;">Kamar belum ditentukan</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td style="padding: 14px 18px; font-size: 13px; color: var(--color-charcoal);">
                                            <div>{{ $item->start_date ? $item->start_date->format('d M Y') : '-' }}</div>
                                            <div style="font-size: 11.5px; color: var(--color-stone);">Durasi: {{ $item->duration_months }} bulan</div>
                                        </td>
                                        <td style="padding: 14px 18px; font-weight: 700; color: var(--color-midnight-ink); font-size: 13.5px; font-variant-numeric: tabular-nums;">
                                            Rp {{ number_format($item->total_amount, 0, ',', '.') }}
                                        </td>
                                        <td style="padding: 14px 18px;">
                                            <span class="px-2 py-1 rounded" style="background-color: {{ $badgeBg }}; color: {{ $badgeColor }}; font-size: 11px; font-weight: 600;">
                                                {{ $item->status_label }}
                                            </span>
                                        </td>
                                        <td style="padding: 14px 18px; text-align: right;">
                                            <a href="{{ route('owner.bookings.show', $item->booking_code) }}" class="btn btn-sm btn-ghost" style="font-weight: 600; font-size: 12px; border-radius: var(--radius-buttons); padding: 6px 12px;">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION -->
                    <div class="p-3 border-top d-flex justify-content-between align-items-center" style="border-color: rgba(0,0,0,0.06) !important;">
                        <span style="font-size: 13px; color: var(--color-stone);">
                            Menampilkan {{ $bookings->firstItem() ?? 0 }} - {{ $bookings->lastItem() ?? 0 }} dari {{ $bookings->total() }} booking
                        </span>
                        <div>
                            {{ $bookings->links() }}
                        </div>
                    </div>
                @else
                    <div class="p-5 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; border-radius: 50%; background-color: var(--surface-page-canvas); color: var(--color-stone); font-size: 22px;">
                            <i class="fa fa-inbox"></i>
                        </div>
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                            Tidak Ada Booking yang Sesuai
                        </h3>
                        <p style="font-size: 13.5px; color: var(--color-stone); max-width: 440px; margin: 0 auto;">
                            Belum ada pengajuan booking masuk yang sesuai dengan filter atau kata kunci yang dipilih.
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
