@extends('layouts.owner')

@section('title', 'Detail Properti: ' . $kos['title'] . ' - TEMPATIN')

@section('owner-content')
<div class="container">
    <div class="row">

        <!-- OWNER SIDEBAR -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            @include('partials.owner-sidebar')
        </div>

        <!-- MAIN DETAIL CONTENT -->
        <div class="col-lg-9">

            <!-- BREADCRUMB -->
            <div class="mb-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                        <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}" style="color: var(--color-stone); text-decoration: none;">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('owner.kos.my') }}" style="color: var(--color-stone); text-decoration: none;">Kos Saya</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">{{ $kos['title'] }}</li>
                    </ol>
                </nav>
            </div>

            <!-- HEADER -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge" style="background-color: var(--surface-page-canvas); border: var(--border-hairline); color: var(--color-stone); font-size: 11px;">
                            Kos {{ ucfirst($kos['type']) }}
                        </span>
                        @php
                            $isActive = in_array(strtolower($kos['status']), ['aktif', 'active']);
                        @endphp
                        <span class="badge px-2 py-1" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 11px; font-weight: 600; border-radius: 4px;">
                            <i class="fa fa-circle mr-1" style="font-size: 7px; color: var(--color-stone);"></i> {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">
                        {{ $kos['title'] }}
                    </h1>
                    <div style="font-size: 13.5px; color: var(--color-stone);">
                        <i class="fa fa-map-marker-alt mr-1" style="color: var(--color-stone);"></i> {{ $kos['address'] ?? $kos['city'] }}
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('owner.kos.edit', $kos['slug']) }}" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13px; padding: 10px 18px; border-radius: var(--radius-buttons); border: none;">
                        <i class="fa fa-edit mr-1"></i> Edit Kos
                    </a>
                    <a href="{{ route('kos.show', $kos['slug']) }}" target="_blank" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-weight: 600; font-size: 13px; padding: 10px 18px; border-radius: var(--radius-buttons);">
                        <i class="fa fa-external-link-alt mr-1"></i> Lihat Publik
                    </a>
                </div>
            </div>

            <div class="row">

                <!-- LEFT COLUMN: THUMBNAIL, DESKRIPSI, FASILITAS, GALERI -->
                <div class="col-lg-8 mb-4 mb-lg-0">

                    <!-- Main Image & Description -->
                    <div class="p-4 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div class="mb-4 overflow-hidden rounded" style="height: 320px; border: var(--border-hairline);">
                            <img src="{{ asset($kos['thumbnail']) }}" alt="{{ $kos['title'] }}" class="w-100 h-100" style="object-fit: cover;">
                        </div>

                        <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 12px;">
                            Deskripsi Hunian
                        </h2>
                        <p style="font-size: 14px; color: var(--color-charcoal); line-height: 1.7; margin-bottom: 0;">
                            {{ $kos['description'] ?? 'Deskripsi properti kos belum ditambahkan.' }}
                        </p>
                    </div>

                    <!-- Facilities -->
                    <div class="p-4 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 14px;">
                            Fasilitas Kos
                        </h2>
                        @if(isset($kos->facilities) && $kos->facilities->isNotEmpty())
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($kos->facilities as $fac)
                                    <span class="d-inline-flex align-items-center px-3 py-2 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13px; color: var(--color-charcoal); font-weight: 500;">
                                        <i class="fa fa-check mr-2" style="color: var(--color-charcoal);"></i> {{ $fac->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p style="font-size: 13.5px; color: var(--color-stone); margin-bottom: 0;">Belum ada fasilitas yang ditambahkan.</p>
                        @endif
                    </div>

                    <!-- Photo Gallery -->
                    <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 14px;">
                            Galeri Foto Kos
                        </h2>
                        @if(isset($kos->photos) && $kos->photos->isNotEmpty())
                            <div class="row">
                                @foreach($kos->photos as $photo)
                                    <div class="col-sm-4 col-6 mb-3">
                                        <a href="{{ $photo->url }}" target="_blank" class="d-block overflow-hidden rounded" style="height: 120px; border: var(--border-hairline);">
                                            <img src="{{ $photo->url }}" alt="Foto Kos" class="w-100 h-100" style="object-fit: cover;">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p style="font-size: 13.5px; color: var(--color-stone); margin-bottom: 0;">Belum ada foto tambahan di galeri.</p>
                        @endif
                    </div>

                </div>

                <!-- RIGHT COLUMN: SIDEBAR DETAILS & ACTIONS -->
                <div class="col-lg-4">
                    <div style="position: sticky; top: 90px;">

                        <div class="p-4 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div style="font-size: 12px; text-transform: uppercase; font-weight: 700; color: var(--color-stone); letter-spacing: 0.05em; margin-bottom: 4px;">
                                TARIF SEWA
                            </div>
                            <div style="font-size: 1.5rem; font-weight: 800; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums; margin-bottom: 16px;">
                                Rp {{ number_format($kos['price'], 0, ',', '.') }} <span style="font-size: 12px; font-weight: 400; color: var(--color-stone);">/ bulan</span>
                            </div>

                            <div class="p-3 mb-3 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: var(--color-stone);">Status:</span>
                                    <strong style="color: var(--color-midnight-ink);">{{ $isActive ? 'Aktif' : 'Nonaktif' }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: var(--color-stone);">Tipe:</span>
                                    <strong style="color: var(--color-midnight-ink);">Kos {{ ucfirst($kos['type']) }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span style="color: var(--color-stone);">Kota:</span>
                                    <strong style="color: var(--color-midnight-ink);">{{ $kos['city'] }}</strong>
                                </div>
                            </div>

                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('owner.kos.edit', $kos['slug']) }}" class="btn btn-block" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13px; padding: 10px; border-radius: var(--radius-buttons); text-align: center; border: none;">
                                    <i class="fa fa-edit mr-2"></i> Edit Informasi Kos
                                </a>

                                <form action="{{ route('owner.kos.destroy', $kos['slug']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kos ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-block" style="background-color: #ffffff; color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 13px; padding: 10px; border-radius: var(--radius-buttons);">
                                        <i class="fa fa-trash mr-2" style="color: var(--color-stone);"></i> Hapus Properti
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
