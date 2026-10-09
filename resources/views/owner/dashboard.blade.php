@extends('layouts.owner')

@section('title', 'Dashboard Owner - TEMPATIN')

@section('owner-content')
<div class="container">
    <div class="row">
        <!-- OWNER SIDEBAR -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            @include('partials.owner-sidebar')
        </div>

        <!-- MAIN DASHBOARD CONTENT -->
        <div class="col-lg-9">

            <!-- HEADER -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 600;">
                        <i class="fa fa-tachometer-alt mr-1"></i> RINGKASAN PORTOFOLIO
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Dashboard Pemilik Kos
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Pantau status ketersediaan kamar, hunian aktif, dan performa penawaran kos Anda.
                    </p>
                </div>
                <div>
                    <a href="{{ route('owner.kos.create') }}" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13.5px; padding: 10px 20px; border-radius: var(--radius-buttons); border: none;">
                        <i class="fa fa-plus-circle mr-1"></i> Tambah Kos Baru
                    </a>
                </div>
            </div>

            <!-- KPI METRICS GRID -->
            <div class="row mb-4">
                <div class="col-md-3 col-6 mb-3">
                    <div class="p-3 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 6px;">Total Properti</div>
                        <div style="font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                            {{ $totalKos }}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="p-3 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 6px;">Kos Aktif</div>
                        <div style="font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                            {{ $kosAktif }}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="p-3 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 6px;">Kos Nonaktif</div>
                        <div style="font-size: 1.65rem; font-weight: 700; color: var(--color-stone); font-variant-numeric: tabular-nums;">
                            {{ $kosNonaktif }}
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="p-3 rounded h-100" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 6px;">Rata-rata Harga</div>
                        <div style="font-size: 1.25rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                            Rp {{ number_format($rataHarga, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- RECENT KOS LISTINGS -->
            <div class="p-4 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                    <div>
                        <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">
                            Properti Terbaru
                        </h2>
                        <span style="font-size: 13px; color: var(--color-stone);">Kos yang baru Anda daftarkan di platform.</span>
                    </div>
                    <a href="{{ route('owner.kos.my') }}" class="btn btn-sm" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 12px; border-radius: var(--radius-buttons); padding: 6px 14px;">
                        Kelola Semua Kos
                    </a>
                </div>

                <div class="row">
                    @forelse($recentKos as $kos)
                        <div class="col-md-6 col-xl-4 mb-3">
                            <div class="h-100 d-flex flex-column justify-content-between p-3 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                                <div>
                                    <div class="position-relative overflow-hidden mb-2 rounded" style="height: 140px;">
                                        <img src="{{ asset($kos['thumbnail']) }}" class="w-100 h-100" alt="{{ $kos['title'] }}" style="object-fit: cover;">
                                    </div>
                                    <h3 style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                                        {{ $kos['title'] }}
                                    </h3>
                                    <div style="font-size: 12px; color: var(--color-stone); margin-bottom: 8px;">
                                        <i class="fa fa-map-marker-alt mr-1" style="color: var(--color-stone);"></i> {{ $kos['city'] }}
                                    </div>
                                </div>
                                <div class="pt-2 border-top d-flex justify-content-between align-items-center" style="border-color: rgba(0,0,0,0.06) !important;">
                                    <div>
                                        <span style="font-size: 13px; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                                            Rp {{ number_format($kos['price'], 0, ',', '.') }}
                                        </span>
                                        <span style="font-size: 11px; color: var(--color-stone);">/bln</span>
                                    </div>
                                    @if(!empty($kos['slug']))
                                        <a href="{{ route('owner.kos.edit', $kos['slug']) }}" style="font-size: 12px; color: var(--color-midnight-ink); font-weight: 600; text-decoration: none;">
                                            Edit <i class="fa fa-chevron-right ml-1"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4">
                            <p style="font-size: 13.5px; color: var(--color-stone); margin-bottom: 12px;">Anda belum menambahkan properti kos.</p>
                            <a href="{{ route('owner.kos.create') }}" class="btn btn-sm" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 12px; padding: 8px 16px; border-radius: var(--radius-buttons); border: none;">
                                + Tambah Kos Sekarang
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
