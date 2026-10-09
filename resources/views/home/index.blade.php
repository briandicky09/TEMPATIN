@extends('layouts.app')

@section('title', 'TEMPATIN - Ruang Pencarian Kos Modern & Terpercaya')

@section('content')
<div class="ts-page-wrapper" id="page-top">

    @include('partials.navbar')
    @include('partials.alert')

    <!-- =========================================================================
         1. NOTION HERO (CENTERED STACK LAYOUT)
         ========================================================================= -->
    <section class="pt-3 pb-5" style="background-color: var(--surface-page-canvas); border-bottom: var(--border-hairline);">
        <div class="container pt-2 pb-4 text-center">

            <!-- Avatar Character Marks Row -->
            <div class="notion-character-row">
                <span class="notion-character-mark" title="Pencari Kos"><i class="fa fa-user-graduate"></i></span>
                <span class="notion-character-mark" title="Mahasiswi"><i class="fa fa-laptop"></i></span>
                <span class="notion-character-mark" title="Pemilik Kos"><i class="fa fa-home"></i></span>
                <span class="notion-character-mark" title="Pekerja Mandiri"><i class="fa fa-briefcase"></i></span>
                <span class="notion-character-mark" title="Komunitas"><i class="fa fa-users"></i></span>
            </div>

            <!-- Main Display Headline -->
            <div class="mb-3 mx-auto text-center" style="max-width: 920px;">
                <h1 class="mb-3 text-center" style="font-size: clamp(2.1rem, 4.8vw, 3.6rem); letter-spacing: -0.035em; line-height: 1.25;">
                    <span class="d-block text-center">Temukan Kos Impianmu</span>
                    <span class="d-inline-flex justify-content-center align-items-center flex-wrap text-center" style="gap: 0.28em;">
                        <span class="ts-rolodex-container" id="tsRolodexContainer"><span class="ts-rolodex-slot" id="tsRolodexSlot" style="min-width: 180px; width: 255px;"><span class="ts-rolodex-word is-active">dengan Mudah</span></span></span>
                        <span>&amp; Transparan.</span>
                    </span>
                </h1>
                <p class="font-editorial mx-auto mb-4 text-center" style="font-size: 1.2rem; line-height: 1.6; max-width: 680px; color: var(--color-graphite);">
                    Platform pencarian kos modern dengan kurasi terverifikasi, detail fasilitas akurat, dan proses booking instan di seluruh kota Indonesia.
                </p>
            </div>

            <!-- Two-button CTA Row -->
            <div class="d-flex flex-wrap justify-content-center align-items-center mb-5" style="gap: 12px;">
                <a href="#cari-kos-mockup" class="btn btn-primary btn-lg">
                    <span>Eksplorasi Kos Sekarang</span>
                    <i class="fa fa-arrow-down ml-1" style="font-size: 12px;"></i>
                </a>
                <a href="{{ route('owner.kos.create') }}" class="btn btn-ghost btn-lg">
                    <i class="fa fa-plus-circle mr-1"></i>
                    <span>Daftarkan Kos Kamu</span>
                </a>
            </div>

            <!-- Centered Product UI Mockup (Search & Workspace Window) -->
            <div class="notion-app-mockup text-left mx-auto" id="cari-kos-mockup" style="max-width: 1040px;">
                
                <!-- Mockup Chrome Header -->
                <div class="notion-app-mockup__chrome">
                    <div class="notion-app-mockup__dots">
                        <span class="notion-app-mockup__dot notion-app-mockup__dot--red"></span>
                        <span class="notion-app-mockup__dot notion-app-mockup__dot--yellow"></span>
                        <span class="notion-app-mockup__dot notion-app-mockup__dot--green"></span>
                    </div>
                    <div class="notion-app-mockup__title">
                        <i class="fa fa-search text-muted mr-1"></i>
                        <span>tempatin.id / workspace / cari-kos</span>
                    </div>
                </div>

                <!-- Mockup Body (Interactive Search Form) -->
                <div class="notion-app-mockup__body">
                    <form action="{{ route('search.kos') }}" method="GET" class="ts-form">
                        <div class="row">
                            <!-- Kota -->
                            <div class="col-md-3 form-group mb-3">
                                <label><i class="fa fa-map-marker-alt text-primary mr-1"></i> Kota Pilihan</label>
                                <select class="custom-select" id="city" name="city">
                                    <option value="">Semua Kota</option>
                                    <option value="jakarta">Jakarta</option>
                                    <option value="bandung">Bandung</option>
                                    <option value="yogyakarta">Yogyakarta</option>
                                    <option value="surabaya">Surabaya</option>
                                    <option value="malang">Malang</option>
                                    <option value="semarang">Semarang</option>
                                </select>
                            </div>

                            <!-- Tipe Kos -->
                            <div class="col-md-3 form-group mb-3">
                                <label><i class="fa fa-users text-primary mr-1"></i> Tipe Kos</label>
                                <select class="custom-select" id="type" name="type">
                                    <option value="">Semua Tipe</option>
                                    <option value="putra">Kos Putra</option>
                                    <option value="putri">Kos Putri</option>
                                    <option value="campur">Kos Campur</option>
                                    <option value="eksklusif">Kos Eksklusif</option>
                                </select>
                            </div>

                            <!-- Kata Kunci -->
                            <div class="col-md-3 form-group mb-3">
                                <label><i class="fa fa-tag text-primary mr-1"></i> Nama / Kampus</label>
                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Contoh: Dekat UGM, Melati">
                            </div>

                            <!-- Rentang Harga Maksimal -->
                            <div class="col-md-3 form-group mb-3">
                                <label><i class="fa fa-wallet text-primary mr-1"></i> Harga Maksimal</label>
                                <input type="number" class="form-control" id="max_price" name="max_price" placeholder="Contoh: 1500000">
                            </div>
                        </div>

                        <!-- Action Bar inside Mockup -->
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-2" style="border-top: var(--border-hairline); gap: 12px;">
                            <!-- Quick Filter Pills -->
                            <div class="d-flex flex-wrap align-items-center" style="gap: 6px;">
                                <span class="text-muted small mr-2">Paling Dicari:</span>
                                <a href="{{ route('search.kos', ['city' => 'yogyakarta']) }}" class="badge badge-light border text-dark text-decoration-none"><i class="fa fa-map-marker-alt mr-1 text-muted"></i> Yogyakarta</a>
                                <a href="{{ route('search.kos', ['city' => 'surabaya']) }}" class="badge badge-light border text-dark text-decoration-none"><i class="fa fa-map-marker-alt mr-1 text-muted"></i> Surabaya</a>
                                <a href="{{ route('search.kos', ['city' => 'bandung']) }}" class="badge badge-light border text-dark text-decoration-none"><i class="fa fa-map-marker-alt mr-1 text-muted"></i> Bandung</a>
                                <a href="{{ route('search.kos', ['type' => 'putri']) }}" class="badge badge-light border text-dark text-decoration-none">Kos Putri</a>
                                <a href="{{ route('search.kos', ['type' => 'putra']) }}" class="badge badge-light border text-dark text-decoration-none">Kos Putra</a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold w-100 w-md-auto">
                                <i class="fa fa-search mr-1"></i> Cari Kos Sekarang
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </section>

    <!-- =========================================================================
         2. HORIZONTALLY SCROLLING TICKER (PILIHAN KOS FAVORIT TANPA TANDA KURUNG)
         ========================================================================= -->
    <section class="ts-ticker-wrapper" aria-label="Kampus dan Kawasan Populer">
        <div class="ts-ticker-fade-left"></div>
        <div class="ts-ticker-fade-right"></div>
        
        <div class="container text-center mb-3">
            <span class="text-uppercase small font-weight-bold" style="letter-spacing: 0.08em; color: var(--color-stone);">
                Pilihan Kos Terfavorit di Dekat Kampus &amp; Pusat Bisnis Terkemuka
            </span>
        </div>

        @php
            $campuses = [
                ['name' => 'Universitas Indonesia - Depok & Salemba', 'icon' => 'fa-graduation-cap', 'city' => 'jakarta'],
                ['name' => 'Institut Teknologi Bandung - Ganesha', 'icon' => 'fa-graduation-cap', 'city' => 'bandung'],
                ['name' => 'Universitas Gadjah Mada - Bulaksumur', 'icon' => 'fa-graduation-cap', 'city' => 'yogyakarta'],
                ['name' => 'Universitas Airlangga - Surabaya', 'icon' => 'fa-graduation-cap', 'city' => 'surabaya'],
                ['name' => 'Universitas Brawijaya - Malang', 'icon' => 'fa-graduation-cap', 'city' => 'malang'],
                ['name' => 'Institut Teknologi Sepuluh Nopember - Sukolilo', 'icon' => 'fa-graduation-cap', 'city' => 'surabaya'],
                ['name' => 'Universitas Diponegoro - Tembalang', 'icon' => 'fa-graduation-cap', 'city' => 'semarang'],
                ['name' => 'Universitas Padjadjaran - Jatinangor', 'icon' => 'fa-graduation-cap', 'city' => 'bandung'],
                ['name' => 'BINUS University - Jakarta & Alam Sutera', 'icon' => 'fa-university', 'city' => 'jakarta'],
                ['name' => 'Telkom University - Bandung Terpadu', 'icon' => 'fa-university', 'city' => 'bandung'],
            ];
        @endphp

        <div class="ts-ticker-track" id="tsCampusTicker">
            {{-- Set 1 --}}
            @foreach($campuses as $campus)
                <a href="{{ route('search.kos', ['city' => $campus['city']]) }}" class="ts-ticker-item">
                    <i class="fa {{ $campus['icon'] }}"></i>
                    <span>{{ $campus['name'] }}</span>
                </a>
            @endforeach

            {{-- Set 2 (Duplicate for Seamless Endless Looping) --}}
            @foreach($campuses as $campus)
                <a href="{{ route('search.kos', ['city' => $campus['city']]) }}" class="ts-ticker-item" aria-hidden="true" tabindex="-1">
                    <i class="fa {{ $campus['icon'] }}"></i>
                    <span>{{ $campus['name'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- =========================================================================
         3. NILAI UTAMA (INTERACTIVE MAGIC BENTO GRID)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas); border-top: var(--border-hairline);">
        <div class="container py-4">

            <!-- Section Header -->
            <div class="text-center mx-auto mb-4" style="max-width: 640px;">
                <span class="badge badge-primary mb-2">Nilai Utama</span>
                <h2 style="letter-spacing: -0.03em;">Dibuat untuk Pengalaman Sewa Tanpa Cemas</h2>
                <p class="font-editorial" style="font-size: 1.15rem; color: var(--color-graphite);">
                    Standar baru menyewa kos: transparan, terjamin, dan didukung teknologi modern.
                </p>
            </div>

            <!-- Magic Bento Grid (6 Asymmetric Responsive Bento Cards) -->
            <div class="ts-magic-bento-grid" id="tsMagicBentoGrid">

                <!-- Card 0: Col Span 2 (Verifikasi Fisik 100%) -->
                <div class="ts-bento-card ts-bento-card-0" data-bento="card">
                    <div class="ts-bento-spotlight"></div>
                    <div class="ts-bento-border-glow"></div>
                    <div class="ts-bento-content">
                        <div>
                            <div class="ts-bento-header">
                                <div class="ts-bento-icon-wrapper">
                                    <i class="fa fa-shield-alt"></i>
                                </div>
                                <span class="badge badge-light border text-primary font-weight-bold">100% Bebas Fiktif</span>
                            </div>
                            <span class="ts-bento-label">Inspeksi Resmi</span>
                            <h3 class="ts-bento-title">Setiap Kamar Diinspeksi Langsung &amp; Terverifikasi</h3>
                            <p class="ts-bento-desc">
                                Kami tidak mengizinkan manipulasi sudut pandang kamera maupun kos fiktif. Setiap fasilitas, harga, dan lokasi dicek langsung oleh tim lapangan TEMPATIN agar Anda menyewa dengan tenang.
                            </p>
                        </div>
                        <div class="d-flex flex-wrap pt-3 mt-3" style="border-top: var(--border-hairline); gap: 10px;">
                            <span class="badge badge-light border text-dark"><i class="fa fa-check text-success mr-1"></i> Foto Realistis</span>
                            <span class="badge badge-light border text-dark"><i class="fa fa-check text-success mr-1"></i> Pemilik Resmi</span>
                            <span class="badge badge-light border text-dark"><i class="fa fa-check text-success mr-1"></i> Tagihan Transparan</span>
                        </div>
                    </div>
                </div>

                <!-- Card 1: Col Span 1 (Booking Instan 3 Menit) -->
                <div class="ts-bento-card ts-bento-card-1" data-bento="card">
                    <div class="ts-bento-spotlight"></div>
                    <div class="ts-bento-border-glow"></div>
                    <div class="ts-bento-content">
                        <div>
                            <div class="ts-bento-header">
                                <div class="ts-bento-icon-wrapper">
                                    <i class="fa fa-bolt"></i>
                                </div>
                                <span class="badge badge-light border text-muted">Paperless</span>
                            </div>
                            <span class="ts-bento-label">Efisiensi Waktu</span>
                            <h3 class="ts-bento-title">Booking Instan 3 Menit</h3>
                            <p class="ts-bento-desc">
                                Ajukan sewa langsung dari smartphone Anda tanpa perlu mondar-mandir survei manual di tengah terik matahari.
                            </p>
                        </div>
                        <div class="pt-2">
                            <span class="small font-weight-bold text-muted"><i class="fa fa-clock mr-1 text-primary"></i> Paperless &amp; Cepat</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Col Span 1, Row Span 2 (Tall Feature Card: Proteksi Escrow & Transparansi) -->
                <div class="ts-bento-card ts-bento-card-2" data-bento="card">
                    <div class="ts-bento-spotlight"></div>
                    <div class="ts-bento-border-glow"></div>
                    <div class="ts-bento-content">
                        <div>
                            <div class="ts-bento-header">
                                <div class="ts-bento-icon-wrapper">
                                    <i class="fa fa-lock"></i>
                                </div>
                                <span class="badge badge-light border text-primary font-weight-bold">Garansi 100%</span>
                            </div>
                            <span class="ts-bento-label">Keamanan Dana</span>
                            <h3 class="ts-bento-title">Proteksi Dana &amp; Garansi Uang Kembali</h3>
                            <p class="ts-bento-desc mb-3">
                                Pembayaran Anda diamankan dalam rekening escrow resmi TEMPATIN. Dana baru diteruskan ke pemilik setelah Anda memastikan kamar sesuai kesepakatan.
                            </p>
                            <div class="p-3 bg-white rounded border mb-3 small">
                                <div class="font-weight-bold mb-1 text-dark"><i class="fa fa-shield-alt text-primary mr-1"></i> Escrow Protection:</div>
                                <div class="text-muted">Jika kamar terbukti tidak sesuai dengan foto, dana sewa dijamin kembali 100%.</div>
                            </div>
                        </div>
                        <div class="pt-2">
                            <span class="badge badge-light border text-primary font-weight-bold px-3 py-1">
                                Jaminan Proteksi 100%
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Col Span 1 (Bebas Biaya Terselubung) -->
                <div class="ts-bento-card ts-bento-card-3" data-bento="card">
                    <div class="ts-bento-spotlight"></div>
                    <div class="ts-bento-border-glow"></div>
                    <div class="ts-bento-content">
                        <div>
                            <div class="ts-bento-header">
                                <div class="ts-bento-icon-wrapper">
                                    <i class="fa fa-file-invoice-dollar"></i>
                                </div>
                                <span class="badge badge-light border text-muted">Fixed Price</span>
                            </div>
                            <span class="ts-bento-label">Transparansi Harga</span>
                            <h3 class="ts-bento-title">Tanpa Biaya Siluman</h3>
                            <p class="ts-bento-desc">
                                Rincian sewa, deposit, fasilitas listrik, dan air tercantum jelas dalam invoice digital sebelum Anda bayar.
                            </p>
                        </div>
                        <div class="pt-2">
                            <span class="small font-weight-bold text-muted"><i class="fa fa-check-circle mr-1 text-success"></i> Fixed Price Garansi</span>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Col Span 2 (Dukungan Tim 24/7 & Konsultasi) -->
                <div class="ts-bento-card ts-bento-card-4" data-bento="card">
                    <div class="ts-bento-spotlight"></div>
                    <div class="ts-bento-border-glow"></div>
                    <div class="ts-bento-content">
                        <div>
                            <div class="ts-bento-header">
                                <div class="ts-bento-icon-wrapper">
                                    <i class="fa fa-headset"></i>
                                </div>
                                <span class="badge badge-light border text-muted">Respon &lt; 5 Menit</span>
                            </div>
                            <span class="ts-bento-label">Customer Support</span>
                            <h3 class="ts-bento-title">Dukungan Pendampingan &amp; Bantuan 24/7</h3>
                            <p class="ts-bento-desc">
                                Punya pertanyaan seputar lingkungan sekitar kampus, ingin izin survei langsung, atau butuh bantuan pelunasan invoice? Tim konsultan TEMPATIN siap mendampingi setiap langkah Anda.
                            </p>
                        </div>
                        <div class="d-flex align-items-center justify-content-between pt-3 mt-3" style="border-top: var(--border-hairline);">
                            <span class="small text-muted"><i class="fa fa-comments mr-1 text-primary"></i> Chat Langsung via WhatsApp &amp; Ticket</span>
                            <a href="{{ route('contact') }}" class="btn btn-outline-dark btn-sm">Buka Pusat Bantuan &rarr;</a>
                        </div>
                    </div>
                </div>

                <!-- Card 5: Col Span 1 (Ulasan Objektif Komunitas) -->
                <div class="ts-bento-card ts-bento-card-5" data-bento="card">
                    <div class="ts-bento-spotlight"></div>
                    <div class="ts-bento-border-glow"></div>
                    <div class="ts-bento-content">
                        <div>
                            <div class="ts-bento-header">
                                <div class="ts-bento-icon-wrapper">
                                    <i class="fa fa-star"></i>
                                </div>
                                <span class="badge badge-light border text-muted">38.000+ Ulasan</span>
                            </div>
                            <span class="ts-bento-label">Ulasan Jujur</span>
                            <h3 class="ts-bento-title">Komunitas Terpercaya</h3>
                            <p class="ts-bento-desc">
                                Baca review otentik dari mahasiswa dan pekerja yang pernah menyewa kamar kos yang sama.
                            </p>
                        </div>
                        <div class="pt-2">
                            <span class="small font-weight-bold text-muted"><i class="fa fa-users mr-1 text-primary"></i> 38.000+ Penghuni</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- =========================================================================
         4. KOS POPULER MINGGU INI (GSAP-POWERED MASONRY GALLERY)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas); border-top: var(--border-hairline);">
        <div class="container py-4">

            <!-- Section Header -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 pb-2" style="border-bottom: var(--border-hairline);">
                <div>
                    <span class="badge badge-primary mb-2">Rekomendasi Teratas</span>
                    <h2 class="mb-1" style="letter-spacing: -0.03em;">Kos Populer Minggu Ini</h2>
                    <p class="font-editorial mb-0" style="font-size: 1.1rem; color: var(--color-graphite);">
                        Kamar terverifikasi dengan ulasan penghuni terbaik yang siap dihuni.
                    </p>
                </div>
                <div class="mt-3 mt-md-0 d-flex align-items-center" style="gap: 10px;">
                    <button type="button" class="btn btn-outline-dark btn-sm" id="btnRefreshMasonry" title="Animasi Ulang Galeri">
                        <i class="fa fa-sync-alt mr-1"></i>
                        <span>Segarkan</span>
                    </button>
                    <a href="{{ route('search.kos') }}" class="btn btn-primary btn-sm">
                        <span>Lihat Semua Kos</span>
                        <i class="fa fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <!-- Masonry Gallery Container (GSAP Positioned) -->
            <div class="ts-masonry-container" id="tsMasonryGallery">
                @php
                    // Variasi rasio tinggi untuk tampilan visual masonry dinamis
                    $heightVariants = [240, 310, 260, 300, 250, 320];
                @endphp

                @forelse($featuredKos as $index => $kos)
                    @php
                        $imgHeight = $heightVariants[$index % count($heightVariants)];
                        $typeLower = strtolower($kos['type'] ?? 'campur');
                        $typeClass = match($typeLower) {
                            'putra' => 'badge-type-putra',
                            'putri' => 'badge-type-putri',
                            'eksklusif' => 'badge-type-eksklusif',
                            default => 'badge-type-campur',
                        };
                    @endphp
                    <div class="ts-masonry-item" data-index="{{ $index }}" data-key="{{ $kos['id'] ?? $index }}">
                        <!-- Color overlay on hover -->
                        <div class="ts-masonry-color-overlay"></div>

                        <!-- Thumbnail Image -->
                        <a href="{{ route('kos.show', $kos['slug']) }}" class="ts-masonry-img-box" style="height: {{ $imgHeight }}px;">
                            <img src="{{ asset($kos['thumbnail']) }}" alt="{{ $kos['title'] }}" loading="eager">
                            
                            <!-- Status Type Pill -->
                            <span class="position-absolute" style="top: 12px; left: 12px; z-index: 4;">
                                <span class="badge {{ $typeClass }} shadow-none">
                                    Kos {{ ucfirst($kos['type'] ?? 'Campur') }}
                                </span>
                            </span>

                            <!-- Price Badge -->
                            <div class="ts-item__info-badge" style="z-index: 4;">
                                Rp {{ number_format($kos['price'], 0, ',', '.') }} <span style="font-size: 11px; opacity: 0.85;">/bln</span>
                            </div>
                        </a>

                        <!-- Card Body -->
                        <div class="p-3">
                            <!-- Location and Rating -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small d-inline-flex align-items-center">
                                    <i class="fa fa-map-marker-alt text-primary mr-1"></i>
                                    {{ $kos['city'] }}
                                </span>
                                <span class="ts-card__rating">
                                    <i class="fa fa-star"></i>
                                    <span>{{ number_format($kos['rating'] ?? 4.8, 1) }}</span>
                                </span>
                            </div>

                            <!-- Title -->
                            <h4 class="mb-2" style="font-size: 1.05rem; line-height: 1.35; font-weight: 700;">
                                <a href="{{ route('kos.show', $kos['slug']) }}" class="text-dark text-decoration-none">
                                    {{ $kos['title'] }}
                                </a>
                            </h4>

                            <!-- Address Snippet -->
                            <p class="text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.45;">
                                {{ $kos['address'] ?? 'Lokasi strategis dekat fasilitas umum dan transportasi.' }}
                            </p>

                            <!-- Facilities snippet -->
                            <div class="d-flex align-items-center justify-content-between pt-2 small text-muted" style="border-top: var(--border-hairline);">
                                <span><i class="fa fa-bed mr-1 text-primary"></i> {{ $kos['bedrooms'] ?? '1' }} Kamar</span>
                                <span><i class="fa fa-bath mr-1 text-primary"></i> {{ $kos['bathrooms'] ?? 'Dalam' }}</span>
                                <span class="text-success font-weight-bold"><i class="fa fa-shield-alt mr-1"></i> Verified</span>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-3 pb-3 pt-0">
                            <a href="{{ route('kos.show', $kos['slug']) }}" class="btn btn-outline-dark btn-sm w-100 font-weight-bold">
                                <span>Detail Kamar</span>
                                <i class="fa fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card p-5 text-center">
                            <p class="text-muted mb-0">Belum ada daftar kos yang aktif saat ini.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Floating Refresh Action (Prompt App.tsx Demo Button) -->
            <button type="button" class="ts-masonry-refresh-floating" id="btnRefreshMasonryFloating" title="Animasi Ulang Masonry Gallery">
                <i class="fa fa-sync-alt"></i>
            </button>

            <!-- Bottom Explore Action -->
            <div class="text-center mt-4">
                <a href="{{ route('search.kos') }}" class="btn btn-ghost px-4 py-2 font-weight-bold">
                    <span>Eksplorasi Ratusan Pilihan Kos Lainnya</span>
                    <i class="fa fa-arrow-right ml-2"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         5. ANIMATED STEPPER (ALUR CARA BOOKING KOS)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas); border-top: var(--border-hairline);" id="alur-booking">
        <div class="container py-4">

            <!-- Section Header -->
            <div class="text-center mx-auto mb-4" style="max-width: 680px;">
                <span class="badge badge-primary mb-2">Alur Interaktif</span>
                <h2 style="letter-spacing: -0.03em;">Cara Booking Kos di TEMPATIN</h2>
                <p class="font-editorial" style="font-size: 1.15rem; color: var(--color-graphite);">
                    4 langkah praktis dengan panduan interaktif hingga kunci kamar siap di tangan Anda.
                </p>
            </div>

            <!-- Animated Stepper Card Container -->
            <div class="ts-stepper-container" id="tsBookingStepper">

                <!-- Stepper Progress Header -->
                <div class="ts-stepper-header">
                    <!-- Step 1 -->
                    <div class="ts-stepper-indicator is-active" data-step="1">
                        <div class="ts-stepper-circle">
                            <span class="ts-step-num">1</span>
                        </div>
                        <span class="ts-stepper-label d-none d-sm-block">Cari &amp; Filter</span>
                    </div>

                    <div class="ts-stepper-connector">
                        <div class="ts-stepper-connector-fill" id="connector-1"></div>
                    </div>

                    <!-- Step 2 -->
                    <div class="ts-stepper-indicator" data-step="2">
                        <div class="ts-stepper-circle">
                            <span class="ts-step-num">2</span>
                        </div>
                        <span class="ts-stepper-label d-none d-sm-block">Pilih Kamar</span>
                    </div>

                    <div class="ts-stepper-connector">
                        <div class="ts-stepper-connector-fill" id="connector-2"></div>
                    </div>

                    <!-- Step 3 -->
                    <div class="ts-stepper-indicator" data-step="3">
                        <div class="ts-stepper-circle">
                            <span class="ts-step-num">3</span>
                        </div>
                        <span class="ts-stepper-label d-none d-sm-block">Ajukan Sewa</span>
                    </div>

                    <div class="ts-stepper-connector">
                        <div class="ts-stepper-connector-fill" id="connector-3"></div>
                    </div>

                    <!-- Step 4 -->
                    <div class="ts-stepper-indicator" data-step="4">
                        <div class="ts-stepper-circle">
                            <span class="ts-step-num">4</span>
                        </div>
                        <span class="ts-stepper-label d-none d-sm-block">Siap Huni</span>
                    </div>
                </div>

                <!-- Step Content Container with Dynamic Height & Fluid Slide -->
                <div class="ts-stepper-content-wrapper" id="tsStepperContentWrapper">

                    <!-- Step Pane 1 -->
                    <div class="ts-step-pane is-active" id="step-pane-1" data-step="1">
                        <div class="py-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-light border text-primary font-weight-bold mr-2">Langkah 1</span>
                                <span class="text-muted small">Eksplorasi Cerdas</span>
                            </div>
                            <h3 class="mb-3 font-weight-bold" style="letter-spacing: -0.02em;">1. Cari &amp; Filter Sesuai Preferensi</h3>
                            <p class="text-muted leading-relaxed mb-4" style="line-height: 1.6;">
                                Tentukan kota tujuan, radius dekat kampus atau kantor, rentang anggaran bulanan, serta tipe kos (putra, putri, campur, atau eksklusif).
                            </p>

                            <div class="ts-step-card-box">
                                <div class="row align-items-center">
                                    <div class="col-md-7 mb-3 mb-md-0">
                                        <div class="font-weight-bold text-dark mb-2"><i class="fa fa-sliders-h text-primary mr-2"></i> Filter yang Tersedia:</div>
                                        <div class="d-flex flex-wrap" style="gap: 8px;">
                                            <span class="badge badge-light border"><i class="fa fa-wifi text-muted mr-1"></i> WiFi Cepat</span>
                                            <span class="badge badge-light border"><i class="fa fa-snowflake text-muted mr-1"></i> AC Dingin</span>
                                            <span class="badge badge-light border"><i class="fa fa-bath text-muted mr-1"></i> K. Mandi Dalam</span>
                                            <span class="badge badge-light border"><i class="fa fa-motorcycle text-muted mr-1"></i> Parkir Motor</span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-md-right">
                                        <a href="#cari-kos-mockup" class="btn btn-outline-dark btn-sm font-weight-bold">
                                            <i class="fa fa-search mr-1"></i> Buka Pencarian
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step Pane 2 -->
                    <div class="ts-step-pane" id="step-pane-2" data-step="2">
                        <div class="py-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-light border text-primary font-weight-bold mr-2">Langkah 2</span>
                                <span class="text-muted small">Kurasi Detail</span>
                            </div>
                            <h3 class="mb-3 font-weight-bold" style="letter-spacing: -0.02em;">2. Cek Detail Kamar &amp; Ulasan Riil</h3>
                            <p class="text-muted leading-relaxed mb-4" style="line-height: 1.6;">
                                Periksa galeri foto 100% asli tanpa editan manipulatif, ukuran kamar, ketersediaan kasur dan lemari, aturan jam malam, serta rating jujur dari penghuni sebelumnya.
                            </p>

                            <div class="ts-step-card-box">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="font-weight-bold text-dark"><i class="fa fa-check-circle text-success mr-2"></i> Jaminan Verifikasi Lapangan:</span>
                                    <span class="badge badge-success">Terverifikasi</span>
                                </div>
                                <p class="small text-muted mb-0">
                                    Setiap kos berlabel terverifikasi telah melewati inspeksi standar kebersihan, ventilasi udara, dan keamanan lingkungan oleh tim surveyor TEMPATIN.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Step Pane 3 -->
                    <div class="ts-step-pane" id="step-pane-3" data-step="3">
                        <div class="py-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-light border text-primary font-weight-bold mr-2">Langkah 3</span>
                                <span class="text-muted small">Transaksi Aman</span>
                            </div>
                            <h3 class="mb-3 font-weight-bold" style="letter-spacing: -0.02em;">3. Ajukan Sewa &amp; Pembayaran Transparan</h3>
                            <p class="text-muted leading-relaxed mb-4" style="line-height: 1.6;">
                                Pilih tanggal mulai sewa dan durasi sewa bulanan atau tahunan. Terbitkan invoice resmi secara otomatis, dan selesaikan pembayaran aman via Virtual Account atau transfer bank.
                            </p>

                            <div class="ts-step-card-box">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="font-weight-bold text-dark"><i class="fa fa-shield-alt text-primary mr-2"></i> Proteksi Pembayaran Escrow:</span>
                                    <span class="text-primary font-weight-bold small">0% Biaya Tersembunyi</span>
                                </div>
                                <p class="small text-muted mb-0">
                                    Uang sewa Anda aman di penampungan resmi TEMPATIN dan hanya diteruskan ke pemilik setelah serah terima kunci kamar sukses di hari kedatangan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Step Pane 4 -->
                    <div class="ts-step-pane" id="step-pane-4" data-step="4">
                        <div class="py-3">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-light border text-success font-weight-bold mr-2">Selesai</span>
                                <span class="text-muted small">Serah Terima Kamar</span>
                            </div>
                            <h3 class="mb-3 font-weight-bold" style="letter-spacing: -0.02em;">4. Konfirmasi Digital &amp; Siap Ditempati</h3>
                            <p class="text-muted leading-relaxed mb-4" style="line-height: 1.6;">
                                Dapatkan bukti booking resmi digital lengkap dengan nomor kontak langsung pemilik kos. Anda cukup datang sesuai jadwal dan siap menempati kamar idaman Anda!
                            </p>

                            <div class="ts-step-card-box text-center py-3">
                                <div class="mb-2">
                                    <span class="badge badge-success px-3 py-2 font-weight-bold" style="font-size: 13px;">
                                        <i class="fa fa-key mr-1"></i> Siap Masuk Kos &amp; Mulai Aktivitas
                                    </span>
                                </div>
                                <p class="small text-muted mb-0">
                                    Selamat! Anda telah siap menikmati hunian nyaman, tenang, dan strategis bersama TEMPATIN.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Stepper Footer Actions -->
                <div class="ts-stepper-footer">
                    <button type="button" class="btn btn-outline-secondary btn-sm px-4" id="btnStepperBack" style="visibility: hidden;">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali
                    </button>
                    <button type="button" class="btn btn-primary btn-sm px-4 font-weight-bold" id="btnStepperNext">
                        <span>Lanjut</span>
                        <i class="fa fa-arrow-right ml-1"></i>
                    </button>
                </div>

            </div>

        </div>
    </section>

    <!-- =========================================================================
         6. DAMPAK NYATA (NOTION TACTILE STAT CARDS)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas); border-top: var(--border-hairline);">
        <div class="container py-4">

            <div class="text-center mx-auto mb-5" style="max-width: 680px;">
                <span class="badge badge-primary mb-2">Dampak Nyata</span>
                <h2 class="mb-2" style="font-size: 2.25rem; font-weight: 700; letter-spacing: -0.03em;">
                    Dipercaya di Seluruh Penjuru Nusantara
                </h2>
                <p class="font-editorial mb-0 mx-auto" style="font-size: 1.15rem; color: var(--color-graphite); line-height: 1.6;">
                    Menghubungkan puluhan ribu pencari kos dengan mitra pemilik properti terpercaya setiap harinya secara transparan.
                </p>
            </div>

            <div class="row">
                <!-- Stat 1 -->
                <div class="col-6 col-lg-3 mb-4 mb-lg-0">
                    <div class="p-4 h-100 text-left d-flex flex-column justify-content-between" style="background-color: #ffffff; border: 1px solid rgba(0, 0, 0, 0.08); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: transform 0.2s ease, border-color 0.2s ease;">
                        <div>
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 42px; height: 42px; border-radius: 10px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 16px;">
                                <i class="fa fa-home"></i>
                            </div>
                            <div style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.04em; color: var(--color-ink-black); line-height: 1.1; margin-bottom: 6px;">
                                5.200+
                            </div>
                            <div class="font-weight-bold text-dark mb-1" style="font-size: 15px;">
                                Kos Terverifikasi
                            </div>
                            <div class="text-muted small" style="line-height: 1.5;">
                                Diinspeksi langsung dari kelayakan fasilitas hingga legalitas.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="col-6 col-lg-3 mb-4 mb-lg-0">
                    <div class="p-4 h-100 text-left d-flex flex-column justify-content-between" style="background-color: #ffffff; border: 1px solid rgba(0, 0, 0, 0.08); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: transform 0.2s ease, border-color 0.2s ease;">
                        <div>
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 42px; height: 42px; border-radius: 10px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 16px;">
                                <i class="fa fa-map-marked-alt"></i>
                            </div>
                            <div style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.04em; color: var(--color-ink-black); line-height: 1.1; margin-bottom: 6px;">
                                120+
                            </div>
                            <div class="font-weight-bold text-dark mb-1" style="font-size: 15px;">
                                Kota &amp; Kabupaten
                            </div>
                            <div class="text-muted small" style="line-height: 1.5;">
                                Menjangkau kawasan strategis dekat kampus dan perkantoran.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="col-6 col-lg-3 mb-4 mb-lg-0">
                    <div class="p-4 h-100 text-left d-flex flex-column justify-content-between" style="background-color: #ffffff; border: 1px solid rgba(0, 0, 0, 0.08); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: transform 0.2s ease, border-color 0.2s ease;">
                        <div>
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 42px; height: 42px; border-radius: 10px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 16px;">
                                <i class="fa fa-users"></i>
                            </div>
                            <div style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.04em; color: var(--color-ink-black); line-height: 1.1; margin-bottom: 6px;">
                                38.000+
                            </div>
                            <div class="font-weight-bold text-dark mb-1" style="font-size: 15px;">
                                Penghuni Puas
                            </div>
                            <div class="text-muted small" style="line-height: 1.5;">
                                Mahasiswa &amp; pekerja yang telah menemukan kamar idaman.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="col-6 col-lg-3 mb-4 mb-lg-0">
                    <div class="p-4 h-100 text-left d-flex flex-column justify-content-between" style="background-color: #ffffff; border: 1px solid rgba(0, 0, 0, 0.08); border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: transform 0.2s ease, border-color 0.2s ease;">
                        <div>
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 42px; height: 42px; border-radius: 10px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 16px;">
                                <i class="fa fa-handshake"></i>
                            </div>
                            <div style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.04em; color: var(--color-ink-black); line-height: 1.1; margin-bottom: 6px;">
                                750+
                            </div>
                            <div class="font-weight-bold text-dark mb-1" style="font-size: 15px;">
                                Mitra Pemilik Kos
                            </div>
                            <div class="text-muted small" style="line-height: 1.5;">
                                Mengelola properti lebih praktis dengan pencatatan digital.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         7. TESTIMONIALS (INFINITE MARQUEE WITH ALPHA MASK & PAUSE ON HOVER)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas); border-top: var(--border-hairline); overflow: hidden;">
        <div class="container py-3">

            <div class="text-center mx-auto mb-4" style="max-width: 600px;">
                <span class="badge badge-primary mb-2">Kata Mereka</span>
                <h2 style="letter-spacing: -0.03em;">Cerita Dari Komunitas TEMPATIN</h2>
                <p class="font-editorial" style="font-size: 1.15rem; color: var(--color-graphite);">
                    Pengalaman nyata mahasiswa, pekerja, dan pemilik kos yang telah bergabung.
                </p>
            </div>

        </div>

        <!-- Marquee Scroller with Alpha Mask Gradient -->
        <div class="ts-marquee-container" aria-label="Ulasan Komunitas">
            <div class="ts-marquee-track">

                @php
                    $testimonials = [
                        [
                            'quote' => 'Cari kos dekat kampus UI Depok dulu makan waktu berhari-hari. Lewat TEMPATIN, saya booking kamar cuma dalam 15 menit dan kondisinya persis seperti di foto.',
                            'name' => 'Anisa Rahmawati',
                            'role' => 'Mahasiswi UI, Depok',
                            'icon' => 'fa-user-graduate',
                            'city' => 'Depok'
                        ],
                        [
                            'quote' => 'Sebagai pemilik kos di Yogyakarta, kamar saya terisi penuh dalam 2 minggu setelah terdaftar. Dashboard pemiliknya simpel dan transaksinya transparan.',
                            'name' => 'Bagus Prasetyo',
                            'role' => 'Pemilik Kos Anggrek, Sleman',
                            'icon' => 'fa-home',
                            'city' => 'Yogyakarta'
                        ],
                        [
                            'quote' => 'Pindah kerja ke Surabaya tanpa kenalan satupun, untung ada TEMPATIN. Filter lokasi dan simulasi invoice sangat membantu budgeting bulanan saya.',
                            'name' => 'Dewi Lestari',
                            'role' => 'Software Engineer, Surabaya',
                            'icon' => 'fa-briefcase',
                            'city' => 'Surabaya'
                        ],
                        [
                            'quote' => 'Fitur verified room dan pembayaran otomatis bikin kosan langsung aman tanpa was-was penipuan. Customer support juga sangat responsif saat saya ada kendala.',
                            'name' => 'Rian Hidayat',
                            'role' => 'Mahasiswa ITB, Bandung',
                            'icon' => 'fa-laptop-code',
                            'city' => 'Bandung'
                        ],
                        [
                            'quote' => 'Pengelolaan tagihan dan konfirmasi bukti transfer jadi otomatis lewat sistem. Sangat menghemat waktu saya setiap awal bulan tanpa perlu cek mutasi manual.',
                            'name' => 'Siti Nurhaliza',
                            'role' => 'Pemilik Paviliun Melati, Jaksel',
                            'icon' => 'fa-building',
                            'city' => 'Jakarta'
                        ]
                    ];
                @endphp

                {{-- Set 1 --}}
                @foreach($testimonials as $t)
                    <div class="ts-marquee-card">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="text-warning" style="font-size: 12px; letter-spacing: 2px;">
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                </div>
                                <span class="badge badge-secondary" style="font-size: 11px;">{{ $t['city'] }}</span>
                            </div>
                            <p class="font-editorial mb-4" style="font-size: 1.05rem; line-height: 1.6; color: var(--color-charcoal);">
                                &ldquo;{{ $t['quote'] }}&rdquo;
                            </p>
                        </div>
                        <div class="d-flex align-items-center pt-3" style="border-top: var(--border-hairline);">
                            <span class="notion-character-mark mr-3" style="width: 38px; height: 38px; font-size: 14px;">
                                <i class="fa {{ $t['icon'] }}"></i>
                            </span>
                            <div>
                                <h6 class="mb-0 font-weight-bold" style="font-size: 14px;">{{ $t['name'] }}</h6>
                                <small class="text-muted" style="font-size: 12px;">{{ $t['role'] }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Set 2 (Duplicate for Seamless Infinite Marquee Loop) --}}
                @foreach($testimonials as $t)
                    <div class="ts-marquee-card" aria-hidden="true">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="text-warning" style="font-size: 12px; letter-spacing: 2px;">
                                    <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                                </div>
                                <span class="badge badge-secondary" style="font-size: 11px;">{{ $t['city'] }}</span>
                            </div>
                            <p class="font-editorial mb-4" style="font-size: 1.05rem; line-height: 1.6; color: var(--color-charcoal);">
                                &ldquo;{{ $t['quote'] }}&rdquo;
                            </p>
                        </div>
                        <div class="d-flex align-items-center pt-3" style="border-top: var(--border-hairline);">
                            <span class="notion-character-mark mr-3" style="width: 38px; height: 38px; font-size: 14px;">
                                <i class="fa {{ $t['icon'] }}"></i>
                            </span>
                            <div>
                                <h6 class="mb-0 font-weight-bold" style="font-size: 14px;">{{ $t['name'] }}</h6>
                                <small class="text-muted" style="font-size: 12px;">{{ $t['role'] }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- =========================================================================
         8. ARTIKEL & TIPS SEPUTAR KOS (NOTION DOCUMENT CARDS)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas); border-top: var(--border-hairline);">
        <div class="container py-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 pb-2" style="border-bottom: var(--border-hairline);">
                <div>
                    <span class="badge badge-primary mb-2">Pusat Bacaan</span>
                    <h2 class="mb-1" style="letter-spacing: -0.03em;">Artikel &amp; Panduan Seputar Kos</h2>
                    <p class="font-editorial mb-0" style="font-size: 1.1rem; color: var(--color-graphite);">
                        Tips praktis dan panduan aman sebelum memutuskan menyewa kamar.
                    </p>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="{{ route('artikel') }}" class="btn btn-outline-dark btn-sm">
                        <span>Lihat Semua Artikel</span>
                        <i class="fa fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <div class="row">

                <!-- Doc 1 -->
                <div class="col-md-4 mb-4">
                    <a href="{{ route('artikel') }}" class="ts-notion-doc-card">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="ts-notion-doc-card__badge">
                                    <i class="fa fa-compass mr-1 text-primary"></i> Panduan Pemula
                                </span>
                                <span class="small text-muted"><i class="fa fa-clock mr-1"></i> 4 mnt baca</span>
                            </div>
                            <h4 class="ts-notion-doc-card__title">5 Tips Memilih Kos Dekat Kampus Tanpa Menyesal</h4>
                            <p class="ts-notion-doc-card__desc">
                                Panduan mendasar memeriksa ventilasi, akses internet, dan jarak tempuh sebelum tanda tangan sewa.
                            </p>
                        </div>
                        <div class="ts-notion-doc-card__meta">
                            <span><i class="fa fa-calendar-alt mr-1"></i> 5 Agustus 2026</span>
                            <span class="ts-notion-doc-card__arrow">
                                <span>Baca Panduan</span>
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Doc 2 -->
                <div class="col-md-4 mb-4">
                    <a href="{{ route('artikel') }}" class="ts-notion-doc-card">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="ts-notion-doc-card__badge">
                                    <i class="fa fa-shield-alt mr-1 text-primary"></i> Transaksi Aman
                                </span>
                                <span class="small text-muted"><i class="fa fa-clock mr-1"></i> 3 mnt baca</span>
                            </div>
                            <h4 class="ts-notion-doc-card__title">5 Hal Wajib Diperiksa Sebelum Bayar DP Booking Kos</h4>
                            <p class="ts-notion-doc-card__desc">
                                Rincian sewa, status deposit jaminan, dan proteksi escrow agar terhindar dari pengeluaran tak terduga.
                            </p>
                        </div>
                        <div class="ts-notion-doc-card__meta">
                            <span><i class="fa fa-calendar-alt mr-1"></i> 2 Agustus 2026</span>
                            <span class="ts-notion-doc-card__arrow">
                                <span>Baca Panduan</span>
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Doc 3 -->
                <div class="col-md-4 mb-4">
                    <a href="{{ route('artikel') }}" class="ts-notion-doc-card">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="ts-notion-doc-card__badge">
                                    <i class="fa fa-layer-group mr-1 text-primary"></i> Tipe Properti
                                </span>
                                <span class="small text-muted"><i class="fa fa-clock mr-1"></i> 5 mnt baca</span>
                            </div>
                            <h4 class="ts-notion-doc-card__title">Perbedaan Kos Putra, Putri, Campur &amp; Eksklusif</h4>
                            <p class="ts-notion-doc-card__desc">
                                Kenali aturan jam malam, fasilitas bersama, dan lingkungan hunian sesuai kenyamanan aktivitas harian.
                            </p>
                        </div>
                        <div class="ts-notion-doc-card__meta">
                            <span><i class="fa fa-calendar-alt mr-1"></i> 28 Juli 2026</span>
                            <span class="ts-notion-doc-card__arrow">
                                <span>Baca Panduan</span>
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </section>

    <!-- =========================================================================
         9. CALL TO ACTION (NOTION WARM FINALE)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas); border-top: var(--border-hairline);">
        <div class="container py-5 text-center">
            <div class="card p-5 mx-auto" style="max-width: 840px; background-color: #ffffff; border: var(--border-hairline); border-radius: 16px;">
                <h2 class="mb-3" style="font-size: 2.25rem; font-weight: 700; letter-spacing: -0.03em;">
                    Siap Menemukan Kos Impianmu Hari Ini?
                </h2>
                <p class="font-editorial mb-4 mx-auto" style="font-size: 1.15rem; color: var(--color-graphite); max-width: 580px;">
                    Jelajahi ribuan pilihan kos dengan harga transparan dan kepastian kamar terverifikasi di TEMPATIN.
                </p>
                <div class="d-flex flex-wrap justify-content-center align-items-center" style="gap: 12px;">
                    <a href="#cari-kos-mockup" class="btn btn-primary btn-lg">
                        <i class="fa fa-search mr-1"></i> Mulai Cari Kos Sekarang
                    </a>
                    <a href="{{ route('owner.kos.create') }}" class="btn btn-outline-dark btn-lg">
                        <i class="fa fa-home mr-1"></i> Daftarkan Properti Anda
                    </a>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slot = document.getElementById('tsRolodexSlot');
    if (!slot) return;

    const words = [
        'dengan Mudah',
        'Lebih Cepat',
        'Paling Aman',
        'Tanpa Ribet',
        'Harga Pas'
    ];
    let currentIndex = 0;
    let timer = null;
    let isAnimating = false;
    let wordWidths = {};

    // Pre-calculate exact natural text widths off-screen to prevent layout thrashing
    function measureAllWidths() {
        const measurer = document.createElement('span');
        measurer.style.cssText = 'position: fixed; left: -9999px; top: -9999px; visibility: hidden; pointer-events: none; white-space: nowrap; font-family: inherit; font-size: inherit; font-weight: 700; letter-spacing: -0.035em; display: inline; line-height: 1.25;';
        slot.parentNode.appendChild(measurer);
        words.forEach(w => {
            measurer.textContent = w;
            const measured = Math.ceil(measurer.getBoundingClientRect().width);
            wordWidths[w] = (measured > 40 && measured < 600) ? measured + 8 : 240;
        });
        measurer.remove();
    }

    measureAllWidths();
    if (wordWidths[words[currentIndex]]) {
        slot.style.width = wordWidths[words[currentIndex]] + 'px';
    }

    window.addEventListener('resize', function () {
        measureAllWidths();
        if (wordWidths[words[currentIndex]]) {
            slot.style.width = wordWidths[words[currentIndex]] + 'px';
        }
    });

    function stopRotation() {
        if (timer) {
            clearTimeout(timer);
            timer = null;
        }
    }

    function startRotation(delay) {
        if (document.hidden) return;
        if (timer) clearTimeout(timer);
        timer = setTimeout(rotateRolodex, typeof delay === 'number' ? delay : 3000);
    }

    // Buttery Smooth 2D Slide-and-Fade Vertical Transition
    function rotateRolodex() {
        if (document.hidden) {
            stopRotation();
            return;
        }
        if (typeof gsap === 'undefined') {
            startRotation(3000);
            return;
        }
        if (isAnimating) return;

        const currentWordEl = slot.querySelector('.ts-rolodex-word');
        if (!currentWordEl) {
            startRotation(3000);
            return;
        }

        isAnimating = true;
        currentIndex = (currentIndex + 1) % words.length;
        const nextWordText = words[currentIndex];
        const nextTargetWidth = wordWidths[nextWordText] || 150;

        // Create incoming word element positioned below
        const nextWordEl = document.createElement('span');
        nextWordEl.className = 'ts-rolodex-word';
        nextWordEl.textContent = nextWordText;
        gsap.set(nextWordEl, { y: '100%', opacity: 0 });
        slot.appendChild(nextWordEl);

        const animDuration = 0.52;
        const animEase = 'power2.inOut';

        const tl = gsap.timeline({
            onComplete: function () {
                if (currentWordEl && currentWordEl.parentNode) {
                    currentWordEl.remove();
                }
                nextWordEl.classList.add('is-active');
                // Clean any stray nodes if tab blurs mid-flight
                const strays = slot.querySelectorAll('.ts-rolodex-word');
                for (let i = 0; i < strays.length - 1; i++) {
                    strays[i].remove();
                }
                isAnimating = false;
                startRotation(3000);
            }
        });

        // 1. Container width expands/contracts in sync
        tl.to(slot, {
            width: nextTargetWidth,
            duration: animDuration,
            ease: animEase
        }, 0);

        // 2. Current word slides UP and fades out
        tl.to(currentWordEl, {
            y: '-100%',
            opacity: 0,
            duration: animDuration,
            ease: animEase
        }, 0);

        // 3. Next word slides UP into view and fades in synchronously
        tl.to(nextWordEl, {
            y: '0%',
            opacity: 1,
            duration: animDuration,
            ease: animEase
        }, 0);
    }

    // Tab Visibility Listeners
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            stopRotation();
        } else {
            stopRotation();
            startRotation(2000);
        }
    });

    window.addEventListener('blur', function () {
        stopRotation();
    });

    window.addEventListener('focus', function () {
        if (!document.hidden) {
            stopRotation();
            startRotation(2000);
        }
    });

    // Start initial rotation schedule
    startRotation(3000);

    /* =========================================================================
       1. ANIMATED STEPPER CONTROLLER (CARA BOOKING KOS)
       ========================================================================= */
    const stepperContainer = document.getElementById('tsBookingStepper');
    if (stepperContainer) {
        const indicators = stepperContainer.querySelectorAll('.ts-stepper-indicator');
        const panes = stepperContainer.querySelectorAll('.ts-step-pane');
        const wrapper = document.getElementById('tsStepperContentWrapper');
        const btnNext = document.getElementById('btnStepperNext');
        const btnBack = document.getElementById('btnStepperBack');
        const totalSteps = indicators.length;
        let currentStep = 1;
        let isTransitioning = false;

        function updateWrapperHeight(pane) {
            if (!wrapper || !pane) return;
            const h = pane.offsetHeight;
            if (typeof gsap !== 'undefined') {
                gsap.to(wrapper, { height: h, duration: 0.35, ease: 'power2.out' });
            } else {
                wrapper.style.height = h + 'px';
            }
        }

        function setStep(newStep) {
            if (newStep === currentStep || isTransitioning || newStep < 1 || newStep > totalSteps) return;
            isTransitioning = true;
            const direction = newStep > currentStep ? 1 : -1;
            const prevPane = stepperContainer.querySelector(`.ts-step-pane[data-step="${currentStep}"]`);
            const nextPane = stepperContainer.querySelector(`.ts-step-pane[data-step="${newStep}"]`);

            // Update indicators and connectors
            indicators.forEach(ind => {
                const s = parseInt(ind.getAttribute('data-step'));
                const circle = ind.querySelector('.ts-stepper-circle');
                if (s < newStep) {
                    ind.classList.remove('is-active');
                    ind.classList.add('is-complete');
                    circle.innerHTML = '<i class="fa fa-check"></i>';
                } else if (s === newStep) {
                    ind.classList.add('is-active');
                    ind.classList.remove('is-complete');
                    circle.innerHTML = `<span class="ts-step-num">${s}</span>`;
                } else {
                    ind.classList.remove('is-active', 'is-complete');
                    circle.innerHTML = `<span class="ts-step-num">${s}</span>`;
                }
            });

            // Update connector progress bars
            for (let i = 1; i < totalSteps; i++) {
                const conn = document.getElementById(`connector-${i}`);
                if (conn) {
                    conn.style.width = newStep > i ? '100%' : '0%';
                }
            }

            // Animate step panes
            if (typeof gsap !== 'undefined' && prevPane && nextPane) {
                gsap.to(prevPane, {
                    x: direction * -30,
                    opacity: 0,
                    duration: 0.22,
                    ease: 'power2.in',
                    onComplete: () => {
                        prevPane.classList.remove('is-active');
                        nextPane.classList.add('is-active');
                        updateWrapperHeight(nextPane);
                        gsap.fromTo(nextPane, 
                            { x: direction * 30, opacity: 0 },
                            {
                                x: 0,
                                opacity: 1,
                                duration: 0.35,
                                ease: 'power3.out',
                                onComplete: () => {
                                    isTransitioning = false;
                                }
                            }
                        );
                    }
                });
            } else if (prevPane && nextPane) {
                prevPane.classList.remove('is-active');
                nextPane.classList.add('is-active');
                updateWrapperHeight(nextPane);
                isTransitioning = false;
            }

            currentStep = newStep;

            // Update footer buttons
            if (btnBack) {
                btnBack.style.visibility = currentStep === 1 ? 'hidden' : 'visible';
            }
            if (btnNext) {
                if (currentStep === totalSteps) {
                    btnNext.innerHTML = '<span>Eksplorasi Kos Sekarang</span> <i class="fa fa-check ml-1"></i>';
                    btnNext.className = 'btn btn-success btn-sm px-4 font-weight-bold';
                } else {
                    btnNext.innerHTML = '<span>Lanjut</span> <i class="fa fa-arrow-right ml-1"></i>';
                    btnNext.className = 'btn btn-primary btn-sm px-4 font-weight-bold';
                }
            }
        }

        // Indicator click
        indicators.forEach(ind => {
            ind.addEventListener('click', function () {
                const target = parseInt(this.getAttribute('data-step'));
                setStep(target);
            });
        });

        // Next button click
        if (btnNext) {
            btnNext.addEventListener('click', function () {
                if (currentStep === totalSteps) {
                    const targetEl = document.getElementById('cari-kos-mockup');
                    if (targetEl) {
                        targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    setStep(currentStep + 1);
                }
            });
        }

        // Back button click
        if (btnBack) {
            btnBack.addEventListener('click', function () {
                setStep(currentStep - 1);
            });
        }

        // Set initial pane height
        setTimeout(() => {
            const activePane = stepperContainer.querySelector('.ts-step-pane.is-active');
            if (activePane) updateWrapperHeight(activePane);
        }, 150);
    }

    /* =========================================================================
       2. MAGIC BENTO CONTROLLER (SPOTLIGHT, BORDER GLOW, STARS & 3D TILT)
       ========================================================================= */
    const bentoCards = document.querySelectorAll('.ts-bento-card[data-bento="card"]');
    if (bentoCards.length > 0) {
        bentoCards.forEach(card => {
            let activeParticles = [];

            // Mouse Move: Spotlight, Border Glow, 3D Tilt & Magnetism
            card.addEventListener('mousemove', function (e) {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                card.style.setProperty('--mouse-x', x + 'px');
                card.style.setProperty('--mouse-y', y + 'px');

                if (window.innerWidth >= 768 && typeof gsap !== 'undefined') {
                    const centerX = rect.width / 2;
                    const centerY = rect.height / 2;
                    const rotateX = ((y - centerY) / centerY) * -6;
                    const rotateY = ((x - centerX) / centerX) * 6;
                    const magnetX = (x - centerX) * 0.035;
                    const magnetY = (y - centerY) * 0.035;

                    gsap.to(card, {
                        rotateX: rotateX,
                        rotateY: rotateY,
                        x: magnetX,
                        y: magnetY,
                        duration: 0.15,
                        ease: 'power2.out',
                        transformPerspective: 1000
                    });
                }
            });

            // Mouse Enter: Star particles shimmer
            card.addEventListener('mouseenter', function () {
                if (typeof gsap === 'undefined' || window.innerWidth < 768) return;
                const rect = card.getBoundingClientRect();
                const particleCount = 8;
                const isMarigold = card.classList.contains('is-accent-marigold');
                const particleColor = isMarigold ? 'rgba(245, 158, 11, 0.7)' : 'rgba(0, 117, 222, 0.7)';

                for (let i = 0; i < particleCount; i++) {
                    const p = document.createElement('div');
                    p.className = 'ts-bento-particle';
                    p.style.backgroundColor = particleColor;
                    p.style.boxShadow = `0 0 6px ${particleColor}`;
                    p.style.left = Math.random() * (rect.width - 20) + 10 + 'px';
                    p.style.top = Math.random() * (rect.height - 20) + 10 + 'px';
                    card.appendChild(p);
                    activeParticles.push(p);

                    gsap.fromTo(p, 
                        { scale: 0, opacity: 0 },
                        { scale: 1, opacity: 1, duration: 0.3, ease: 'back.out(1.7)' }
                    );

                    gsap.to(p, {
                        x: (Math.random() - 0.5) * 40,
                        y: (Math.random() - 0.5) * 40,
                        duration: 1.8 + Math.random(),
                        ease: 'sine.inOut',
                        repeat: -1,
                        yoyo: true
                    });
                }
            });

            // Mouse Leave: Clean up particles & reset tilt
            card.addEventListener('mouseleave', function () {
                if (typeof gsap !== 'undefined') {
                    gsap.to(card, {
                        rotateX: 0,
                        rotateY: 0,
                        x: 0,
                        y: 0,
                        duration: 0.35,
                        ease: 'power2.out'
                    });

                    activeParticles.forEach(p => {
                        gsap.to(p, {
                            scale: 0,
                            opacity: 0,
                            duration: 0.25,
                            onComplete: () => p.remove()
                        });
                    });
                    activeParticles = [];
                }
            });

            // Click Ripple Effect
            card.addEventListener('click', function (e) {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const ripple = document.createElement('div');
                ripple.className = 'ts-bento-ripple';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.style.backgroundColor = card.classList.contains('is-accent-marigold') 
                    ? 'rgba(245, 158, 11, 0.35)' 
                    : 'rgba(0, 117, 222, 0.3)';
                card.appendChild(ripple);

                if (typeof gsap !== 'undefined') {
                    gsap.fromTo(ripple, 
                        { scale: 0, opacity: 0.9 },
                        { scale: 50, opacity: 0, duration: 0.7, ease: 'power2.out', onComplete: () => ripple.remove() }
                    );
                } else {
                    setTimeout(() => ripple.remove(), 600);
                }
            });
        });
    }

    /* =========================================================================
       3. MASONRY GALLERY CONTROLLER (KOS POPULER MINGGU INI - PROMPT ADAPTATION)
       ========================================================================= */
    const galleryContainer = document.getElementById('tsMasonryGallery');
    const masonryItems = galleryContainer ? galleryContainer.querySelectorAll('.ts-masonry-item') : [];
    
    if (galleryContainer && masonryItems.length > 0 && typeof gsap !== 'undefined') {
        let isAnimated = false;

        function getColumns() {
            const w = galleryContainer.offsetWidth;
            if (w >= 992) return 3;
            if (w >= 640) return 2;
            return 1;
        }

        function calculateLayout() {
            const containerWidth = galleryContainer.offsetWidth;
            const columns = getColumns();
            const gap = 24;
            const totalGaps = (columns - 1) * gap;
            const columnWidth = Math.floor((containerWidth - totalGaps) / columns);
            const colHeights = new Array(columns).fill(0);
            const layoutData = [];

            masonryItems.forEach((item, index) => {
                item.style.width = columnWidth + 'px';
                const itemHeight = item.offsetHeight || 390;
                const col = colHeights.indexOf(Math.min(...colHeights));
                const x = col * (columnWidth + gap);
                const y = colHeights[col];
                colHeights[col] += itemHeight + gap;

                layoutData.push({ item, x, y, width: columnWidth, height: itemHeight });
            });

            const maxH = Math.max(...colHeights);
            galleryContainer.style.height = (maxH + 10) + 'px';
            return layoutData;
        }

        function applyLayout(layoutData, animate = true) {
            layoutData.forEach((data, index) => {
                if (animate) {
                    // Cinematic entrance animation from bottom with blur-to-focus & power3.out easing
                    gsap.fromTo(data.item, 
                        {
                            opacity: 0,
                            x: data.x,
                            y: data.y + 180,
                            filter: 'blur(20px)',
                            scale: 0.94
                        },
                        {
                            opacity: 1,
                            x: data.x,
                            y: data.y,
                            filter: 'blur(0px)',
                            scale: 1,
                            duration: 1.15,
                            ease: 'power3.out',
                            delay: index * 0.08
                        }
                    );
                } else {
                    gsap.to(data.item, {
                        x: data.x,
                        y: data.y,
                        duration: 0.45,
                        ease: 'power3.out'
                    });
                }
            });
        }

        function runEntranceAnimation() {
            const layoutData = calculateLayout();
            applyLayout(layoutData, true);
            isAnimated = true;
        }

        // Trigger entrance when the user scrolls to the section!
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !isAnimated) {
                        runEntranceAnimation();
                        observer.disconnect();
                    }
                });
            }, { threshold: 0.12 });
            observer.observe(galleryContainer);
        } else {
            runEntranceAnimation();
        }

        // Handle image loading to recalibrate heights
        const imgs = galleryContainer.querySelectorAll('img');
        let loaded = 0;
        if (imgs.length > 0) {
            imgs.forEach(img => {
                if (img.complete) {
                    loaded++;
                    if (loaded === imgs.length && isAnimated) calculateLayout();
                } else {
                    img.addEventListener('load', () => {
                        loaded++;
                        if (loaded === imgs.length && isAnimated) {
                            const layout = calculateLayout();
                            applyLayout(layout, false);
                        }
                    });
                }
            });
        }

        // Responsive window resize listener
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                const layout = calculateLayout();
                applyLayout(layout, false);
            }, 100);
        });

        // Hover scale & color overlay shift (scaleOnHover: true, hoverScale: 0.95, colorShiftOnHover: true)
        masonryItems.forEach(item => {
            const overlay = item.querySelector('.ts-masonry-color-overlay');
            item.addEventListener('mouseenter', () => {
                gsap.to(item, { scale: 0.95, duration: 0.4, ease: 'power2.out' });
                if (overlay) gsap.to(overlay, { opacity: 0.35, duration: 0.4 });
            });
            item.addEventListener('mouseleave', () => {
                gsap.to(item, { scale: 1, duration: 0.4, ease: 'power2.out' });
                if (overlay) gsap.to(overlay, { opacity: 0, duration: 0.4 });
            });
        });

        // Refresh / Re-animate triggers
        function handleRefresh() {
            const icons = document.querySelectorAll('#btnRefreshMasonry i, #btnRefreshMasonryFloating i');
            icons.forEach(ic => gsap.to(ic, { rotation: '+=360', duration: 0.6, ease: 'power2.inOut' }));
            runEntranceAnimation();
        }

        const btnRefresh = document.getElementById('btnRefreshMasonry');
        if (btnRefresh) btnRefresh.addEventListener('click', handleRefresh);
        const btnFloating = document.getElementById('btnRefreshMasonryFloating');
        if (btnFloating) btnFloating.addEventListener('click', handleRefresh);
    }
});
</script>
@endpush
