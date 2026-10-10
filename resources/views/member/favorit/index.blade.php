@extends('layouts.app')

@section('title', 'Kos Favorit - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 6px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('member.home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Kos Favorit</li>
                </ol>
            </nav>
        </div>

        <section class="container">
            <!-- HEADER -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <div class="d-inline-flex align-items-center mb-1 px-2 py-1 rounded" style="background-color: #fef2f2; color: #dc2626; font-size: 11px; font-weight: 600;">
                        <i class="fa fa-heart mr-1"></i> SIMPANAN KOS SAYA
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Kos Favorit
                    </h1>
                    <p class="mb-0" style="color: var(--color-stone); font-size: 14px;">
                        Daftar kos pilihan yang Anda sukai untuk memudahkan perbandingan dan proses booking.
                    </p>
                </div>
                <div class="d-none d-sm-block">
                    <a href="{{ route('member.kos.index') }}" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 9px 18px; border: none;">
                        <i class="fa fa-search mr-2"></i> Cari Kos Baru
                    </a>
                </div>
            </div>

            <!-- DAFTAR KOS FAVORIT JIKA ADA -->
            @if(isset($favoriteKos) && $favoriteKos->count() > 0)
                <div class="row mb-5" id="favoritListGrid">
                    @foreach($favoriteKos as $kos)
                        @php
                            $thumbUrl = asset('assets/img/hero.jpg');
                            if ($kos->photos && $kos->photos->first()) {
                                $photoPath = $kos->photos->first()->photo_path;
                                $thumbUrl = str_starts_with($photoPath, 'assets/') ? asset($photoPath) : asset('storage/' . $photoPath);
                            } elseif ($kos->thumbnail) {
                                $thumbUrl = str_starts_with($kos->thumbnail, 'assets/') ? asset($kos->thumbnail) : asset('storage/' . $kos->thumbnail);
                            }
                            $typeClass = match(strtolower($kos->type ?? 'campur')) {
                                'putra' => 'badge-type-putra',
                                'putri' => 'badge-type-putri',
                                'eksklusif' => 'badge-type-eksklusif',
                                default => 'badge-type-campur',
                            };
                        @endphp
                        <div class="col-md-6 col-lg-4 mb-4 favorit-card-col" id="favorit-col-{{ $kos->slug }}">
                            <div class="card h-100 border-0 shadow-sm" style="border-radius: var(--radius-cards); overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; background: #ffffff;">
                                <div class="position-relative" style="height: 200px; background-color: #f1f5f9;">
                                    <a href="{{ route('member.kos.show', $kos->slug) }}">
                                        <img src="{{ $thumbUrl }}" alt="{{ $kos->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    </a>
                                    
                                    <!-- Label Kos (Layer Putih, Teks Biru, Rounded Rectangle) -->
                                    <span class="position-absolute" style="top: 12px; left: 12px; z-index: 2;">
                                        <span class="badge {{ $typeClass }} ts-card-badge-type">
                                            Kos {{ ucfirst($kos->type ?? 'Campur') }}
                                        </span>
                                    </span>

                                    <!-- Favorite Heart Button (Merah karena sudah di favorit, klik untuk toggle) -->
                                    <button type="button" class="btn-card-favorite position-absolute btn-toggle-favorite is-active" data-slug="{{ $kos->slug }}" data-remove-card="true" style="top: 12px; right: 12px; z-index: 3;" title="Hapus dari favorit" aria-label="Hapus dari favorit">
                                        <svg class="favorite-heart-svg is-active" viewBox="0 0 24 24">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="text-muted small mb-1">
                                            <i class="fa fa-map-marker-alt mr-1 text-danger"></i> {{ $kos->city ?? 'Indonesia' }}
                                        </div>
                                        <h3 class="h6 font-weight-bold mb-2 text-dark text-truncate" title="{{ $kos->title }}">
                                            <a href="{{ route('member.kos.show', $kos->slug) }}" class="text-dark text-decoration-none">
                                                {{ $kos->title }}
                                            </a>
                                        </h3>
                                        <p class="text-muted small mb-2 text-truncate">
                                            {{ $kos->address ?? 'Lokasi strategis dan nyaman.' }}
                                        </p>
                                    </div>
                                    <div class="pt-2 border-top d-flex justify-content-between align-items-center mt-2">
                                        <div>
                                            <span class="font-weight-bold" style="color: var(--color-notion-blue); font-size: 15px;">
                                                Rp {{ number_format($kos->price, 0, ',', '.') }}
                                            </span>
                                            <span class="text-muted" style="font-size: 11px;">/bln</span>
                                        </div>
                                        <a href="{{ route('member.kos.show', $kos->slug) }}" class="btn btn-sm btn-outline-primary px-3" style="border-radius: 6px; font-size: 12px; font-weight: 600;">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- EMPTY STATE CARD -->
            <div id="favoritEmptyStateCard" class="p-5 text-center rounded mb-5 {{ (isset($favoriteKos) && $favoriteKos->count() > 0) ? 'd-none' : '' }}" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; border-radius: 50%; background-color: #fee2e2; color: #ef4444; font-size: 28px;">
                    <i class="fa fa-heart"></i>
                </div>
                <h2 style="font-family: var(--font-serif); font-size: 1.4rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">
                    Belum Ada Kos Favorit yang Disimpan
                </h2>
                <p style="font-size: 14px; color: var(--color-stone); max-width: 500px; margin: 0 auto 24px; line-height: 1.6;">
                    Temukan kos idaman Anda sekarang dan klik ikon hati untuk menyimpannya ke daftar favorit agar dapat dipantau kapan saja.
                </p>
                <div>
                    <a href="{{ route('member.kos.index') }}" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13.5px; padding: 10px 24px; border-radius: var(--radius-buttons); border: none; box-shadow: 0 2px 8px rgba(0, 117, 222, 0.25);">
                        <i class="fa fa-compass mr-2"></i> Eksplorasi Kos Sekarang
                    </a>
                </div>
            </div>

            <!-- REKOMENDASI KOS UNTUK ANDA -->
            @if(isset($recommendedKos) && $recommendedKos->count() > 0)
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 style="font-family: var(--font-serif); font-size: 1.35rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
                            Rekomendasi Kos Pilihan
                        </h2>
                        <a href="{{ route('member.kos.index') }}" style="font-size: 13px; font-weight: 600; color: var(--color-notion-blue); text-decoration: none;">
                            Lihat Semua <i class="fa fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="row">
                        @foreach($recommendedKos as $kos)
                            @php
                                $thumbUrl = asset('assets/img/hero.jpg');
                                if ($kos->photos && $kos->photos->first()) {
                                    $photoPath = $kos->photos->first()->photo_path;
                                    $thumbUrl = str_starts_with($photoPath, 'assets/') ? asset($photoPath) : asset('storage/' . $photoPath);
                                } elseif ($kos->thumbnail) {
                                    $thumbUrl = str_starts_with($kos->thumbnail, 'assets/') ? asset($kos->thumbnail) : asset('storage/' . $kos->thumbnail);
                                }
                                $typeClass = match(strtolower($kos->type ?? 'campur')) {
                                    'putra' => 'badge-type-putra',
                                    'putri' => 'badge-type-putri',
                                    'eksklusif' => 'badge-type-eksklusif',
                                    default => 'badge-type-campur',
                                };
                                $isFav = in_array($kos->slug, session('member_favorites', []));
                            @endphp
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 border-0 shadow-sm" style="border-radius: var(--radius-cards); overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; background: #ffffff;">
                                    <div class="position-relative" style="height: 180px; background-color: #f1f5f9;">
                                        <a href="{{ route('member.kos.show', $kos->slug) }}">
                                            <img src="{{ $thumbUrl }}" alt="{{ $kos->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        </a>

                                        <!-- Label Kos (Layer Putih, Teks Biru, Rounded Rectangle) -->
                                        <span class="position-absolute" style="top: 12px; left: 12px; z-index: 2;">
                                            <span class="badge {{ $typeClass }} ts-card-badge-type">
                                                Kos {{ ucfirst($kos->type ?? 'Campur') }}
                                            </span>
                                        </span>

                                        <!-- Favorite Heart Button -->
                                        <button type="button" class="btn-card-favorite position-absolute btn-toggle-favorite {{ $isFav ? 'is-active' : '' }}" data-slug="{{ $kos->slug }}" style="top: 12px; right: 12px; z-index: 3;" title="{{ $isFav ? 'Hapus dari favorit' : 'Simpan ke favorit' }}" aria-label="Simpan ke favorit">
                                            <svg class="favorite-heart-svg {{ $isFav ? 'is-active' : '' }}" viewBox="0 0 24 24">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                                        <div>
                                            <div class="text-muted small mb-1">
                                                <i class="fa fa-map-marker-alt mr-1 text-danger"></i> {{ $kos->city ?? 'Indonesia' }}
                                            </div>
                                            <h3 class="h6 font-weight-bold mb-2 text-dark text-truncate" title="{{ $kos->title }}">
                                                <a href="{{ route('member.kos.show', $kos->slug) }}" class="text-dark text-decoration-none">
                                                    {{ $kos->title }}
                                                </a>
                                            </h3>
                                        </div>
                                        <div class="pt-2 border-top d-flex justify-content-between align-items-center mt-2">
                                            <div>
                                                <span class="font-weight-bold" style="color: var(--color-notion-blue); font-size: 14px;">
                                                    Rp {{ number_format($kos->price, 0, ',', '.') }}
                                                </span>
                                                <span class="text-muted" style="font-size: 11px;">/bln</span>
                                            </div>
                                            <a href="{{ route('member.kos.show', $kos->slug) }}" class="btn btn-sm btn-outline-primary" style="border-radius: 6px; font-size: 12px; font-weight: 600;">
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </section>

    </main>

    @include('partials.footer')

</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.btn-toggle-favorite').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const $btn = $(this);
        const slug = $btn.data('slug');
        const removeCard = $btn.data('remove-card') === true;
        const $svgs = $('.btn-toggle-favorite[data-slug="' + slug + '"] .favorite-heart-svg');
        const $btns = $('.btn-toggle-favorite[data-slug="' + slug + '"]');

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
                } else {
                    $svgs.removeClass('is-active').addClass('is-pop');
                    $btns.removeClass('is-active').attr('title', 'Simpan ke favorit');
                    if (removeCard) {
                        $('#favorit-col-' + slug).fadeOut(300, function() {
                            $(this).remove();
                            if ($('#favoritListGrid .favorit-card-col').length === 0) {
                                $('#favoritListGrid').remove();
                                $('#favoritEmptyStateCard').removeClass('d-none');
                            }
                        });
                    }
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
});
</script>
@endpush
@endsection
