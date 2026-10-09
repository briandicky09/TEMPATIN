@extends('layouts.owner')

@section('title', 'Kos Saya - TEMPATIN')

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
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 600;">
                        <i class="fa fa-building mr-1"></i> PORTOFOLIO HUNIAN
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Kos Saya
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Daftar seluruh properti kos yang Anda miliki dan kelola di platform TEMPATIN.
                    </p>
                </div>
                <div>
                    <a href="{{ route('owner.kos.create') }}" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13.5px; padding: 10px 20px; border-radius: var(--radius-buttons); border: none;">
                        <i class="fa fa-plus-circle mr-1"></i> Tambah Kos Baru
                    </a>
                </div>
            </div>

            <!-- CARDS GRID -->
            <div class="row">
                @forelse($listKos as $kos)
                    @php
                        $isActive = in_array(strtolower($kos['status']), ['aktif', 'active']);
                    @endphp
                    <div class="col-md-6 col-xl-4 mb-4">
                        <div class="h-100 d-flex flex-column justify-content-between p-3 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div>
                                <div class="position-relative overflow-hidden mb-3 rounded" style="height: 180px;">
                                    <img src="{{ asset($kos['thumbnail']) }}" class="w-100 h-100" alt="{{ $kos['title'] }}" style="object-fit: cover;">
                                    <div class="position-absolute" style="top: 10px; right: 10px;">
                                        <span class="badge px-2 py-1" style="background-color: #ffffff; color: var(--color-midnight-ink); font-size: 11px; font-weight: 700; border: var(--border-hairline); border-radius: 4px;">
                                            {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                </div>
                                <span class="badge mb-1" style="background-color: var(--surface-page-canvas); color: var(--color-stone); border: var(--border-hairline); font-size: 10px;">
                                    Kos {{ ucfirst($kos['type']) }}
                                </span>
                                <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                                    {{ $kos['title'] }}
                                </h3>
                                <div style="font-size: 12.5px; color: var(--color-stone); margin-bottom: 12px;">
                                    <i class="fa fa-map-marker-alt mr-1" style="color: var(--color-stone);"></i> {{ $kos['city'] }}
                                </div>
                            </div>
                            <div class="pt-3 border-top d-flex justify-content-between align-items-center" style="border-color: rgba(0,0,0,0.06) !important;">
                                <div>
                                    <span style="font-size: 11px; color: var(--color-stone); display: block;">Harga Sewa</span>
                                    <span style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                                        Rp {{ number_format($kos['price'], 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('owner.kos.show', $kos['slug']) }}" class="btn btn-sm" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 12px; font-weight: 600; border-radius: var(--radius-buttons); padding: 6px 12px;">
                                        Detail
                                    </a>
                                    <a href="{{ route('owner.kos.edit', $kos['slug']) }}" class="btn btn-sm" style="background-color: #ffffff; color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 12px; font-weight: 600; border-radius: var(--radius-buttons); padding: 6px 12px;">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="p-5 text-center rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px; border-radius: 50%; background-color: var(--surface-page-canvas); color: var(--color-stone); font-size: 24px;">
                                <i class="fa fa-building"></i>
                            </div>
                            <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                                Belum Ada Kos Terdaftar
                            </h3>
                            <p style="font-size: 13.5px; color: var(--color-stone); max-width: 440px; margin: 0 auto 20px;">
                                Anda belum memiliki properti kos. Daftarkan properti kos Anda hari ini.
                            </p>
                            <a href="{{ route('owner.kos.create') }}" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13px; padding: 10px 20px; border-radius: var(--radius-buttons); border: none;">
                                + Tambah Kos Baru
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

        </div>

    </div>
</div>
@endsection
