@extends('layouts.app')

@section('title', $kos['title'] . ' - TEMPATIN')

@php
    $lat = $kos['latitude'] ?? null;
    $lng = $kos['longitude'] ?? null;
    $hasValidCoordinates = !empty($lat) && !empty($lng) && is_numeric($lat) && is_numeric($lng) && ($lat >= -90 && $lat <= 90) && ($lng >= -180 && $lng <= 180);
@endphp

@push('styles')
@if($hasValidCoordinates)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #property-map {
        z-index: 1;
    }
    #property-map .leaflet-control-zoom {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        border-radius: 8px;
        overflow: hidden;
        margin: 12px;
    }
    #property-map .leaflet-control-zoom a {
        background-color: #ffffff;
        color: #2f3437;
        font-size: 14px;
        width: 32px;
        height: 32px;
        line-height: 32px;
        border-bottom: 1px solid #f0f0f0;
    }
    #property-map .leaflet-control-zoom a:hover {
        background-color: #f7f6f3;
        color: #0075de;
    }
    #property-map .leaflet-control-attribution {
        background-color: rgba(255, 255, 255, 0.88);
        font-size: 10.5px;
        padding: 2px 6px;
    }
    #property-map .leaflet-popup-content-wrapper {
        border-radius: 10px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        font-family: inherit;
    }
    #property-map .leaflet-popup-content {
        font-size: 12.5px;
        line-height: 1.45;
        margin: 12px 14px;
    }
</style>
@endif
<style>
    /* Clean Notion-Styled Similar Property Cards */
    .similar-property-card {
        background-color: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 14px;
        overflow: hidden;
        transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.25s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
    }
    .similar-property-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
        border-color: rgba(0, 117, 222, 0.25);
    }
    .similar-property-card .similar-card-img-wrap {
        position: relative;
        height: 190px;
        overflow: hidden;
        background-color: #f3f4f6;
    }
    .similar-property-card .similar-card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .similar-property-card:hover .similar-card-img-wrap img {
        transform: scale(1.04);
    }
    .similar-property-card .similar-type-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 2;
        background-color: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(4px);
        color: var(--color-midnight-ink, #2f3437);
        font-size: 11.5px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        border: 1px solid rgba(0, 0, 0, 0.06);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }
    .similar-property-card .similar-badge-rec {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
        background-color: #fef3c7;
        color: #92400e;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 9px;
        border-radius: 6px;
        border: 1px solid rgba(245, 158, 11, 0.25);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }
    .similar-property-card .similar-card-btn {
        background-color: var(--surface-page-canvas, #f7f6f3);
        color: var(--color-midnight-ink, #2f3437);
        border: 1px solid rgba(0, 0, 0, 0.08);
        font-weight: 600;
        font-size: 12.5px;
        border-radius: 8px;
        padding: 9px 14px;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .similar-property-card .similar-card-btn:hover {
        background-color: var(--color-sky-tint, #e8f3ff) !important;
        color: var(--color-notion-blue, #0075de) !important;
        border-color: rgba(0, 117, 222, 0.25) !important;
    }
    .similar-property-card .similar-card-btn:hover i {
        transform: translateX(3px);
    }
    .similar-property-card .similar-card-btn i {
        transition: transform 0.2s ease;
    }

    /* Star Rating Widget for Reviews */
    .star-rating-widget .star-btn {
        font-size: 26px;
        color: #d1d5db;
        cursor: pointer;
        transition: color 0.15s ease, transform 0.15s ease;
        display: inline-block;
        line-height: 1;
        padding: 2px 3px;
    }
    .star-rating-widget .star-btn.active,
    .star-rating-widget .star-btn.hover-active {
        color: #f59e0b !important;
    }
    .star-rating-widget .star-btn:hover {
        transform: scale(1.2);
    }

    /* Reviews Collapsed, Fading, and Expand Button */
    #reviews-wrapper.is-collapsed .review-item-hidden {
        display: none !important;
    }
    #reviews-wrapper.is-collapsed .review-item-fading {
        position: relative;
        -webkit-mask-image: linear-gradient(180deg, rgba(0,0,0,1) 0%, rgba(0,0,0,0.85) 25%, rgba(0,0,0,0.3) 60%, rgba(0,0,0,0) 100%);
        mask-image: linear-gradient(180deg, rgba(0,0,0,1) 0%, rgba(0,0,0,0.85) 25%, rgba(0,0,0,0.3) 60%, rgba(0,0,0,0) 100%);
        filter: blur(0.5px);
        opacity: 0.75;
        pointer-events: none;
        transition: all 0.35s ease;
    }
    #reviews-wrapper:not(.is-collapsed) .review-item-fading {
        -webkit-mask-image: none !important;
        mask-image: none !important;
        filter: none !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }
    .reviews-fade-overlay {
        position: relative;
        margin-top: -65px;
        padding-top: 45px;
        padding-bottom: 8px;
        text-align: center;
        background: linear-gradient(180deg, rgba(247, 246, 243, 0) 0%, rgba(247, 246, 243, 0.75) 35%, rgba(247, 246, 243, 0.98) 75%, #f7f6f3 100%);
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
        z-index: 5;
        border-radius: 0 0 12px 12px;
        transition: all 0.3s ease;
    }
    #reviews-wrapper:not(.is-collapsed) .reviews-fade-overlay {
        margin-top: 8px;
        padding-top: 0;
        background: none;
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
    }
    .btn-show-all-reviews {
        background-color: #ffffff;
        color: var(--color-midnight-ink, #2f3437);
        border: none;
        outline: none;
        font-weight: 600;
        font-size: 13px;
        border-radius: 20px;
        padding: 9px 24px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        cursor: pointer;
    }
    .btn-show-all-reviews:hover {
        background-color: var(--color-sky-tint, #e8f3ff);
        color: var(--color-notion-blue, #0075de);
        border: none;
        outline: none;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 117, 222, 0.16);
    }
    .btn-show-all-reviews:focus,
    .btn-show-all-reviews:active {
        border: none !important;
        outline: none !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1) !important;
    }

    /* Filter Pills */
    .btn-review-filter {
        background-color: #ffffff;
        color: var(--color-charcoal, #4b5563);
        border: 1px solid rgba(0, 0, 0, 0.08);
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        padding: 6px 14px;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }
    .btn-review-filter:hover {
        background-color: var(--surface-page-canvas, #f7f6f3);
        color: var(--color-midnight-ink, #111827);
        border-color: rgba(0, 0, 0, 0.18);
    }
    .btn-review-filter.active {
        background-color: var(--color-midnight-ink, #111827);
        color: #ffffff;
        border-color: var(--color-midnight-ink, #111827);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }
    .btn-review-filter.active .text-warning {
        color: #fbbf24 !important;
    }
</style>
@endpush

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')

    @include('partials.alert')

    <main id="ts-main">

        <!--BREADCRUMB
        =========================================================================================================-->
        <section id="breadcrumb" class="pt-0 pb-1">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kos.index') }}">Cari Kos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $kos['title'] }}</li>
                    </ol>
                </nav>
            </div>
        </section>

        <!--GALLERY CAROUSEL (Pertahankan layout gambar)
        =========================================================================================================-->
        <section id="gallery-carousel">

            <div class="owl-carousel ts-gallery-carousel ts-gallery-carousel__multi" data-owl-dots="1"
                data-owl-items="3" data-owl-center="1" data-owl-loop="1">

                @php
                    $galleryImages = [];
                    if (isset($kos->photos) && $kos->photos->isNotEmpty()) {
                        foreach ($kos->photos as $photo) {
                            $galleryImages[] = $photo->url;
                        }
                    } elseif (!empty($kos['gallery'])) {
                        foreach ($kos['gallery'] as $img) {
                            $galleryImages[] = asset($img);
                        }
                    } else {
                        $galleryImages = [
                            asset($kos['thumbnail'] ?? 'assets/img/img-detail-01.jpg'),
                            asset('assets/img/img-detail-02.jpg'),
                            asset('assets/img/img-detail-05.jpg'),
                            asset('assets/img/img-detail-04.jpg'),
                            asset('assets/img/img-detail-03.jpg'),
                        ];
                    }
                @endphp

                @foreach($galleryImages as $image)
                <!--Slide-->
                <div class="slide">
                    <div class="ts-image" data-bg-image="{{ $image }}">
                        <a href="{{ $image }}" class="ts-zoom popup-image"><i class="fa fa-search-plus"></i>Zoom</a>
                    </div>
                </div>
                @endforeach

            </div>

        </section>

        <!--CONTENT (Nama kos berada di bawah gambar album - Layout referensi)
        =========================================================================================================-->
        <section id="content" class="pt-4">
            <div class="container">
                <div class="row">

                    <!--LEFT SIDE: MAIN CONTENT (Title, Badges, Quick Info, Description, Amenities, Map, Reviews)
                    =============================================================================================-->
                    <div class="col-md-7 col-lg-8">

                        <!--NAMA KOS & BADGES-->
                        <div id="page-title" class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge px-3 py-1 font-weight-normal" style="border-radius: 9999px; background-color: var(--color-sky-tint); color: var(--color-ink-black); border: 1px solid rgba(0, 117, 222, 0.2);">
                                    <i class="fa fa-check-circle mr-1" style="color: var(--color-ink-black);"></i>TEMPATIN Verified
                                </span>

                                <!-- Tombol Simpan ke Favorit (Heart: outline hitam, isi putih, berubah merah saat diklik) -->
                                @php
                                    $kosSlug = $kos['slug'] ?? '';
                                    $isFavorited = in_array($kosSlug, session('member_favorites', []));
                                @endphp
                                <button type="button" class="btn-favorite-action btn-toggle-favorite {{ $isFavorited ? 'is-active' : '' }}" data-slug="{{ $kosSlug }}" id="btnDetailFavorite" title="{{ $isFavorited ? 'Tersimpan di Favorit' : 'Simpan ke Favorit' }}">
                                    <svg class="favorite-heart-svg {{ $isFavorited ? 'is-active' : '' }}" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    <span class="favorite-label-text ml-2 font-weight-600 small text-dark d-none d-sm-inline" id="detailFavoriteText">
                                        {{ $isFavorited ? 'Tersimpan di Favorit' : 'Simpan ke Favorit' }}
                                    </span>
                                </button>
                            </div>

                            <h1 class="font-weight-bold text-dark mb-2" style="font-size: 2.2rem; line-height: 1.25; letter-spacing: -0.03em;">
                                {{ $kos['title'] }}
                            </h1>

                            <div class="d-flex flex-wrap align-items-center text-muted" style="gap: 10px; font-size: 0.95rem;">
                                <!-- Label Kos (Layer putih, teks biru, rounded rectangle) -->
                                <span class="badge ts-card-badge-type">
                                    Kos {{ ucfirst($kos['type'] ?? 'Campur') }}
                                </span>
                                <span>&bull;</span>
                                <span>
                                    <i class="fa fa-map-marker-alt mr-1" style="color: var(--color-notion-blue);"></i>
                                    {{ $kos['address'] ?? $kos['city'] }}
                                </span>
                                @if(!empty($kos['rating']))
                                    <span>&bull;</span>
                                    <span>
                                        <i class="fa fa-star mr-1" style="color: var(--color-notion-blue);"></i>
                                        <strong class="text-dark">{{ number_format($kos['rating'], 1) }}</strong> ({{ $kos['review_count'] ?? 0 }} ulasan)
                                    </span>
                                @endif
                                <span class="badge ml-auto py-1 px-3" style="border-radius: 9999px; background-color: {{ ($kos['status'] ?? 'active') === 'active' ? 'var(--color-sky-tint)' : '#ffffff' }}; color: {{ ($kos['status'] ?? 'active') === 'active' ? 'var(--color-ink-black)' : 'var(--color-charcoal)' }}; border: 1px solid {{ ($kos['status'] ?? 'active') === 'active' ? 'rgba(0, 117, 222, 0.25)' : 'rgba(0, 0, 0, 0.2)' }};">
                                    {{ ($kos['status'] ?? 'active') === 'active' ? 'Tersedia' : 'Penuh' }}
                                </span>
                            </div>
                        </div>

                        <hr class="mb-4" style="border-top: var(--border-hairline);">

                        <!--DESCRIPTION
                        =========================================================================================-->
                        <section id="description">

                            <h3>Deskripsi</h3>

                            <p>{{ $kos['description'] ?? 'Deskripsi belum tersedia.' }}</p>

                        </section>

                        @if(!empty($kos['features']))
                        <!--FEATURES
                        =========================================================================================-->
                        <section id="features">

                            <h3>Fasilitas Utama</h3>

                            <ul class="list-unstyled ts-list-icons ts-column-count-4 ts-column-count-sm-2 ts-column-count-md-2">
                                @foreach($kos['features'] as $feature)
                                <li>
                                    <i class="fa {{ $feature['icon'] }}"></i>
                                    {{ $feature['name'] }}
                                </li>
                                @endforeach
                            </ul>

                        </section>
                        @endif

                        <!--AMENITIES
                        =========================================================================================-->
                        <section id="amenities">

                            <h3>Fasilitas Kos</h3>

                            @if(isset($kos->facilities) && $kos->facilities->isNotEmpty())
                                <div class="d-flex flex-wrap mb-4">
                                    @foreach($kos->facilities as $facility)
                                        <span class="badge badge-light border text-dark mr-2 mb-2 p-2" style="font-size: 0.9rem; font-weight: 500;">
                                            <i class="fa fa-check-circle mr-1" style="color: var(--color-charcoal);"></i>{{ $facility->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @elseif(!empty($kos['facilities']))
                                <ul class="ts-list-colored-bullets ts-text-color-light ts-column-count-3 ts-column-count-md-2">
                                    @foreach($kos['facilities'] as $facility)
                                        <li>{{ is_object($facility) ? $facility->name : $facility }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Belum ada fasilitas yang ditambahkan.</p>
                            @endif

                        </section>

                        <!--MAP SECTION (LEAFLET + OPENSTREETMAP)
                        =========================================================================================-->
                        <section id="map-location" class="mb-4">

                            <h3>Peta Lokasi</h3>

                            @if($hasValidCoordinates)
                                <div class="position-relative" style="background-color: #ffffff; border: var(--border-hairline, 1px solid rgba(0, 0, 0, 0.08)); border-radius: 16px; overflow: hidden; height: 260px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                                    <div id="property-map" style="width: 100%; height: 100%;"></div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between align-items-center mt-2 px-1 gap-2" style="font-size: 13px;">
                                    <div class="text-muted d-flex align-items-center text-truncate" style="max-width: calc(100% - 190px);">
                                        <i class="fa fa-map-marker-alt mr-2" style="color: var(--color-notion-blue); flex-shrink: 0;"></i>
                                        <span class="text-truncate">{{ $kos['address'] ?? $kos['city'] }}</span>
                                    </div>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $lng }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="btn btn-sm d-inline-flex align-items-center"
                                       style="background-color: #ffffff; border: var(--border-hairline, 1px solid rgba(0, 0, 0, 0.12)); border-radius: var(--radius-buttons, 6px); font-size: 12.5px; font-weight: 600; color: var(--color-midnight-ink); padding: 6px 14px; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.04); transition: all 0.2s ease;">
                                        <i class="fa fa-external-link-alt mr-2" style="color: var(--color-notion-blue); font-size: 11px;"></i>
                                        Buka di Google Maps
                                    </a>
                                </div>
                            @else
                                <div class="text-center d-flex flex-column align-items-center justify-content-center p-4"
                                     style="background-color: #ffffff; border: var(--border-hairline, 1px solid rgba(0, 0, 0, 0.08)); border-radius: 16px; height: 260px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3"
                                         style="width: 52px; height: 52px; background-color: var(--surface-page-canvas, #f7f6f3); border: var(--border-hairline, 1px solid rgba(0,0,0,0.08)); color: var(--color-stone, #787774);">
                                        <i class="fa fa-map-marked-alt fa-2x"></i>
                                    </div>
                                    <h5 class="mb-1 font-weight-bold" style="color: var(--color-midnight-ink, #2f3437); font-size: 14.5px;">Lokasi properti belum tersedia</h5>
                                    <p class="text-muted mb-0" style="font-size: 13px;">
                                        {{ $kos['address'] ?? $kos['city'] }}
                                    </p>
                                </div>
                            @endif

                        </section>

                        <!--REVIEWS
                        =============================================================================================-->
                        <section id="reviews" class="pk-reviews mt-4">
                            <hr class="mb-4">

                            @php
                                $reviewsList = $kos->reviews ?? collect($kos['reviews'] ?? []);
                                $reviewCount = $reviewsList->count();
                                $averageRating = $reviewCount > 0 ? round((float) $reviewsList->avg('rating'), 1) : 0.0;
                            @endphp

                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                                <div>
                                    <h3 class="mb-1" style="font-size: 1.35rem; font-weight: 700; color: var(--color-midnight-ink);">Ulasan Penghuni</h3>
                                    <p class="text-muted mb-0" style="font-size: 13.5px;">Pengalaman penghuni di {{ $kos['title'] }}</p>
                                </div>
                                <div class="d-inline-flex align-items-center px-3 py-1 rounded" style="background-color: var(--surface-page-canvas); border: var(--border-hairline);">
                                    <i class="fa fa-star mr-1" style="color: #f59e0b;"></i>
                                    <strong style="font-size: 14px; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">{{ number_format($averageRating, 1) }}</strong>
                                    <span class="text-muted ml-2 small">({{ $reviewCount }} ulasan)</span>
                                </div>
                            </div>

                            @if(session('review_success'))
                                <div class="alert alert-success d-flex align-items-center mb-4 py-3 px-3" style="border-radius: 10px; font-size: 13.5px; background-color: #ecfdf5; border-color: #a7f3d0; color: #065f46;">
                                    <i class="fa fa-check-circle mr-2" style="font-size: 18px; color: #10b981;"></i>
                                    <div>{{ session('review_success') }}</div>
                                </div>
                            @endif

                            @if($reviewCount > 0)
                                @php
                                    $starCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                    foreach ($reviewsList as $rItem) {
                                        $rVal = (int) (is_object($rItem) ? ($rItem->rating ?? 5) : ($rItem['score'] ?? 5));
                                        if (isset($starCounts[$rVal])) {
                                            $starCounts[$rVal]++;
                                        }
                                    }
                                @endphp

                                <!-- Filter Ulasan Berdasarkan Rating Bintang -->
                                <div class="review-filter-bar d-flex flex-wrap align-items-center mb-3 pb-1" style="gap: 8px;">
                                    <button type="button" class="btn btn-review-filter active" data-rating="all">
                                        Semua ({{ $reviewCount }})
                                    </button>
                                    <button type="button" class="btn btn-review-filter" data-rating="5">
                                        <i class="fa fa-star text-warning mr-1"></i> 5 Bintang ({{ $starCounts[5] }})
                                    </button>
                                    <button type="button" class="btn btn-review-filter" data-rating="4">
                                        <i class="fa fa-star text-warning mr-1"></i> 4 Bintang ({{ $starCounts[4] }})
                                    </button>
                                    <button type="button" class="btn btn-review-filter" data-rating="3">
                                        <i class="fa fa-star text-warning mr-1"></i> 3 Bintang ({{ $starCounts[3] }})
                                    </button>
                                    <button type="button" class="btn btn-review-filter" data-rating="2">
                                        <i class="fa fa-star text-warning mr-1"></i> 2 Bintang ({{ $starCounts[2] }})
                                    </button>
                                    <button type="button" class="btn btn-review-filter" data-rating="1">
                                        <i class="fa fa-star text-warning mr-1"></i> 1 Bintang ({{ $starCounts[1] }})
                                    </button>
                                </div>

                                <!-- Alert saat filter tidak menemukan hasil -->
                                <div id="no-matching-reviews" class="p-4 text-center rounded mb-4" style="display: none; background-color: var(--surface-page-canvas); border: var(--border-hairline); border-radius: 12px;">
                                    <i class="fa fa-star-half-alt fa-2x mb-2 d-block text-muted" style="opacity: 0.35;"></i>
                                    <div style="font-weight: 600; font-size: 14px; color: var(--color-midnight-ink); margin-bottom: 3px;">Tidak Ada Ulasan</div>
                                    <div class="text-muted small" id="no-matching-reviews-text">Belum ada ulasan untuk rating bintang ini.</div>
                                </div>

                                <!-- Review List Wrapper (Max 2 reviews initially with fade & blur) -->
                                <div id="reviews-wrapper" class="{{ $reviewCount > 2 ? 'is-collapsed' : '' }} mb-4" style="position: relative;">
                                    <div id="reviews-list">
                                        @foreach($reviewsList as $index => $review)
                                        @php
                                            $rName = is_object($review) ? ($review->reviewer_name ?? 'Penghuni') : ($review['name'] ?? 'Penghuni');
                                            $rRating = is_object($review) ? ($review->rating ?? 5) : ($review['score'] ?? 5);
                                            $rDate = is_object($review) ? ($review->created_at ? $review->created_at->translatedFormat('d F Y') : '') : ($review['date'] ?? '');
                                            $rComment = is_object($review) ? $review->comment : ($review['comment'] ?? '');
                                            $rReply = is_object($review) ? $review->reply : ($review['reply'] ?? null);
                                            $isBeyondTwo = $index >= 2;
                                            $isSecondItem = $index === 1 && $reviewCount > 2;
                                        @endphp
                                        <article class="review-item-card p-3 mb-3 rounded {{ $isBeyondTwo ? 'review-item-hidden' : '' }} {{ $isSecondItem ? 'review-item-fading' : '' }}" 
                                                 data-index="{{ $index }}"
                                                 data-rating="{{ $rRating }}"
                                                 style="background-color: #ffffff; border: var(--border-hairline); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: all 0.3s ease;">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle mr-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 700; font-size: 13px;">
                                                        {{ strtoupper(substr($rName, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-0 font-weight-bold" style="font-size: 13.5px; color: var(--color-midnight-ink);">{{ $rName }}</h5>
                                                        <small class="text-muted" style="font-size: 11.5px;">{{ $rDate }}</small>
                                                    </div>
                                                </div>
                                                <!-- White background with black outline -->
                                                <div class="d-inline-flex align-items-center px-2 py-1" style="background-color: #ffffff; border: 1.5px solid #111827; border-radius: 6px; color: #111827; font-size: 12px; font-weight: 700; box-shadow: 0 1px 2px rgba(0,0,0,0.04);">
                                                    <i class="fa fa-star mr-1" style="font-size: 11px; color: #f59e0b;"></i> {{ number_format($rRating, 1) }}
                                                </div>
                                            </div>
                                            <p class="mb-0 mt-2" style="font-size: 13.5px; color: var(--color-charcoal); line-height: 1.55;">{{ $rComment }}</p>

                                            @if(!empty($rReply))
                                            <div class="mt-3 p-3 rounded" style="background-color: var(--surface-page-canvas); border-left: 3px solid var(--color-notion-blue); font-size: 12.5px;">
                                                <strong class="d-block mb-1" style="color: var(--color-midnight-ink); font-size: 12px;">
                                                    <i class="fa fa-reply mr-1" style="color: var(--color-notion-blue);"></i> Balasan dari Pemilik Kos
                                                </strong>
                                                <p class="mb-0 text-muted" style="line-height: 1.5;">{{ $rReply }}</p>
                                            </div>
                                            @endif
                                        </article>
                                        @endforeach
                                    </div>

                                    @if($reviewCount > 2)
                                        <!-- Fade & Blur Overlay + Expand Button -->
                                        <div id="reviews-fade-container" class="reviews-fade-overlay">
                                            <button type="button" id="btn-toggle-reviews" class="btn btn-show-all-reviews">
                                                <i class="fa fa-chevron-down mr-2" id="reviews-btn-icon"></i> <span id="reviews-btn-text">Lihat Semua Ulasan ({{ $reviewCount }})</span>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- EMPTY STATE PLACEHOLDER -->
                                <div class="p-4 text-center rounded mb-4" style="background-color: var(--surface-page-canvas); border: var(--border-hairline); border-radius: 14px;">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 52px; height: 52px; background-color: #ffffff; border: 1px solid rgba(0,0,0,0.06); color: var(--color-notion-blue); box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                                        <i class="fa fa-comment-dots fa-2x"></i>
                                    </div>
                                    <h5 class="font-weight-bold mb-1" style="color: var(--color-midnight-ink); font-size: 15px;">Belum Ada Ulasan untuk Kos Ini</h5>
                                    <p class="text-muted mb-0 mx-auto" style="font-size: 13px; max-width: 480px; line-height: 1.5;">
                                        Jadilah penghuni pertama yang membagikan pengalaman tinggal di {{ $kos['title'] }}. Ulasan Anda akan langsung masuk ke akun pemilik kos.
                                    </p>
                                </div>
                            @endif

                            <!-- FORM TULIS ULASAN PENGHUNI -->
                            <div class="card p-4 mt-3" style="background-color: #ffffff; border: var(--border-hairline); border-radius: 14px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle mr-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 13px;">
                                        <i class="fa fa-pen"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-0 font-weight-bold" style="font-size: 1rem; color: var(--color-midnight-ink);">Tulis Ulasan Penghuni</h4>
                                        <small class="text-muted" style="font-size: 11.5px;">Ulasan Anda akan langsung masuk ke dashboard penilaian pemilik kos.</small>
                                    </div>
                                </div>

                                <form action="{{ route('kos.review.store', $kos['slug']) }}" method="POST">
                                    @csrf

                                    <!-- Rating Star Widget -->
                                    <div class="form-group mb-3">
                                        <label class="d-block mb-1 font-weight-bold" style="font-size: 13px; color: var(--color-midnight-ink);">
                                            Penilaian Bintang <span style="color: var(--color-notion-blue);">*</span>
                                        </label>
                                        <div class="star-rating-widget d-inline-flex align-items-center flex-wrap" id="starRatingWidget">
                                            <div class="stars-list d-inline-flex align-items-center mr-2" style="gap: 6px;">
                                                <i class="fa fa-star star-btn active" data-rating="1" title="1 Bintang - Sangat Buruk"></i>
                                                <i class="fa fa-star star-btn active" data-rating="2" title="2 Bintang - Kurang"></i>
                                                <i class="fa fa-star star-btn active" data-rating="3" title="3 Bintang - Cukup"></i>
                                                <i class="fa fa-star star-btn active" data-rating="4" title="4 Bintang - Puas"></i>
                                                <i class="fa fa-star star-btn active" data-rating="5" title="5 Bintang - Sangat Puas"></i>
                                            </div>
                                            <input type="hidden" name="rating" id="selectedRatingInput" value="{{ old('rating', '5') }}" required>
                                            <span id="star-desc-label" class="text-muted font-weight-bold small ml-1" style="font-size: 12.5px;">5.0 (Sangat Puas)</span>
                                        </div>
                                        @error('rating') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Reviewer Name -->
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold mb-1" style="font-size: 13px; color: var(--color-midnight-ink);">
                                            Nama Anda <span style="color: var(--color-notion-blue);">*</span>
                                        </label>
                                        <input type="text" 
                                               name="reviewer_name" 
                                               class="form-control @error('reviewer_name') is-invalid @enderror" 
                                               placeholder="Contoh: Dewi Sartika / Mahasiswa ITS" 
                                               value="{{ old('reviewer_name', auth()->user()->name ?? '') }}" 
                                               required
                                               style="border-radius: var(--radius-inputs, 8px); border: var(--border-hairline); font-size: 13.5px; padding: 10px 14px;">
                                        @error('reviewer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Review Comment Textarea -->
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold mb-1" style="font-size: 13px; color: var(--color-midnight-ink);">
                                            Ulasan Pengalaman <span style="color: var(--color-notion-blue);">*</span>
                                        </label>
                                        <textarea name="comment" 
                                                  rows="3" 
                                                  class="form-control @error('comment') is-invalid @enderror" 
                                                  placeholder="Ceritakan pengalaman Anda tinggal di kos ini secara jujur... Contoh: Lingkungan tenang, kamar mandi dalam bersih, sirkulasi udara sejuk, akses jalan aman malam hari, dan pemilik kos sangat ramah serta cepat tanggap." 
                                                  required
                                                  style="border-radius: var(--radius-inputs, 8px); border: var(--border-hairline); font-size: 13.5px; padding: 12px 14px; line-height: 1.5;">{{ old('comment') }}</textarea>
                                        @error('comment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="font-weight: 600; font-size: 13.5px; padding: 10px 22px; border-radius: var(--radius-buttons, 8px); box-shadow: 0 2px 6px rgba(0, 117, 222, 0.2);">
                                        <i class="fa fa-paper-plane mr-2"></i> Kirim Ulasan ke Pemilik
                                    </button>
                                </form>
                            </div>
                        </section>

                    </div>
                    <!--end col-md-7 col-lg-8-->

                    <!--RIGHT SIDE: SIDEBAR (Card Sewa/Booking, Details, Hubungi Pemilik, Lokasi, Actions)
                    =============================================================================================-->
                    <div class="col-md-5 col-lg-4">

                        <!--STICKY BOOKING CARD (Notion Pure White Card)-->
                        <div class="card p-4 mb-4" style="position: sticky; top: 110px; z-index: 10; border-radius: 12px; border: var(--border-hairline);">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted small font-weight-bold">
                                        <i class="fa fa-tag mr-1" style="color: var(--color-stone);"></i>Harga Sewa Resmi
                                    </span>
                                    <span class="badge badge-light border text-muted small">Per Bulan</span>
                                </div>

                                <div class="d-flex align-items-baseline mb-3">
                                    <h2 class="font-weight-bold mb-0" style="color: var(--color-midnight-ink); font-size: 1.85rem; letter-spacing: -0.02em;">
                                        Rp {{ number_format($kos['price'], 0, ',', '.') }}
                                    </h2>
                                    <span class="text-muted ml-2">/bln</span>
                                </div>

                                <hr class="my-3" style="border-top: var(--border-hairline);">

                                <div class="d-flex flex-column" style="gap: 10px;">
                                    <a href="{{ route('member.booking.create', $kos['slug']) }}"
                                        class="btn btn-primary btn-block btn-lg font-weight-bold py-3">
                                        <i class="fa fa-calendar-check mr-2"></i>Ajukan Sewa Sekarang
                                    </a>

                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kos['owner_phone'] ?? '6280286216730') }}?text=Halo, saya tertarik dengan {{ urlencode($kos['title']) }}"
                                        target="_blank" class="btn btn-outline-dark btn-block py-2 font-weight-bold">
                                        <i class="fab fa-whatsapp mr-2" style="color: var(--color-midnight-ink);"></i>Tanya Pemilik Langsung
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!--DETAILS
                        =========================================================================================-->
                        <section>
                            <h3>Details</h3>
                            <div class="ts-box">

                                <dl class="ts-description-list__line mb-0">

                                    <dt>Kategori:</dt>
                                    <dd>Kos {{ $kos['type'] ?? '-' }}</dd>

                                    <dt>Status:</dt>
                                    <dd>{{ in_array(strtolower($kos['status'] ?? ''), ['active', 'tersedia', 'aktif']) ? 'Tersedia' : 'Penuh' }}</dd>

                                    <dt>Luas:</dt>
                                    <dd>
                                        @if(!empty($kos['area']))
                                            {!! preg_match('/(m2|m²|m\^2)$/i', trim($kos['area'])) ? e($kos['area']) : e($kos['area']) . ' m<sup>2</sup>' !!}
                                        @else
                                            -
                                        @endif
                                    </dd>

                                    <dt>Kamar:</dt>
                                    <dd>{{ $kos['rooms'] ?? '-' }}</dd>

                                    <dt>K. Mandi:</dt>
                                    <dd>{{ $kos['bathrooms'] ?? '-' }}</dd>

                                    <dt>Tempat Tidur:</dt>
                                    <dd>{{ $kos['bedrooms'] ?? '-' }}</dd>

                                    <dt>Parkir:</dt>
                                    <dd>{{ $kos['garages'] ?? '-' }}</dd>

                                </dl>

                            </div>
                        </section>

                        <!--CONTACT THE AGENT
                        =========================================================================================-->
                        <section class="contact-the-agent">
                            <h3>Hubungi Pemilik</h3>

                            <div class="ts-box">

                                <!--Agent Image & Phone-->
                                <div class="d-flex align-items-center mb-4">

                                    <!--Image / Avatar-->
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-3" style="width: 56px; height: 56px; background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 22px; font-weight: 700; flex-shrink: 0;">
                                        {{ strtoupper(substr($kos['owner_name'] ?? 'P', 0, 1)) }}
                                    </div>

                                    <!--Phone contact-->
                                    <div>
                                        <h5 class="mb-1 font-weight-bold" style="color: var(--color-midnight-ink);">{{ $kos['owner_name'] ?? 'Pemilik Kos' }}</h5>
                                        <p class="mb-0 text-muted" style="font-size: 13.5px;">
                                            <i class="fa fa-phone-alt mr-2" style="color: var(--color-stone);"></i>
                                            {{ $kos['owner_phone'] ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                <!--Agent contact form-->
                                <form id="form-agent" class="ts-form">

                                    <!--Name-->
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Nama Anda">
                                    </div>

                                    <!--Email-->
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email Anda">
                                    </div>

                                    <!--Message-->
                                    <div class="form-group">
                                        <textarea class="form-control" id="form-contact-message" rows="3" name="message"
                                            placeholder="Halo, saya ingin bertanya tentang {{ $kos['title'] }}"></textarea>
                                    </div>

                                    <!--Submit button-->
                                    <div class="form-group clearfix mb-0">
                                        <button type="button" class="btn btn-primary float-right"
                                            id="form-contact-submit" onclick="alert('Fitur hubungi pemilik akan segera tersedia.')">
                                            <i class="fa fa-envelope mr-2"></i>Kirim Pesan
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </section>

                        <!--LOCATION
                        =============================================================================================-->
                        <section id="location">
                            <h3>Lokasi</h3>

                            <div class="ts-box">

                                <dl class="ts-description-list__line mb-0">

                                    <dt><i class="fa fa-map-marker ts-opacity__30 mr-2"></i>Alamat:</dt>
                                    <dd class="border-bottom pb-2">{{ $kos['address'] ?? $kos['city'] }}</dd>

                                    <dt><i class="fa fa-phone-square ts-opacity__30 mr-2"></i>Telepon:</dt>
                                    <dd class="border-bottom pb-2">{{ $kos['owner_phone'] ?? '-' }}</dd>

                                    <dt><i class="fa fa-envelope ts-opacity__30 mr-2"></i>Email:</dt>
                                    <dd class="border-bottom pb-2"><a href="mailto:{{ $kos['owner_email'] ?? 'hello@tempatin.id' }}">{{ $kos['owner_email'] ?? 'hello@tempatin.id' }}</a></dd>

                                    <dt><i class="fa fa-globe ts-opacity__30 mr-2"></i>Website:</dt>
                                    <dd><a href="{{ route('home') }}">tempatin.id</a></dd>

                                </dl>

                            </div>

                        </section>

                        <!--ACTIONS
                        =============================================================================================-->
                        <section id="actions">

                            <div class="d-flex justify-content-between">

                                <button type="button" class="btn btn-light mr-2 w-100 btn-toggle-favorite {{ $isFavorited ? 'is-active' : '' }}" data-slug="{{ $kosSlug }}" data-toggle="tooltip"
                                    data-placement="top" title="{{ $isFavorited ? 'Tersimpan di favorit' : 'Tambah ke favorit' }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                                    <svg class="favorite-heart-svg {{ $isFavorited ? 'is-active' : '' }}" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    <span class="small font-weight-bold">Favorit</span>
                                </button>

                                <a href="#" class="btn btn-light mr-2 w-100" data-toggle="tooltip"
                                    data-placement="top" title="Cetak">
                                    <i class="fa fa-print"></i>
                                </a>

                                <a href="#" class="btn btn-light mr-2 w-100" data-toggle="tooltip"
                                    data-placement="top" title="Bandingkan">
                                    <i class="fa fa-exchange-alt"></i>
                                </a>

                                <a href="#" class="btn btn-light w-100" data-toggle="tooltip" data-placement="top"
                                    title="Bagikan">
                                    <i class="fa fa-share-alt"></i>
                                </a>

                            </div>

                        </section>

                    </div>
                    <!--end col-md-5 col-lg-4-->

                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>

        <!--SIMILAR PROPERTIES
        =============================================================================================================-->
        @if(!empty($similarKos) && count($similarKos) > 0)
        <section id="similar-properties" class="py-5 bg-white border-top">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="mb-1" style="font-size: 1.45rem; font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.015em;">
                            Kos Serupa
                        </h3>
                        <p class="text-muted small mb-0">Rekomendasi hunian sejenis yang mungkin cocok untuk Anda.</p>
                    </div>
                    <span class="badge" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600; font-size: 12px; padding: 6px 14px; border-radius: 20px; border: 1px solid rgba(0, 117, 222, 0.15);">
                        {{ count($similarKos) }} pilihan
                    </span>
                </div>

                <div class="row">
                    @foreach($similarKos as $similar)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="similar-property-card">
                            <!-- Card Image -->
                            <div class="similar-card-img-wrap">
                                <a href="{{ route('kos.show', $similar['slug']) }}" class="d-block w-100 h-100">
                                    <img src="{{ asset($similar['thumbnail']) }}" alt="{{ $similar['title'] }}" loading="lazy" onerror="this.onerror=null; this.src='{{ asset('assets/img/kos/1.png') }}';">
                                </a>

                                <!-- Type Badge -->
                                <span class="similar-type-badge">
                                    Kos {{ ucfirst($similar['type'] ?? 'Campur') }}
                                </span>

                                @if($loop->first)
                                <span class="similar-badge-rec">
                                    <i class="fa fa-star" style="color: #f59e0b; font-size: 10px;"></i> Pilihan Populer
                                </span>
                                @endif
                            </div>

                            <!-- Card Body -->
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <!-- Price -->
                                <div class="d-flex align-items-baseline mb-1">
                                    <span style="font-size: 1.2rem; font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.01em;">
                                        Rp {{ number_format($similar['price'], 0, ',', '.') }}
                                    </span>
                                    <span class="text-muted ml-1" style="font-size: 12px; font-weight: 500;">/bln</span>
                                </div>

                                <!-- Title -->
                                <h4 class="mb-2 text-truncate" style="font-size: 1.02rem; font-weight: 700; color: var(--color-midnight-ink); line-height: 1.35;">
                                    <a href="{{ route('kos.show', $similar['slug']) }}" class="text-reset text-decoration-none" title="{{ $similar['title'] }}">
                                        {{ $similar['title'] }}
                                    </a>
                                </h4>

                                <!-- City / Location -->
                                <div class="d-flex align-items-center text-muted mb-3" style="font-size: 12.5px;">
                                    <i class="fa fa-map-marker-alt mr-1" style="color: var(--color-notion-blue); font-size: 11.5px; flex-shrink: 0;"></i>
                                    <span class="text-truncate">{{ $similar['city'] ?? '-' }}</span>
                                </div>

                                <!-- Specs row -->
                                <div class="d-flex align-items-center justify-content-between pt-2 mt-auto" style="border-top: 1px solid rgba(0, 0, 0, 0.06); font-size: 12px; color: var(--color-stone);">
                                    <span class="d-inline-flex align-items-center" title="Luas Kamar">
                                        <i class="fa fa-ruler-combined mr-1" style="color: var(--color-stone); font-size: 11px;"></i>
                                        {{ !empty($similar['area']) ? $similar['area'] . ' m²' : '12 m²' }}
                                    </span>
                                    <span class="d-inline-flex align-items-center" title="Jumlah Kamar">
                                        <i class="fa fa-bed mr-1" style="color: var(--color-stone); font-size: 11px;"></i>
                                        {{ !empty($similar['bedrooms']) ? $similar['bedrooms'] . ' Kamar' : '1 Kamar' }}
                                    </span>
                                    <span class="d-inline-flex align-items-center" title="Kamar Mandi">
                                        <i class="fa fa-bath mr-1" style="color: var(--color-stone); font-size: 11px;"></i>
                                        {{ !empty($similar['bathrooms']) ? $similar['bathrooms'] : 'Dalam KM' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="px-3 pb-3">
                                <a href="{{ route('kos.show', $similar['slug']) }}" class="btn btn-block d-flex align-items-center justify-content-center similar-card-btn">
                                    <span>Lihat Detail</span>
                                    <i class="fa fa-arrow-right ml-2" style="font-size: 10px; color: var(--color-notion-blue);"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

    </main>
    <!--end #ts-main-->

    @include('partials.footer')

</div>
<!--end page-->

@push('scripts')
@if($hasValidCoordinates)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var mapContainer = document.getElementById('property-map');
    if (!mapContainer || typeof L === 'undefined') return;

    // Fix default marker icon paths when using Leaflet from CDN
    delete L.Icon.Default.prototype._getIconUrl;
    L.Icon.Default.mergeOptions({
        iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
    });

    var lat = {{ (float) $lat }};
    var lng = {{ (float) $lng }};
    var title = @json($kos['title']);
    var address = @json($kos['address'] ?? $kos['city']);

    var map = L.map('property-map', {
        scrollWheelZoom: false,
        zoomControl: true
    }).setView([lat, lng], 15);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker([lat, lng]).addTo(map);

    var popupHtml = '<div style="font-weight: 700; color: #111827; margin-bottom: 2px;">' + title + '</div>' +
        '<div style="color: #6b7280; font-size: 11.5px; margin-bottom: 8px;">' + address + '</div>' +
        '<a href="https://www.google.com/maps/search/?api=1&query=' + lat + ',' + lng + '" target="_blank" rel="noopener noreferrer" style="color: #0075de; font-weight: 600; text-decoration: none; font-size: 11.5px;"><i class="fa fa-external-link-alt mr-1"></i> Buka di Google Maps &rarr;</a>';

    marker.bindPopup(popupHtml);

    // Enable scroll wheel zoom on click, disable on mouse leave
    map.on('click', function () {
        map.scrollWheelZoom.enable();
    });
    map.on('mouseout', function () {
        map.scrollWheelZoom.disable();
    });

    // Invalidate map size so all tiles render properly
    setTimeout(function () {
        map.invalidateSize();
    }, 250);

    window.addEventListener('resize', function () {
        map.invalidateSize();
    });
});
</script>
@endif
<script>
$(document).ready(function() {
    $('.btn-toggle-favorite').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const $btn = $(this);
        const slug = $btn.data('slug');
        const $svgs = $('.btn-toggle-favorite[data-slug="' + slug + '"] .favorite-heart-svg');
        const $btns = $('.btn-toggle-favorite[data-slug="' + slug + '"]');
        const $label = $('#detailFavoriteText');

        $.ajax({
            url: '{{ route("kos.favorit.toggle") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                slug: slug
            },
            success: function(res) {
                if (res.is_favorite) {
                    $svgs.addClass('is-active is-pop');
                    $btns.addClass('is-active').attr('title', 'Tersimpan di favorit');
                    if ($label.length) $label.text('Tersimpan di Favorit');
                } else {
                    $svgs.removeClass('is-active').addClass('is-pop');
                    $btns.removeClass('is-active').attr('title', 'Simpan ke favorit');
                    if ($label.length) $label.text('Simpan ke Favorit');
                }
                setTimeout(function() {
                    $svgs.removeClass('is-pop');
                }, 400);
            },
            error: function() {
                alert('Gagal memperbarui status favorit.');
            }
        });
    });

    // Interactive Star Rating Widget
    const ratingLabels = {
        1: '1.0 (Sangat Buruk)',
        2: '2.0 (Kurang)',
        3: '3.0 (Cukup)',
        4: '4.0 (Puas)',
        5: '5.0 (Sangat Puas)'
    };
    const $stars = $('.star-rating-widget .star-btn');
    const $ratingInput = $('#selectedRatingInput');
    const $descLabel = $('#star-desc-label');

    function updateStarsDisplay(val) {
        $stars.each(function() {
            const starVal = parseInt($(this).data('rating'), 10);
            if (starVal <= val) {
                $(this).addClass('active');
            } else {
                $(this).removeClass('active');
            }
        });
        $descLabel.text(ratingLabels[val] || val + '.0');
    }

    $stars.on('click', function() {
        const val = parseInt($(this).data('rating'), 10);
        $ratingInput.val(val);
        updateStarsDisplay(val);
    });

    $stars.on('mouseenter', function() {
        const hoverVal = parseInt($(this).data('rating'), 10);
        $stars.each(function() {
            const starVal = parseInt($(this).data('rating'), 10);
            if (starVal <= hoverVal) {
                $(this).addClass('hover-active');
            } else {
                $(this).removeClass('hover-active');
            }
        });
        $descLabel.text(ratingLabels[hoverVal] || hoverVal + '.0');
    });

    $('#starRatingWidget .stars-list').on('mouseleave', function() {
        $stars.removeClass('hover-active');
        const selectedVal = parseInt($ratingInput.val(), 10) || 5;
        updateStarsDisplay(selectedVal);
    });

    // Inisialisasi awal
    const initRating = parseInt($ratingInput.val(), 10) || 5;
    updateStarsDisplay(initRating);

    // Toggle Collapse / Expand Reviews (Batasi 2 komentar, hilangkan blur saat dibuka)
    $('#btn-toggle-reviews').on('click', function(e) {
        e.preventDefault();
        const $wrapper = $('#reviews-wrapper');
        const isCollapsed = $wrapper.hasClass('is-collapsed');
        
        if (isCollapsed) {
            $wrapper.removeClass('is-collapsed');
            $('.review-item-hidden').removeClass('review-item-hidden').hide().slideDown(300);
            $('#reviews-btn-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            $('#reviews-btn-text').text('Tutup Sebagian Ulasan');
        } else {
            $wrapper.addClass('is-collapsed');
            $('.review-item-card').each(function() {
                if (parseInt($(this).data('index'), 10) >= 2) {
                    $(this).addClass('review-item-hidden');
                }
            });
            $('#reviews-btn-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            const total = {{ $reviewCount }};
            $('#reviews-btn-text').text('Lihat Semua Ulasan (' + total + ')');
        }
    });

    // Filter Ulasan Berdasarkan Rating Bintang
    $('.btn-review-filter').on('click', function() {
        const $btn = $(this);
        $('.btn-review-filter').removeClass('active');
        $btn.addClass('active');

        const selectedRating = $btn.data('rating');
        const $wrapper = $('#reviews-wrapper');
        const $fadeContainer = $('#reviews-fade-container');
        const $noMatchAlert = $('#no-matching-reviews');

        if (selectedRating === 'all') {
            // Mode "Semua": kembali ke tampilan 2 ulasan awal + fade jika > 2
            $noMatchAlert.hide();
            const totalCount = {{ $reviewCount }};

            if (totalCount > 2) {
                $wrapper.addClass('is-collapsed');
                $('.review-item-card').each(function() {
                    const idx = parseInt($(this).data('index'), 10);
                    if (idx < 2) {
                        $(this).removeClass('review-item-hidden').show();
                    } else {
                        $(this).addClass('review-item-hidden').hide();
                    }
                });
                $fadeContainer.show();
                $('#reviews-btn-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                $('#reviews-btn-text').text('Lihat Semua Ulasan (' + totalCount + ')');
            } else {
                $wrapper.removeClass('is-collapsed');
                $('.review-item-card').removeClass('review-item-hidden').show();
                $fadeContainer.hide();
            }
        } else {
            // Mode Filter Rating Tertentu (1, 2, 3, 4, atau 5)
            const targetRating = parseInt(selectedRating, 10);
            
            // Hilangkan status collapsed saat memfilter
            $wrapper.removeClass('is-collapsed');
            $fadeContainer.hide();

            let matchCount = 0;
            $('.review-item-card').each(function() {
                const cardRating = parseInt($(this).data('rating'), 10);
                if (cardRating === targetRating) {
                    $(this).removeClass('review-item-hidden').fadeIn(200);
                    matchCount++;
                } else {
                    $(this).addClass('review-item-hidden').hide();
                }
            });

            if (matchCount === 0) {
                $('#no-matching-reviews-text').html('Belum ada ulasan dengan penilaian <strong>' + targetRating + ' Bintang</strong>.');
                $noMatchAlert.fadeIn(200);
            } else {
                $noMatchAlert.hide();
            }
        }
    });
});
</script>
@endpush
@endsection
