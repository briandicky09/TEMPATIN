@extends('layouts.app')

@section('title', 'TEMPATIN - Ruang Pencarian Kos Modern & Terpercaya')

@section('content')
<div class="ts-page-wrapper" id="page-top">

    @include('partials.navbar')
    @include('partials.alert')

    <!-- =========================================================================
         1. NOTION HERO (CENTERED STACK LAYOUT)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas); border-bottom: var(--border-hairline);">
        <div class="container py-4 text-center">

            <!-- Avatar Character Marks Row -->
            <div class="notion-character-row">
                <span class="notion-character-mark notion-character-mark--blue" title="Pencari Kos">👨‍🎓</span>
                <span class="notion-character-mark notion-character-mark--coral" title="Mahasiswi">👩‍💻</span>
                <span class="notion-character-mark notion-character-mark--yellow" title="Pemilik Kos">🏠</span>
                <span class="notion-character-mark notion-character-mark--sky" title="Pekerja Mandiri">💼</span>
                <span class="notion-character-mark notion-character-mark--mocha" title="Keluarga">👥</span>
            </div>

            <!-- Main Display Headline -->
            <div class="mb-3 mx-auto" style="max-width: 860px;">
                <h1 class="mb-3" style="font-size: clamp(2.2rem, 5vw, 3.75rem); letter-spacing: -0.04em; line-height: 1.12;">
                    Temukan Kos Impianmu <br class="d-none d-md-block">
                    <span class="notion-pill-highlight">dengan Mudah</span> &amp; Transparan.
                </h1>
                <p class="font-editorial mx-auto mb-4" style="font-size: 1.2rem; line-height: 1.6; max-width: 680px; color: var(--color-graphite);">
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
                    <div class="text-muted small">
                        <span class="badge badge-light border">v2.4 Live</span>
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
                                <a href="{{ route('search.kos', ['city' => 'yogyakarta']) }}" class="badge badge-light border text-dark text-decoration-none">📍 Yogyakarta</a>
                                <a href="{{ route('search.kos', ['city' => 'surabaya']) }}" class="badge badge-light border text-dark text-decoration-none">📍 Surabaya</a>
                                <a href="{{ route('search.kos', ['city' => 'bandung']) }}" class="badge badge-light border text-dark text-decoration-none">📍 Bandung</a>
                                <a href="{{ route('search.kos', ['type' => 'putri']) }}" class="badge badge-light border text-dark text-decoration-none">🌸 Kos Putri</a>
                                <a href="{{ route('search.kos', ['type' => 'putra']) }}" class="badge badge-light border text-dark text-decoration-none">⚡ Kos Putra</a>
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
         2. PARTNER & KAMPUS LOGO WALL
         ========================================================================= -->
    <section class="notion-partner-wall">
        <div class="container">
            <div class="notion-partner-wall__label">
                Pilihan Kos Terfavorit di Dekat Kampus &amp; Pusat Bisnis Terkemuka
            </div>
            <div class="notion-partner-wall__grid">
                <span class="notion-partner-wall__item"><i class="fa fa-graduation-cap"></i> Univ. Indonesia (UI)</span>
                <span class="notion-partner-wall__item"><i class="fa fa-graduation-cap"></i> ITB Bandung</span>
                <span class="notion-partner-wall__item"><i class="fa fa-graduation-cap"></i> Univ. Gadjah Mada (UGM)</span>
                <span class="notion-partner-wall__item"><i class="fa fa-graduation-cap"></i> Univ. Airlangga (UNAIR)</span>
                <span class="notion-partner-wall__item"><i class="fa fa-graduation-cap"></i> Univ. Brawijaya (UB)</span>
                <span class="notion-partner-wall__item"><i class="fa fa-graduation-cap"></i> ITS Surabaya</span>
                <span class="notion-partner-wall__item"><i class="fa fa-graduation-cap"></i> UNDIP Semarang</span>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         3. KOS POPULER (NOTION WHITE-CARD GRID)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas);">
        <div class="container py-4">

            <!-- Section Header -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 pb-2" style="border-bottom: var(--border-hairline);">
                <div>
                    <span class="badge badge-primary mb-2">⭐ Rekomendasi Teratas</span>
                    <h2 class="mb-1" style="letter-spacing: -0.03em;">Kos Populer Minggu Ini</h2>
                    <p class="font-editorial mb-0" style="font-size: 1.1rem; color: var(--color-graphite);">
                        Kamar terverifikasi dengan ulasan penghuni terbaik yang siap dihuni.
                    </p>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="{{ route('search.kos') }}" class="btn btn-outline-dark btn-sm">
                        <span>Lihat Semua Kos</span>
                        <i class="fa fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>

            <!-- Kos Grid Row -->
            <div class="row">
                @forelse($featuredKos as $kos)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card ts-item ts-card h-100">
                        <!-- Image Container with Pill Tag -->
                        <a href="{{ route('kos.show', $kos['slug']) }}" class="card-img ts-item__image" style="background-image: url('{{ asset($kos['thumbnail']) }}'); height: 210px; display: block; position: relative;">
                            
                            <!-- Status Type Pill -->
                            <span class="position-absolute" style="top: 12px; left: 12px; z-index: 2;">
                                @php
                                    $typeLower = strtolower($kos['type'] ?? 'campur');
                                    $typeClass = match($typeLower) {
                                        'putra' => 'badge-type-putra',
                                        'putri' => 'badge-type-putri',
                                        'eksklusif' => 'badge-type-eksklusif',
                                        default => 'badge-type-campur',
                                    };
                                @endphp
                                <span class="badge {{ $typeClass }} shadow-none">
                                    Kos {{ ucfirst($kos['type'] ?? 'Campur') }}
                                </span>
                            </span>

                            <!-- Price Badge -->
                            <div class="ts-item__info-badge">
                                Rp {{ number_format($kos['price'], 0, ',', '.') }} <span style="font-size: 11px; opacity: 0.8;">/bln</span>
                            </div>
                        </a>

                        <!-- Card Body -->
                        <div class="card-body">
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
                            <h4 class="mb-2" style="font-size: 1.1rem; line-height: 1.35;">
                                <a href="{{ route('kos.show', $kos['slug']) }}" class="text-dark text-decoration-none">
                                    {{ $kos['title'] }}
                                </a>
                            </h4>

                            <!-- Description Snippet -->
                            <p class="text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                {{ $kos['address'] ?? 'Lokasi strategis, dekat fasilitas umum dan transportasi.' }}
                            </p>

                            <!-- Facility Description Lists -->
                            <div class="ts-description-lists pt-2" style="border-top: var(--border-hairline);">
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

                        <!-- Card Footer -->
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <span class="small text-muted">
                                <i class="fa fa-shield-alt text-success mr-1"></i> Terverifikasi
                            </span>
                            <a href="{{ route('kos.show', $kos['slug']) }}" class="ts-btn-arrow text-decoration-none font-weight-bold">
                                Detail Kamar
                            </a>
                        </div>
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

            <!-- Bottom Explore Action -->
            <div class="text-center mt-3">
                <a href="{{ route('search.kos') }}" class="btn btn-ghost px-4 py-2 font-weight-bold">
                    <span>Eksplorasi Ratusan Pilihan Kos Lainnya</span>
                    <i class="fa fa-arrow-right ml-2"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         4. NOTION 2x2 FEATURE GRID (MENGAPA MEMILIH TEMPATIN)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas); border-top: var(--border-hairline);">
        <div class="container py-4">

            <!-- Section Header -->
            <div class="text-center mx-auto mb-4" style="max-width: 640px;">
                <span class="badge badge-primary mb-2">💡 Nilai Utama</span>
                <h2 style="letter-spacing: -0.03em;">Dibuat untuk Pengalaman Sewa Tanpa Cemas</h2>
                <p class="font-editorial" style="font-size: 1.15rem; color: var(--color-graphite);">
                    Standar baru menyewa kos: transparan, terjamin, dan didukung teknologi modern.
                </p>
            </div>

            <!-- 2x2 Feature Grid -->
            <div class="notion-feature-grid">

                <!-- Feature 1 (Full Width Accent Block in Marigold) -->
                <div class="notion-feature-box notion-feature-box--marigold notion-feature-grid__full">
                    <div class="row align-items-center">
                        <div class="col-lg-7 mb-4 mb-lg-0">
                            <span class="badge badge-light text-dark font-weight-bold mb-3 px-3 py-1" style="border-radius: 9999px;">
                                🛡️ Jaminan Keamanan 100%
                            </span>
                            <h3 style="font-size: 2rem; font-weight: 700; letter-spacing: -0.03em; line-height: 1.25; margin-bottom: 14px;">
                                Setiap Kamar Dicek Langsung &amp; Terverifikasi
                            </h3>
                            <p style="font-size: 1.05rem; line-height: 1.6; margin-bottom: 20px;">
                                Kami tidak mengizinkan kos fiktif. Setiap foto, fasilitas, harga, dan lokasi diperiksa secara ketat oleh tim lapangan TEMPATIN sehingga apa yang Anda lihat adalah apa yang Anda dapatkan.
                            </p>
                            <div class="d-flex flex-wrap" style="gap: 16px;">
                                <div class="d-flex align-items-center font-weight-bold small">
                                    <i class="fa fa-check-circle mr-2"></i> Foto Realistis Tanpa Manipulasi
                                </div>
                                <div class="d-flex align-items-center font-weight-bold small">
                                    <i class="fa fa-check-circle mr-2"></i> Pemilik Teridentifikasi Resmi
                                </div>
                                <div class="d-flex align-items-center font-weight-bold small">
                                    <i class="fa fa-check-circle mr-2"></i> Bebas Biaya Terselubung
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 text-center">
                            <!-- Simulated Verification Card inside feature -->
                            <div class="card p-3 shadow-sm border-0 text-left mx-auto" style="border-radius: 12px; background: #ffffff; max-width: 320px;">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px;">
                                        <i class="fa fa-check fa-lg"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-weight-bold">Status: Terverifikasi</h6>
                                        <small class="text-muted">Inspeksi Lapangan Selesai</small>
                                    </div>
                                </div>
                                <div class="small p-2 bg-light rounded mb-2">
                                    <span>🔑 Akses Kamar: Kunci Elektronik</span>
                                </div>
                                <div class="small p-2 bg-light rounded">
                                    <span>💧 Tagihan Listrik &amp; Air: Transparan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 (Left Bottom) -->
                <div class="notion-feature-box notion-feature-box--sky">
                    <div>
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-white text-primary mb-3" style="width: 48px; height: 48px; border: 1px solid #cce5fd;">
                            <i class="fa fa-bolt fa-lg"></i>
                        </div>
                        <h4 class="font-weight-bold mb-2">Booking Instan &amp; Paperless</h4>
                        <p class="text-muted mb-4" style="line-height: 1.6;">
                            Tidak perlu lagi mondar-mandir survey berhari-hari. Pilih tanggal masuk, ajukan sewa, dan selesaikan invoice secara online langsung dari smartphone Anda.
                        </p>
                    </div>
                    <div>
                        <span class="badge badge-light border text-primary font-weight-bold">⚡ Rata-rata booking: 3 Menit</span>
                    </div>
                </div>

                <!-- Feature 3 (Right Bottom) -->
                <div class="notion-feature-box notion-feature-box--coral">
                    <div>
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center bg-white text-danger mb-3" style="width: 48px; height: 48px; border: 1px solid #ffd4ce;">
                            <i class="fa fa-headset fa-lg"></i>
                        </div>
                        <h4 class="font-weight-bold mb-2">Bantuan Support 24/7</h4>
                        <p class="text-muted mb-4" style="line-height: 1.6;">
                            Punya kendala dengan pembayaran, izin survey, atau ingin konsultasi rekomendasi kos terdekat kampus? Tim TEMPATIN siap membantu Anda kapan saja.
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('contact') }}" class="btn btn-outline-dark btn-sm">Buka Pusat Bantuan →</a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- =========================================================================
         5. NOTION KANBAN WORKFLOW (CARA BOOKING KOS)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas); border-top: var(--border-hairline);">
        <div class="container py-4">

            <div class="text-center mx-auto mb-4" style="max-width: 680px;">
                <span class="badge badge-primary mb-2">📋 Alur Mudah</span>
                <h2 style="letter-spacing: -0.03em;">Cara Booking Kos di TEMPATIN</h2>
                <p class="font-editorial" style="font-size: 1.15rem; color: var(--color-graphite);">
                    4 langkah praktis layaknya memindahkan kartu tugas dari awal hingga kamar siap kamu tempati.
                </p>
            </div>

            <!-- Kanban Board Mockup -->
            <div class="notion-kanban-board">

                <!-- Column 1 -->
                <div class="notion-kanban-col">
                    <div class="notion-kanban-col__header">
                        <h5 class="notion-kanban-col__title">1. Cari &amp; Filter</h5>
                        <span class="notion-kanban-col__count">Langkah 1</span>
                    </div>
                    <div class="notion-kanban-card">
                        <span class="notion-kanban-card__tag" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue);">Eksplorasi</span>
                        <p class="notion-kanban-card__text">Tentukan kota, radius kampus, dan anggaran bulanan.</p>
                    </div>
                    <div class="notion-kanban-card">
                        <span class="notion-kanban-card__tag" style="background-color: #f6f5f4; color: #555;">Fasilitas</span>
                        <p class="notion-kanban-card__text">Pilih preferensi kamar mandi dalam, AC, dan WiFi.</p>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="notion-kanban-col">
                    <div class="notion-kanban-col__header">
                        <h5 class="notion-kanban-col__title">2. Pilih Kamar</h5>
                        <span class="notion-kanban-col__count">Langkah 2</span>
                    </div>
                    <div class="notion-kanban-card">
                        <span class="notion-kanban-card__tag" style="background-color: #fef0ee; color: var(--color-coral);">Kurasi</span>
                        <p class="notion-kanban-card__text">Bandingkan foto galeri, ukuran kamar, dan aturan kos.</p>
                    </div>
                    <div class="notion-kanban-card">
                        <span class="notion-kanban-card__tag" style="background-color: #fff4e5; color: #b7791f;">Ulasan</span>
                        <p class="notion-kanban-card__text">Baca rating jujur dari para penghuni sebelumnya.</p>
                    </div>
                </div>

                <!-- Column 3 -->
                <div class="notion-kanban-col">
                    <div class="notion-kanban-col__header">
                        <h5 class="notion-kanban-col__title">3. Ajukan Sewa</h5>
                        <span class="notion-kanban-col__count">Langkah 3</span>
                    </div>
                    <div class="notion-kanban-card">
                        <span class="notion-kanban-card__tag" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue);">Pengajuan</span>
                        <p class="notion-kanban-card__text">Pilih durasi sewa &amp; tanggal rencana masuk kos.</p>
                    </div>
                    <div class="notion-kanban-card">
                        <span class="notion-kanban-card__tag" style="background-color: #edf7ee; color: #2e7d32;">Invoice</span>
                        <p class="notion-kanban-card__text">Lakukan pembayaran aman melalui Virtual Account.</p>
                    </div>
                </div>

                <!-- Column 4 -->
                <div class="notion-kanban-col">
                    <div class="notion-kanban-col__header">
                        <h5 class="notion-kanban-col__title">4. Siap Ditempati</h5>
                        <span class="notion-kanban-col__count">Selesai</span>
                    </div>
                    <div class="notion-kanban-card" style="border-left: 3px solid #27c93f;">
                        <span class="notion-kanban-card__tag" style="background-color: #edf7ee; color: #2e7d32;">Konfirmasi</span>
                        <p class="notion-kanban-card__text">Dapatkan kode bukti sewa dan kontak langsung pemilik.</p>
                    </div>
                    <div class="notion-kanban-card" style="border-left: 3px solid #0075de;">
                        <span class="notion-kanban-card__tag" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue);">Check-In</span>
                        <p class="notion-kanban-card__text">Bawa barang Anda dan tempati kamar kos impian Anda!</p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- =========================================================================
         6. MIDNIGHT INK DARK MODE ISLAND (STATISTIK & PERTUMBUHAN)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas);">
        <div class="container py-3">

            <div class="notion-dark-island text-center">
                <span class="badge badge-light text-dark font-weight-bold mb-3 px-3 py-1">
                    📊 Dampak Nyata
                </span>
                <h2 class="mb-2" style="font-size: 2.25rem; font-weight: 700; letter-spacing: -0.03em;">
                    Dipercaya di Seluruh Penjuru Nusantara
                </h2>
                <p class="font-editorial mb-5 mx-auto" style="max-width: 600px; font-size: 1.15rem;">
                    Menghubungkan puluhan ribu pencari kos dengan mitra pemilik properti terpercaya setiap harinya.
                </p>

                <div class="row">
                    <div class="col-6 col-md-3 mb-4 mb-md-0">
                        <div class="ts-promo-number">
                            <h2>5.200+</h2>
                            <h4>Kos Terdaftar</h4>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-4 mb-md-0">
                        <div class="ts-promo-number">
                            <h2>120+</h2>
                            <h4>Kota &amp; Kabupaten</h4>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-4 mb-md-0">
                        <div class="ts-promo-number">
                            <h2>38.000+</h2>
                            <h4>Penghuni Puas</h4>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 mb-4 mb-md-0">
                        <div class="ts-promo-number">
                            <h2>750+</h2>
                            <h4>Mitra Pemilik Properti</h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- =========================================================================
         7. TESTIMONIALS (EDITORIAL QUOTES WITH LYON TEXT)
         ========================================================================= -->
    <section class="py-5" style="background-color: var(--surface-page-canvas); border-top: var(--border-hairline);">
        <div class="container py-4">

            <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                <span class="badge badge-primary mb-2">💬 Kata Mereka</span>
                <h2 style="letter-spacing: -0.03em;">Cerita Dari Komunitas TEMPATIN</h2>
                <p class="font-editorial" style="font-size: 1.15rem; color: var(--color-graphite);">
                    Pengalaman nyata mahasiswa, pekerja, dan pemilik kos yang telah bergabung.
                </p>
            </div>

            <div class="row">

                <!-- Testimonial 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-warning mb-3">
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                            </div>
                            <p class="font-editorial mb-4" style="font-size: 1.05rem; line-height: 1.6; color: var(--color-charcoal);">
                                &ldquo;Cari kos dekat kampus UI Depok dulu makan waktu berhari-hari. Lewat TEMPATIN, saya booking kamar cuma dalam 15 menit dan kondisinya persis seperti di foto.&rdquo;
                            </p>
                        </div>
                        <div class="d-flex align-items-center pt-3" style="border-top: var(--border-hairline);">
                            <span class="notion-character-mark notion-character-mark--coral mr-3" style="width: 38px; height: 38px; font-size: 16px;">👩‍🎓</span>
                            <div>
                                <h6 class="mb-0 font-weight-bold">Anisa Rahmawati</h6>
                                <small class="text-muted">Mahasiswi UI, Depok</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-warning mb-3">
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                            </div>
                            <p class="font-editorial mb-4" style="font-size: 1.05rem; line-height: 1.6; color: var(--color-charcoal);">
                                &ldquo;Sebagai pemilik kos di Yogyakarta, kamar saya terisi penuh dalam 2 minggu setelah terdaftar. Dashboard pemiliknya simpel dan transaksinya transparan.&rdquo;
                            </p>
                        </div>
                        <div class="d-flex align-items-center pt-3" style="border-top: var(--border-hairline);">
                            <span class="notion-character-mark notion-character-mark--yellow mr-3" style="width: 38px; height: 38px; font-size: 16px;">🏠</span>
                            <div>
                                <h6 class="mb-0 font-weight-bold">Bagus Prasetyo</h6>
                                <small class="text-muted">Pemilik Kos Anggrek, Sleman</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card p-4 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="text-warning mb-3">
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                            </div>
                            <p class="font-editorial mb-4" style="font-size: 1.05rem; line-height: 1.6; color: var(--color-charcoal);">
                                &ldquo;Pindah kerja ke Surabaya tanpa kenalan satupun, untung ada TEMPATIN. Lokasi filter dan simulasi invoice sangat membantu budgeting bulanan saya.&rdquo;
                            </p>
                        </div>
                        <div class="d-flex align-items-center pt-3" style="border-top: var(--border-hairline);">
                            <span class="notion-character-mark notion-character-mark--blue mr-3" style="width: 38px; height: 38px; font-size: 16px;">💼</span>
                            <div>
                                <h6 class="mb-0 font-weight-bold">Dewi Lestari</h6>
                                <small class="text-muted">Software Engineer, Surabaya</small>
                            </div>
                        </div>
                    </div>
                </div>

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
                    <span class="badge badge-primary mb-2">📚 Pusat Bacaan</span>
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
                    <a href="{{ route('artikel') }}" class="notion-doc-card">
                        <div>
                            <span class="notion-doc-card__emoji">📝</span>
                            <h4 class="notion-doc-card__title">5 Tips Memilih Kos Dekat Kampus Tanpa Menyesal</h4>
                            <p class="notion-doc-card__desc">
                                Panduan mendasar memeriksa ventilasi, akses internet, dan jarak tempuh sebelum tanda tangan sewa.
                            </p>
                        </div>
                        <div class="notion-doc-card__meta">
                            <span><i class="fa fa-calendar-alt mr-1"></i> 2 Agustus 2026</span>
                            <span>&bull;</span>
                            <span>⏱️ 4 mnt baca</span>
                        </div>
                    </a>
                </div>

                <!-- Doc 2 -->
                <div class="col-md-4 mb-4">
                    <a href="{{ route('artikel') }}" class="notion-doc-card">
                        <div>
                            <span class="notion-doc-card__emoji">⚖️</span>
                            <h4 class="notion-doc-card__title">Perbedaan Kos Putra, Putri, Campur &amp; Eksklusif</h4>
                            <p class="notion-doc-card__desc">
                                Kenali aturan jam malam, fasilitas bersama, dan lingkungan sekitar sesuai gaya hidup Anda.
                            </p>
                        </div>
                        <div class="notion-doc-card__meta">
                            <span><i class="fa fa-calendar-alt mr-1"></i> 28 Juli 2026</span>
                            <span>&bull;</span>
                            <span>⏱️ 5 mnt baca</span>
                        </div>
                    </a>
                </div>

                <!-- Doc 3 -->
                <div class="col-md-4 mb-4">
                    <a href="{{ route('artikel') }}" class="notion-doc-card">
                        <div>
                            <span class="notion-doc-card__emoji">🛡️</span>
                            <h4 class="notion-doc-card__title">Cara Aman Booking Kos Secara Online &amp; Bebas Penipuan</h4>
                            <p class="notion-doc-card__desc">
                                Langkah proteksi pembayaran, pengecekan identitas pemilik, dan pemanfaatan sistem invoice resmi.
                            </p>
                        </div>
                        <div class="notion-doc-card__meta">
                            <span><i class="fa fa-calendar-alt mr-1"></i> 15 Juli 2026</span>
                            <span>&bull;</span>
                            <span>⏱️ 3 mnt baca</span>
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
