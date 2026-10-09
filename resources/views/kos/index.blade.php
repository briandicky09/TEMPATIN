@extends('layouts.app')

@section('title', 'Cari Kos - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" class="py-4">

        <!-- Breadcrumb & Page Title -->
        <section class="py-3" style="border-bottom: var(--border-hairline);">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-2" style="font-size: 13px;">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active text-dark font-weight-bold" aria-current="page">Pencarian Kos</li>
                    </ol>
                </nav>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                    <div>
                        <h1 class="mb-1" style="font-size: 2rem; letter-spacing: -0.03em;">Eksplorasi Kos</h1>
                        <p class="font-editorial mb-0 text-muted" style="font-size: 1.05rem;">
                            Temukan kos terverifikasi di berbagai kota dengan fasilitas lengkap dan harga transparan.
                        </p>
                    </div>
                    <div class="mt-2 mt-md-0">
                        <span class="badge badge-light border text-dark px-3 py-2">
                            <i class="fa fa-list-ul mr-1 text-primary"></i> Total {{ count($listKos) }} Kos Tersedia
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content (Filter Left, Results Right) -->
        <section class="py-4">
            <div class="container">
                <div class="row">

                    <!-- Filter Sidebar (Left Column) -->
                    <div class="col-lg-4 mb-4">
                        <aside class="card p-4 sticky-top" style="top: 110px; z-index: 5;">
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: var(--border-hairline);">
                                <h3 class="h6 mb-0 font-weight-bold text-dark">
                                    <i class="fa fa-filter text-primary mr-1"></i> Filter Pencarian
                                </h3>
                                <a href="{{ route('search.kos') }}" class="small text-muted text-decoration-none">Reset</a>
                            </div>

                            <form action="{{ route('search.kos') }}" method="GET" class="ts-form">
                                <!-- Keyword -->
                                <div class="form-group mb-3">
                                    <label for="keyword" class="small font-weight-bold">Kata Kunci / Nama Kos</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" 
                                           value="{{ request('keyword') }}" placeholder="Contoh: Anggrek, UGM, Dago">
                                </div>

                                <!-- Type -->
                                <div class="form-group mb-3">
                                    <label for="type" class="small font-weight-bold">Tipe Kos</label>
                                    <select class="custom-select" id="type" name="type">
                                        <option value="">Semua Tipe</option>
                                        <option value="putra" {{ request('type') === 'putra' ? 'selected' : '' }}>Kos Putra</option>
                                        <option value="putri" {{ request('type') === 'putri' ? 'selected' : '' }}>Kos Putri</option>
                                        <option value="campur" {{ request('type') === 'campur' ? 'selected' : '' }}>Kos Campur</option>
                                        <option value="eksklusif" {{ request('type') === 'eksklusif' ? 'selected' : '' }}>Kos Eksklusif</option>
                                    </select>
                                </div>

                                <!-- City -->
                                <div class="form-group mb-3">
                                    <label for="city" class="small font-weight-bold">Kota / Wilayah</label>
                                    <input type="text" class="form-control" id="city" name="city" 
                                           value="{{ request('city') }}" placeholder="Contoh: Surabaya, Yogyakarta">
                                </div>

                                <!-- Max Price -->
                                <div class="form-group mb-4">
                                    <label for="max_price" class="small font-weight-bold">Batas Harga Maksimal (Rp)</label>
                                    <input type="number" class="form-control" id="max_price" name="max_price" 
                                           value="{{ request('max_price') }}" placeholder="Contoh: 1500000">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary btn-block py-2 font-weight-bold">
                                    <i class="fa fa-search mr-1"></i> Terapkan Filter
                                </button>
                            </form>
                        </aside>
                    </div>

                    <!-- Kos Listing Results (Right Column) -->
                    <div class="col-lg-8">
                        <div class="row">
                            @forelse($listKos as $kos)
                            <div class="col-12 mb-4">
                                <div class="card ts-item ts-item__list h-100">
                                    
                                    <!-- Image Thumbnail -->
                                    <a href="{{ route('kos.show', $kos['slug']) }}" class="card-img ts-item__image" 
                                       style="background-image: url('{{ asset($kos['thumbnail']) }}'); background-size: cover; background-position: center; min-height: 200px;">
                                        <!-- Type Pill Badge -->
                                        @php
                                            $typeLower = strtolower($kos['type'] ?? 'campur');
                                            $typeClass = match($typeLower) {
                                                'putra' => 'badge-type-putra',
                                                'putri' => 'badge-type-putri',
                                                'eksklusif' => 'badge-type-eksklusif',
                                                default => 'badge-type-campur',
                                            };
                                        @endphp
                                        <span class="position-absolute" style="top: 12px; left: 12px; z-index: 2;">
                                            <span class="badge {{ $typeClass }}">
                                                Kos {{ ucfirst($kos['type'] ?? 'Campur') }}
                                            </span>
                                        </span>
                                    </a>

                                    <!-- Content Body -->
                                    <div class="card-body p-3 p-md-4 d-flex flex-column justify-content-between">
                                        <div>
                                            <!-- Meta row: Rating, City, Availability -->
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted small">
                                                    <i class="fa fa-map-marker-alt text-primary mr-1"></i>
                                                    {{ $kos['city'] }}
                                                </span>
                                                <span class="ts-card__rating">
                                                    <i class="fa fa-star"></i>
                                                    <span>{{ number_format($kos['rating'] ?? 4.8, 1) }}</span>
                                                </span>
                                            </div>

                                            <!-- Title -->
                                            <h4 class="mb-2" style="font-size: 1.2rem; font-weight: 700;">
                                                <a href="{{ route('kos.show', $kos['slug']) }}" class="text-dark text-decoration-none">
                                                    {{ $kos['title'] }}
                                                </a>
                                            </h4>

                                            <!-- Address -->
                                            <p class="text-muted small mb-3">
                                                {{ $kos['address'] ?? 'Lokasi strategis, dekat transportasi umum dan kampus.' }}
                                            </p>

                                            <!-- Facility Description -->
                                            <div class="ts-description-lists py-2" style="border-top: var(--border-hairline);">
                                                <dl>
                                                    <dt>Tipe</dt>
                                                    <dd>{{ ucfirst($kos['type'] ?? 'Campur') }}</dd>
                                                </dl>
                                                <dl>
                                                    <dt>Kamar</dt>
                                                    <dd>{{ $kos['bedrooms'] ?? '1' }} Kamar</dd>
                                                </dl>
                                                <dl>
                                                    <dt>K. Mandi</dt>
                                                    <dd>{{ $kos['bathrooms'] ?? 'Dalam' }}</dd>
                                                </dl>
                                            </div>
                                        </div>

                                        <!-- Price and Action Bar -->
                                        <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 mt-2" style="border-top: var(--border-hairline);">
                                            <div>
                                                <span class="text-muted small d-block">Harga Sewa:</span>
                                                <span class="font-weight-bold text-primary" style="font-size: 1.25rem;">
                                                    Rp {{ number_format($kos['price'], 0, ',', '.') }}
                                                    <span class="text-muted font-weight-normal" style="font-size: 12px;">/bln</span>
                                                </span>
                                            </div>
                                            <div>
                                                <a href="{{ route('kos.show', $kos['slug']) }}" class="btn btn-ghost btn-sm font-weight-bold">
                                                    <span>Lihat Detail</span>
                                                    <i class="fa fa-arrow-right ml-1"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <div class="card p-5 text-center">
                                    <div class="text-muted mb-3" style="font-size: 36px;"><i class="fa fa-search"></i></div>
                                    <h4 class="font-weight-bold mb-2">Tidak Menemukan Kos</h4>
                                    <p class="text-muted mb-4">Coba ubah kata kunci atau bersihkan filter pencarian Anda.</p>
                                    <div>
                                        <a href="{{ route('search.kos') }}" class="btn btn-outline-dark btn-sm">Reset Semua Filter</a>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
