@extends('layouts.owner')

@section('title', 'Laporan & Statistik Bisnis - TEMPATIN')

@section('owner-content')
<div class="container">
    <div class="row">

        <!-- OWNER SIDEBAR -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            @include('partials.owner-sidebar')
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-lg-9">

            <!-- HEADER -->
            <div class="mb-4">
                <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 600;">
                    <i class="fa fa-chart-line mr-1"></i> ANALITIKA PROPERTI
                </div>
                <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                    Laporan Statistik & Pendapatan
                </h1>
                <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                    Ringkasan performa finansial, rasio keterisian kamar (okupansi), dan tren pertumbuhan sewa.
                </p>
            </div>

            <!-- KPI METRICS -->
            <div class="row mb-4">
                <div class="col-md-3 col-6 mb-3">
                    <div class="p-3 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 4px;">Total Pendapatan</div>
                        <div style="font-size: 1.35rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums; margin-bottom: 4px;">
                            Rp {{ number_format($summary['pendapatan'], 0, ',', '.') }}
                        </div>
                        <span class="badge" style="background-color: #edf7ee; color: #166534; border: 1px solid rgba(22, 101, 52, 0.18); font-size: 11px; font-weight: 600;">
                            <i class="fa fa-arrow-up mr-1" style="color: #166534;"></i>+{{ $summary['pertumbuhan'] }}% bln ini
                        </span>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-3">
                    <div class="p-3 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 4px;">Total Booking</div>
                        <div style="font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums; margin-bottom: 4px;">
                            {{ $summary['booking'] }}
                        </div>
                        <span style="font-size: 11px; color: var(--color-stone);">Tahun berjalan</span>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-3">
                    <div class="p-3 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 4px;">Tingkat Hunian</div>
                        <div style="font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums; margin-bottom: 4px;">
                            {{ $summary['tingkat_hunian'] }}%
                        </div>
                        <span style="font-size: 11px; color: var(--color-stone);">Rata-rata okupansi</span>
                    </div>
                </div>

                <div class="col-md-3 col-6 mb-3">
                    <div class="p-3 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 4px;">Properti Aktif</div>
                        <div style="font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums; margin-bottom: 4px;">
                            {{ count($kosPerformance) }}
                        </div>
                        <span style="font-size: 11px; color: var(--color-stone);">Portofolio terdaftar</span>
                    </div>
                </div>
            </div>

            <!-- CHARTS & PROGRESS BARS -->
            <div class="row mb-4">
                <!-- Monthly Revenue Meters -->
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="p-4 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">Tren Pendapatan Bulanan</h2>
                                <span style="font-size: 12px; color: var(--color-stone);">Arus kas sewa 6 bulan terakhir</span>
                            </div>
                            <span class="badge" style="background-color: var(--surface-page-canvas); color: var(--color-stone); border: var(--border-hairline); font-size: 11px;">Tahun 2026</span>
                        </div>

                        @php $maxRevenue = max(array_column($monthlyRevenue, 'value')); @endphp
                        @foreach($monthlyRevenue as $rev)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 12.5px;">
                                    <span style="font-weight: 600; color: var(--color-midnight-ink);">{{ $rev['month'] }}</span>
                                    <span style="font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                                        Rp {{ number_format($rev['value'] / 1000000, 1, ',', '.') }} Jt
                                    </span>
                                </div>
                                <div class="rounded overflow-hidden" style="height: 8px; background-color: var(--surface-page-canvas);">
                                    <div style="height: 100%; width: {{ ($rev['value'] / $maxRevenue) * 100 }}%; background-color: var(--color-notion-blue); border-radius: 4px; transition: width 0.3s ease;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kos Occupancy Performance -->
                <div class="col-lg-5">
                    <div class="p-4 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div class="mb-4">
                            <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">Tingkat Okupansi</h2>
                            <span style="font-size: 12px; color: var(--color-stone);">Keterisian kamar per properti</span>
                        </div>

                        @foreach($kosPerformance as $kos)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1" style="font-size: 13px;">
                                    <strong style="color: var(--color-midnight-ink); font-size: 13.5px;">{{ $kos['title'] }}</strong>
                                    <span style="font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">{{ $kos['occupancy'] }}%</span>
                                </div>
                                <div class="rounded overflow-hidden" style="height: 8px; background-color: var(--surface-page-canvas);">
                                    <div style="height: 100%; width: {{ $kos['occupancy'] }}%; background-color: var(--color-notion-blue); border-radius: 4px;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- TABLE OF PROPERTY PERFORMANCE -->
            <div class="rounded overflow-hidden" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="p-3 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                    <h3 style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
                        Rincian Performa per Kos
                    </h3>
                </div>
                <div class="table-responsive mb-0">
                    <table class="table mb-0 align-middle">
                        <thead style="background-color: var(--surface-page-canvas); border-bottom: var(--border-hairline);">
                            <tr>
                                <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 20px; border-top: none;">Nama Properti</th>
                                <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 20px; border-top: none;">Tingkat Hunian</th>
                                <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 20px; border-top: none;">Booking</th>
                                <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 20px; border-top: none; text-align: right;">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kosPerformance as $kos)
                                <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                                    <td style="padding: 14px 20px; font-weight: 700; color: var(--color-midnight-ink); font-size: 14px;">
                                        {{ $kos['title'] }}
                                    </td>
                                    <td style="padding: 14px 20px;">
                                        <span class="badge" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 4px;">
                                            {{ $kos['occupancy'] }}%
                                        </span>
                                    </td>
                                    <td style="padding: 14px 20px; font-size: 13.5px; color: var(--color-stone);">
                                        {{ $kos['booking'] }} pesanan
                                    </td>
                                    <td style="padding: 14px 20px; text-align: right; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums; font-size: 14px;">
                                        Rp {{ number_format($kos['revenue'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
