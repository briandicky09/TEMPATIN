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

            <!-- Centered Product UI Mockup (Search & Workspace Window - Prompt 6 Refined Combobox/Dropdown) -->
            <div class="notion-app-mockup text-left mx-auto" id="cari-kos-mockup" style="max-width: 1040px; overflow: visible;">
                
                <!-- Mockup Chrome Header -->
                <div class="notion-app-mockup__chrome">
                    <div class="notion-app-mockup__dots">
                        <span class="notion-app-mockup__dot notion-app-mockup__dot--red"></span>
                        <span class="notion-app-mockup__dot notion-app-mockup__dot--yellow"></span>
                        <span class="notion-app-mockup__dot notion-app-mockup__dot--green"></span>
                    </div>
                    <div class="notion-app-mockup__title">
                        <iconify-icon icon="lucide:search" class="text-muted mr-1" style="font-size: 13px;"></iconify-icon>
                        <span>tempatin.id / workspace / cari-kos</span>
                    </div>
                </div>

                <!-- Mockup Body (Refined Dropdown & Combobox Form) -->
                <div class="notion-app-mockup__body" style="padding: 28px 32px; background: #ffffff; overflow: visible; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    
                    <!-- Header Section inside Mockup -->
                    <div class="d-flex align-items-center mb-4 pb-2" style="gap: 16px; border-bottom: 1px solid #f1f5f9;">
                        <div style="width: 46px; height: 46px; background-color: #38bdf8; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px rgba(56, 189, 248, 0.25);">
                            <iconify-icon icon="lucide:compass" class="text-white" style="font-size: 24px;"></iconify-icon>
                        </div>
                        <div>
                            <h3 class="mb-0 font-weight-bold text-dark" style="font-size: 1.25rem; letter-spacing: -0.02em;">Eksplorasi Kos Terverifikasi</h3>
                            <p class="text-muted small mb-0" style="margin-top: 2px;">Gunakan filter pintar untuk menemukan hunian ideal sesuai kriteria Anda</p>
                        </div>
                    </div>

                    <form action="{{ route('search.kos') }}" method="GET" class="ts-form" id="workspaceSearchForm">
                        <div class="row">
                            
                            <!-- 1. Pencarian Kata Kunci / Kampus -->
                            <div class="col-md-6 mb-4">
                                <div class="d-flex align-items-center mb-2" style="gap: 8px;">
                                    <iconify-icon icon="lucide:search" style="color: #4B7EFC; font-size: 18px;"></iconify-icon>
                                    <label class="mb-0 font-weight-medium text-dark" style="font-size: 15px;">Cari Nama Kos / Kampus</label>
                                </div>
                                <div class="position-relative workspace-input-ring">
                                    <span class="position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; display: flex; align-items: center;">
                                        <iconify-icon icon="lucide:search" style="font-size: 18px;"></iconify-icon>
                                    </span>
                                    <input 
                                        type="text" 
                                        id="keyword" 
                                        name="keyword" 
                                        placeholder="Contoh: Dekat UGM, Melati, Pogung..."
                                        class="w-100 py-3 bg-transparent border-0 text-dark outline-none"
                                        style="padding-left: 44px; padding-right: 16px; font-size: 14.5px; border-radius: 12px;"
                                    >
                                </div>
                            </div>

                            <!-- 2. Kategori / Tipe Kos -->
                            <div class="col-md-6 mb-4">
                                <div class="workspace-combobox" id="workspaceTypeCombobox">
                                    <div class="d-flex align-items-center mb-2" style="gap: 8px;">
                                        <iconify-icon icon="lucide:folder" style="color: #f59e0b; font-size: 18px;"></iconify-icon>
                                        <label class="mb-0 font-weight-medium text-dark" style="font-size: 15px;">Kategori / Tipe Kos</label>
                                    </div>
                                    <button 
                                        type="button" 
                                        class="workspace-combobox-btn" 
                                        id="typeComboboxBtn"
                                        aria-haspopup="listbox" 
                                        aria-expanded="false"
                                    >
                                        <span id="typeSelectedLabel">Semua Tipe Kos</span>
                                        <iconify-icon icon="lucide:chevron-down" class="workspace-combobox-chevron" style="font-size: 18px;"></iconify-icon>
                                    </button>
                                    
                                    <!-- Dropdown Menu -->
                                    <div class="workspace-dropdown-menu" id="typeDropdownMenu" role="listbox">
                                        <div class="workspace-dropdown-heading">Pilihan Kategori</div>
                                        <button type="button" class="workspace-dropdown-item is-selected" data-val="" data-label="Semua Tipe Kos">
                                            <span>Semua Tipe Kos</span>
                                            <iconify-icon icon="lucide:check" class="item-check" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                        <button type="button" class="workspace-dropdown-item" data-val="putra" data-label="Kos Khusus Putra">
                                            <span>Kos Khusus Putra</span>
                                            <iconify-icon icon="lucide:check" class="item-check d-none" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                        <button type="button" class="workspace-dropdown-item" data-val="putri" data-label="Kos Khusus Putri">
                                            <span>Kos Khusus Putri</span>
                                            <iconify-icon icon="lucide:check" class="item-check d-none" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                        <button type="button" class="workspace-dropdown-item" data-val="campur" data-label="Kos Campur">
                                            <span>Kos Campur</span>
                                            <iconify-icon icon="lucide:check" class="item-check d-none" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                        <button type="button" class="workspace-dropdown-item" data-val="eksklusif" data-label="Kos Eksklusif">
                                            <span>Kos Eksklusif</span>
                                            <iconify-icon icon="lucide:check" class="item-check d-none" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                    </div>
                                    <input type="hidden" name="type" id="typeHiddenInput" value="">
                                </div>
                            </div>

                            <!-- 3. Kota / Wilayah -->
                            <div class="col-md-4 mb-4">
                                <div class="workspace-combobox" id="workspaceCityCombobox">
                                    <div class="d-flex align-items-center mb-2" style="gap: 8px;">
                                        <iconify-icon icon="lucide:map-pin" style="color: #3b82f6; font-size: 18px;"></iconify-icon>
                                        <label class="mb-0 font-weight-medium text-dark" style="font-size: 15px;">Kota / Wilayah</label>
                                    </div>
                                    <button 
                                        type="button" 
                                        class="workspace-combobox-btn" 
                                        id="cityComboboxBtn"
                                        aria-haspopup="listbox" 
                                        aria-expanded="false"
                                    >
                                        <span id="citySelectedLabel">Semua Kota</span>
                                        <iconify-icon icon="lucide:chevron-down" class="workspace-combobox-chevron" style="font-size: 18px;"></iconify-icon>
                                    </button>

                                    <!-- Dropdown Menu -->
                                    <div class="workspace-dropdown-menu" id="cityDropdownMenu" role="listbox">
                                        <div class="workspace-dropdown-heading">Kota Populer</div>
                                        <button type="button" class="workspace-dropdown-item is-selected" data-val="" data-label="Semua Kota">
                                            <span>Semua Kota</span>
                                            <iconify-icon icon="lucide:check" class="item-check" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                        <button type="button" class="workspace-dropdown-item" data-val="jakarta" data-label="DKI Jakarta">
                                            <span>DKI Jakarta</span>
                                            <iconify-icon icon="lucide:check" class="item-check d-none" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                        <button type="button" class="workspace-dropdown-item" data-val="yogyakarta" data-label="DI Yogyakarta">
                                            <span>DI Yogyakarta</span>
                                            <iconify-icon icon="lucide:check" class="item-check d-none" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                        <button type="button" class="workspace-dropdown-item" data-val="bandung" data-label="Bandung">
                                            <span>Bandung</span>
                                            <iconify-icon icon="lucide:check" class="item-check d-none" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                        <button type="button" class="workspace-dropdown-item" data-val="surabaya" data-label="Surabaya">
                                            <span>Surabaya</span>
                                            <iconify-icon icon="lucide:check" class="item-check d-none" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                        <button type="button" class="workspace-dropdown-item" data-val="malang" data-label="Malang">
                                            <span>Malang</span>
                                            <iconify-icon icon="lucide:check" class="item-check d-none" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                        <button type="button" class="workspace-dropdown-item" data-val="semarang" data-label="Semarang">
                                            <span>Semarang</span>
                                            <iconify-icon icon="lucide:check" class="item-check d-none" style="font-size: 16px;"></iconify-icon>
                                        </button>
                                    </div>
                                    <input type="hidden" name="city" id="cityHiddenInput" value="">
                                </div>
                            </div>

                            <!-- 4. Estimasi Budget Maksimal -->
                            <div class="col-md-4 mb-4">
                                <div class="d-flex align-items-center mb-2" style="gap: 8px;">
                                    <iconify-icon icon="lucide:hash" style="color: #2563eb; font-size: 18px;"></iconify-icon>
                                    <label class="mb-0 font-weight-medium text-dark" style="font-size: 15px;">Budget Maksimal (Rp)</label>
                                </div>
                                <div class="workspace-input-ring">
                                    <input 
                                        type="number" 
                                        id="max_price" 
                                        name="max_price" 
                                        placeholder="Contoh: 1500000"
                                        class="w-100 py-3 px-3 bg-transparent border-0 text-dark outline-none"
                                        style="font-size: 14.5px; border-radius: 12px;"
                                    >
                                </div>
                            </div>

                            <!-- 5. Tautan Referensi -->
                            <div class="col-md-4 mb-4">
                                <div class="d-flex align-items-center mb-2" style="gap: 8px;">
                                    <iconify-icon icon="lucide:link" style="color: #9333ea; font-size: 18px;"></iconify-icon>
                                    <label class="mb-0 font-weight-medium text-dark" style="font-size: 15px;">Tautan Referensi</label>
                                </div>
                                <div class="workspace-input-ring">
                                    <input 
                                        type="url" 
                                        placeholder="https://tempatin.id/workspace/cari-kos"
                                        class="w-100 py-3 px-3 bg-transparent border-0 text-dark outline-none"
                                        style="font-size: 14.5px; border-radius: 12px;"
                                    >
                                </div>
                            </div>

                        </div>

                        <!-- Action Bar inside Mockup -->
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-3" style="border-top: 1px solid #f1f5f9; gap: 14px;">
                            
                            <!-- Quick Filter Tags -->
                            <div class="d-flex flex-wrap align-items-center" style="gap: 6px;">
                                <span class="text-muted small mr-1 font-weight-medium">Paling Dicari:</span>
                                <a href="{{ route('search.kos', ['city' => 'yogyakarta']) }}" class="badge badge-light border text-dark text-decoration-none py-1 px-2" style="border-radius: 6px;">
                                    <iconify-icon icon="lucide:map-pin" class="mr-1 text-muted" style="font-size: 12px;"></iconify-icon> Yogyakarta
                                </a>
                                <a href="{{ route('search.kos', ['city' => 'surabaya']) }}" class="badge badge-light border text-dark text-decoration-none py-1 px-2" style="border-radius: 6px;">
                                    <iconify-icon icon="lucide:map-pin" class="mr-1 text-muted" style="font-size: 12px;"></iconify-icon> Surabaya
                                </a>
                                <a href="{{ route('search.kos', ['city' => 'bandung']) }}" class="badge badge-light border text-dark text-decoration-none py-1 px-2" style="border-radius: 6px;">
                                    <iconify-icon icon="lucide:map-pin" class="mr-1 text-muted" style="font-size: 12px;"></iconify-icon> Bandung
                                </a>
                                <a href="{{ route('search.kos', ['type' => 'putri']) }}" class="badge badge-light border text-dark text-decoration-none py-1 px-2" style="border-radius: 6px;">Kos Putri</a>
                                <a href="{{ route('search.kos', ['type' => 'putra']) }}" class="badge badge-light border text-dark text-decoration-none py-1 px-2" style="border-radius: 6px;">Kos Putra</a>
                            </div>

                            <!-- Clean Cari Button (No icon / sparkles logo, text 'Cari') -->
                            <button type="submit" class="ts-btn-cari w-100 w-md-auto" id="btnWorkspaceSubmit">
                                Cari
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
         3. NILAI UTAMA (SELF-CONTAINED SHADCN TIMELINE COMPONENT)
         Spec: Ground #FAFAFA, Card #FFFFFF, Ink #09090B, Muted #71717A, Border #E4E4E7, Accent #4F46E5
         Strictly monochromatic + single indigo accent, no rainbow colors.
         Vertical spine fills dynamically via single IntersectionObserver.
         ========================================================================= -->
    <section class="shadcn-timeline-section py-5" id="nilai-utama" style="background-color: var(--surface-page-canvas); border-top: var(--border-hairline);">
        <div class="container py-4">

            <!-- Section Header -->
            <div class="text-center mx-auto mb-4" style="max-width: 640px;">
                <span class="notion-pill-badge mb-2">Nilai Utama</span>
                <h2 style="font-size: clamp(2rem, 3.2vw, 2.75rem); font-weight: 700; letter-spacing: -0.035em; color: var(--color-ink-black); line-height: 1.15;">
                    Dibuat untuk Pengalaman Sewa Tanpa Cemas
                </h2>
                <p class="font-editorial mx-auto mb-0" style="font-size: 1.15rem; color: var(--color-graphite); line-height: 1.6; max-width: 640px;">
                    Standar baru menyewa kos di Indonesia: transparan, terjamin, dan didukung kurasi lapangan langsung.
                </p>
            </div>

            <!-- Self-Contained Timeline Root -->
            <div class="shadcn-timeline-root" id="shadcnTimeline">

                <!-- Vertical Spine Rail -->
                <div class="timeline-spine-rail" aria-hidden="true">
                    <div class="timeline-spine-track"></div>
                    <div class="timeline-spine-fill" id="timelineSpineFill"></div>
                </div>

                <!-- Entries List -->
                <div class="timeline-entries-list" role="list">

                    <!-- Entry 01: Verifikasi Lapangan -->
                    <div class="timeline-entry" data-index="0" role="listitem">
                        <div class="timeline-year-col">
                            <span class="timeline-year-text">2026 / 01</span>
                        </div>
                        <div class="timeline-dot-col" aria-hidden="true">
                            <div class="timeline-dot"></div>
                        </div>
                        <div class="timeline-card-col">
                            <span class="timeline-year-mobile">2026 / 01</span>
                            <h3 class="timeline-entry-title">Inspeksi Fisik &amp; Kurasi 100% Bebas Fiktif</h3>
                            <div class="timeline-card">
                                <p class="timeline-card-body">
                                    Setiap kos wajib lolos inspeksi kurasi lapangan langsung. Kami menguji sirkulasi ventilasi udara, kebersihan sanitasi kamar mandi, kelayakan kasur, dan memastikan foto 100% riil tanpa manipulasi sudut lensa.
                                </p>
                                <div class="timeline-card-footer">
                                    <div class="timeline-avatar-group">
                                        <div class="timeline-avatar-disc" aria-hidden="true">KL</div>
                                        <div class="timeline-avatar-meta">
                                            <span class="timeline-avatar-name">Tim Kurasi Lapangan</span>
                                            <span class="timeline-avatar-role">Verifikasi Fisik Mandiri</span>
                                        </div>
                                    </div>
                                    <span class="timeline-spec-pill">100% Bebas Fiktif</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Entry 02: Transparansi Biaya -->
                    <div class="timeline-entry" data-index="1" role="listitem">
                        <div class="timeline-year-col">
                            <span class="timeline-year-text">2026 / 02</span>
                        </div>
                        <div class="timeline-dot-col" aria-hidden="true">
                            <div class="timeline-dot"></div>
                        </div>
                        <div class="timeline-card-col">
                            <span class="timeline-year-mobile">2026 / 02</span>
                            <h3 class="timeline-entry-title">Harga Pasti &amp; Transparansi Biaya Riil</h3>
                            <div class="timeline-card">
                                <p class="timeline-card-body">
                                    Tidak ada pungutan tersembunyi saat Anda tiba di lokasi. Rincian biaya sewa kamar bulanan, tagihan listrik, air, parkir, dan deposit jaminan dicantumkan secara terbuka dalam rincian invoice digital resmi.
                                </p>
                                <div class="timeline-card-footer">
                                    <div class="timeline-avatar-group">
                                        <div class="timeline-avatar-disc" aria-hidden="true">TB</div>
                                        <div class="timeline-avatar-meta">
                                            <span class="timeline-avatar-name">Sistem Transparansi Riil</span>
                                            <span class="timeline-avatar-role">Pasti &amp; Terbuka</span>
                                        </div>
                                    </div>
                                    <span class="timeline-spec-pill">Biaya Siluman Rp 0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Entry 03: Escrow & Garansi -->
                    <div class="timeline-entry" data-index="2" role="listitem">
                        <div class="timeline-year-col">
                            <span class="timeline-year-text">2026 / 03</span>
                        </div>
                        <div class="timeline-dot-col" aria-hidden="true">
                            <div class="timeline-dot"></div>
                        </div>
                        <div class="timeline-card-col">
                            <span class="timeline-year-mobile">2026 / 03</span>
                            <h3 class="timeline-entry-title">Sistem Escrow &amp; Garansi Refund 100%</h3>
                            <div class="timeline-card">
                                <p class="timeline-card-body">
                                    Dana sewa Anda terlindungi dalam sistem escrow resmi TEMPATIN. Pembayaran baru diteruskan ke pemilik setelah Anda tiba di kos dan mengonfirmasi kondisi kamar sesuai dengan kesepakatan tertulis.
                                </p>
                                <div class="timeline-card-footer">
                                    <div class="timeline-avatar-group">
                                        <div class="timeline-avatar-disc" aria-hidden="true">PE</div>
                                        <div class="timeline-avatar-meta">
                                            <span class="timeline-avatar-name">Proteksi Escrow TEMPATIN</span>
                                            <span class="timeline-avatar-role">Rekening Bersama Aman</span>
                                        </div>
                                    </div>
                                    <span class="timeline-spec-pill">100% Refund Terjamin</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Entry 04: Booking Digital Paperless -->
                    <div class="timeline-entry" data-index="3" role="listitem">
                        <div class="timeline-year-col">
                            <span class="timeline-year-text">2026 / 04</span>
                        </div>
                        <div class="timeline-dot-col" aria-hidden="true">
                            <div class="timeline-dot"></div>
                        </div>
                        <div class="timeline-card-col">
                            <span class="timeline-year-mobile">2026 / 04</span>
                            <h3 class="timeline-entry-title">Booking Digital Terpadu &amp; Paperless</h3>
                            <div class="timeline-card">
                                <p class="timeline-card-body">
                                    Proses sewa selesai dalam 3 menit langsung dari smartphone Anda tanpa harus survei manual di jalanan macet. Bukti reservasi digital resmi, kontrak sewa sah, dan instruksi serah terima kamar terbit instan.
                                </p>
                                <div class="timeline-card-footer">
                                    <div class="timeline-avatar-group">
                                        <div class="timeline-avatar-disc" aria-hidden="true">BD</div>
                                        <div class="timeline-avatar-meta">
                                            <span class="timeline-avatar-name">Layanan Booking Digital</span>
                                            <span class="timeline-avatar-role">Paperless &amp; Sah Hukum</span>
                                        </div>
                                    </div>
                                    <span class="timeline-spec-pill">Proses 3 Menit</span>
                                </div>
                            </div>
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

            <div class="row" id="tsStatsRow">
                <!-- Stat 1 -->
                <div class="col-6 col-lg-3 mb-4 mb-lg-0">
                    <div class="ts-stat-card h-100 text-left d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 12px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px;">
                                <iconify-icon icon="lucide:home"></iconify-icon>
                            </div>
                            <div class="ts-stat-number stat-countup" data-target="5200" data-suffix="+">
                                0
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
                    <div class="ts-stat-card h-100 text-left d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 12px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px;">
                                <iconify-icon icon="lucide:map-pin"></iconify-icon>
                            </div>
                            <div class="ts-stat-number stat-countup" data-target="120" data-suffix="+">
                                0
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
                    <div class="ts-stat-card h-100 text-left d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 12px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px;">
                                <iconify-icon icon="lucide:users"></iconify-icon>
                            </div>
                            <div class="ts-stat-number stat-countup" data-target="38000" data-suffix="+">
                                0
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
                    <div class="ts-stat-card h-100 text-left d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 12px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px;">
                                <iconify-icon icon="lucide:handshake"></iconify-icon>
                            </div>
                            <div class="ts-stat-number stat-countup" data-target="750" data-suffix="+">
                                0
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
         7. SHADCN TESTIMONIAL COMPONENT (PROMPT 3 SPEC)
         Self-contained: Heading & lede left, quote card with star rating right, dot pagination
         Ground #FAFAFA, Card #FFFFFF, Ink #09090B, Muted #71717A, Border #E4E4E7, Accent #4F46E5
         ========================================================================= -->
    @php
        $shadcnTestimonials = [
            [
                'quote' => 'Cari kos dekat kampus UI Depok dulu makan waktu berhari-hari. Lewat TEMPATIN, saya booking kamar cuma dalam 15 menit dan kondisinya persis seperti di foto.',
                'name' => 'Anisa Rahmawati',
                'role' => 'Mahasiswi UI, Depok',
                'initials' => 'AR',
                'bg' => '#4F46E5'
            ],
            [
                'quote' => 'Sebagai pemilik kos di Yogyakarta, kamar saya terisi penuh dalam 2 minggu setelah terdaftar. Dashboard pemiliknya simpel dan transaksinya transparan.',
                'name' => 'Bagus Prasetyo',
                'role' => 'Pemilik Kos Anggrek, Sleman',
                'initials' => 'BP',
                'bg' => '#0075DE'
            ],
            [
                'quote' => 'Pindah kerja ke Surabaya tanpa kenalan satupun, untung ada TEMPATIN. Filter lokasi dan simulasi invoice sangat membantu budgeting bulanan saya.',
                'name' => 'Dewi Lestari',
                'role' => 'Software Engineer, Surabaya',
                'initials' => 'DL',
                'bg' => '#10B981'
            ],
            [
                'quote' => 'Fitur verified room dan pembayaran otomatis bikin sewa kosan aman tanpa was-was penipuan. Customer support juga sangat responsif saat ada kendala.',
                'name' => 'Rian Hidayat',
                'role' => 'Mahasiswa ITB, Bandung',
                'initials' => 'RH',
                'bg' => '#F59E0B'
            ],
            [
                'quote' => 'Pengelolaan tagihan dan konfirmasi bukti transfer jadi otomatis lewat sistem. Sangat menghemat waktu saya setiap awal bulan tanpa perlu mutasi manual.',
                'name' => 'Siti Nurhaliza',
                'role' => 'Pemilik Paviliun Melati, Jaksel',
                'initials' => 'SN',
                'bg' => '#EC4899'
            ]
        ];
    @endphp

    <section class="shadcn-testimonial-section" id="shadcnTestimonialsSection">
        <div class="container">
            <div class="row align-items-center">
                
                <!-- Left: Heading, Lede, & Dot Pagination -->
                <div class="col-lg-5 mb-5 mb-lg-0 pr-lg-4">
                    <div style="max-width: 440px;">
                        <span class="badge mb-3" style="background-color: #EEF2FF; color: #4F46E5; border: 1px solid #E0E7FF; font-size: 12px; font-weight: 600; padding: 5px 12px; border-radius: 9999px;">
                            Testimoni Komunitas
                        </span>
                        <h2 class="mb-3" style="font-size: 2.25rem; font-weight: 700; color: #09090B; letter-spacing: -0.03em; line-height: 1.25;">
                            Dipercaya oleh Pencari &amp; Pemilik Kos
                        </h2>
                        <p style="font-size: 1.125rem; color: #71717A; line-height: 1.6; margin-bottom: 28px;">
                            Cerita nyata mahasiswa, pekerja kantoran, dan mitra properti yang merasakan kemudahan sewa kos tanpa ribet di TEMPATIN.
                        </p>

                        <!-- Dot Pagination (Real buttons with aria-current) -->
                        <div class="shadcn-dots" role="tablist" aria-label="Navigasi testimoni">
                            @foreach($shadcnTestimonials as $idx => $st)
                                <button 
                                    type="button" 
                                    class="shadcn-dot {{ $idx === 0 ? 'active' : '' }}" 
                                    role="tab" 
                                    aria-label="Testimoni {{ $idx + 1 }} dari {{ count($shadcnTestimonials) }}" 
                                    aria-current="{{ $idx === 0 ? 'true' : 'false' }}" 
                                    data-index="{{ $idx }}"
                                ></button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right: Self-Contained Quote Card with Star Rating & Initial Avatar -->
                <div class="col-lg-7">
                    <div class="shadcn-testimonial-card" id="shadcnTestimonialCard">
                        @foreach($shadcnTestimonials as $idx => $st)
                            <div class="shadcn-testimonial-item {{ $idx === 0 ? 'is-active' : '' }}" data-index="{{ $idx }}" role="tabpanel">
                                <!-- 5 Star Rating -->
                                <div class="shadcn-stars">
                                    <iconify-icon icon="lucide:star" class="text-[#4F46E5]" style="font-size: 18px; fill: currentColor;"></iconify-icon>
                                    <iconify-icon icon="lucide:star" class="text-[#4F46E5]" style="font-size: 18px; fill: currentColor;"></iconify-icon>
                                    <iconify-icon icon="lucide:star" class="text-[#4F46E5]" style="font-size: 18px; fill: currentColor;"></iconify-icon>
                                    <iconify-icon icon="lucide:star" class="text-[#4F46E5]" style="font-size: 18px; fill: currentColor;"></iconify-icon>
                                    <iconify-icon icon="lucide:star" class="text-[#4F46E5]" style="font-size: 18px; fill: currentColor;"></iconify-icon>
                                </div>

                                <!-- Quote -->
                                <p class="shadcn-quote">
                                    &ldquo;{{ $st['quote'] }}&rdquo;
                                </p>

                                <!-- Author Info with Initial-Based Avatar -->
                                <div class="d-flex align-items-center" style="gap: 14px; margin-top: auto;">
                                    <div class="shadcn-avatar" style="background-color: {{ $st['bg'] }};">
                                        {{ $st['initials'] }}
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 15px; color: #09090B;">
                                            {{ $st['name'] }}
                                        </div>
                                        <div style="font-size: 13px; color: #71717A;">
                                            {{ $st['role'] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
       2. MASONRY GALLERY CONTROLLER (KOS POPULER MINGGU INI - PROMPT ADAPTATION)
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

    /* =========================================================================
       4. DAMPAK NYATA: COUNT-UP ANIMATION ON VIEWPORT SCROLL (PROMPT 1)
       Numbers displayed in large font with dynamic count-up dynamic increase
       ========================================================================= */
    const statElements = document.querySelectorAll('.stat-countup');
    if (statElements.length > 0) {
        let statsDone = false;

        function runDynamicCountUp(el) {
            const targetVal = parseInt(el.getAttribute('data-target') || '0', 10);
            const suffix = el.getAttribute('data-suffix') || '';
            const duration = 2000;
            const startTime = performance.now();

            function tick(now) {
                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);
                // Ease out cubic
                const easeOut = 1 - Math.pow(1 - progress, 3);
                const current = Math.floor(easeOut * targetVal);
                el.textContent = current.toLocaleString('id-ID') + suffix;

                if (progress < 1) {
                    requestAnimationFrame(tick);
                } else {
                    el.textContent = targetVal.toLocaleString('id-ID') + suffix;
                }
            }
            requestAnimationFrame(tick);
        }

        if ('IntersectionObserver' in window) {
            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !statsDone) {
                        statsDone = true;
                        statElements.forEach(runDynamicCountUp);
                        statsObserver.disconnect();
                    }
                });
            }, { threshold: 0.25 });

            const statsRow = document.getElementById('tsStatsRow');
            if (statsRow) {
                statsObserver.observe(statsRow);
            } else {
                statElements.forEach(el => statsObserver.observe(el));
            }
        } else {
            statElements.forEach(runDynamicCountUp);
        }
    }

    /* =========================================================================
       5. REFINED CARI KOS COMBOBOX / DROPDOWN CONTROLLER (PROMPT 6)
       tempatin.id / workspace / cari-kos
       ========================================================================= */
    function setupCombobox(comboboxId, btnId, labelId, hiddenInputId) {
        const combobox = document.getElementById(comboboxId);
        if (!combobox) return;

        const btn = document.getElementById(btnId);
        const label = document.getElementById(labelId);
        const hiddenInput = document.getElementById(hiddenInputId);
        const items = combobox.querySelectorAll('.workspace-dropdown-item');
        const dropdownMenu = combobox.querySelector('.workspace-dropdown-menu');
        const parentCol = combobox.closest('.col-md-6, .col-md-4');

        if (dropdownMenu) {
            // Prevent clicks on the scrollbar or menu header from bubbling up to document and closing the menu
            dropdownMenu.addEventListener('click', function (e) {
                if (!e.target.closest('.workspace-dropdown-item')) {
                    e.stopPropagation();
                }
            });
        }

        if (btn) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                const isOpen = combobox.classList.contains('open');
                // Close any other open comboboxes
                document.querySelectorAll('.workspace-combobox.open').forEach(cb => {
                    if (cb !== combobox) {
                        cb.classList.remove('open');
                        const pCol = cb.closest('.col-md-6, .col-md-4');
                        if (pCol) pCol.style.removeProperty('z-index');
                        const otherBtn = cb.querySelector('.workspace-combobox-btn');
                        if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
                    }
                });
                if (isOpen) {
                    combobox.classList.remove('open');
                    if (parentCol) parentCol.style.removeProperty('z-index');
                    btn.setAttribute('aria-expanded', 'false');
                } else {
                    combobox.classList.add('open');
                    if (parentCol) parentCol.style.zIndex = '1050';
                    btn.setAttribute('aria-expanded', 'true');
                }
            });
        }

        items.forEach(item => {
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                const val = this.getAttribute('data-val');
                const itemLabel = this.getAttribute('data-label');

                if (hiddenInput) hiddenInput.value = val;
                if (label) label.textContent = itemLabel;

                // Update visual selection
                items.forEach(it => {
                    it.classList.remove('is-selected');
                    const check = it.querySelector('.item-check');
                    if (check) check.classList.add('d-none');
                });
                this.classList.add('is-selected');
                const check = this.querySelector('.item-check');
                if (check) check.classList.remove('d-none');

                combobox.classList.remove('open');
                if (parentCol) parentCol.style.removeProperty('z-index');
                if (btn) btn.setAttribute('aria-expanded', 'false');
            });
        });
    }

    setupCombobox('workspaceTypeCombobox', 'typeComboboxBtn', 'typeSelectedLabel', 'typeHiddenInput');
    setupCombobox('workspaceCityCombobox', 'cityComboboxBtn', 'citySelectedLabel', 'cityHiddenInput');

    // Close on click outside (only if click is outside of combobox)
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.workspace-combobox')) {
            document.querySelectorAll('.workspace-combobox.open').forEach(cb => {
                cb.classList.remove('open');
                const pCol = cb.closest('.col-md-6, .col-md-4');
                if (pCol) pCol.style.removeProperty('z-index');
                const b = cb.querySelector('.workspace-combobox-btn');
                if (b) b.setAttribute('aria-expanded', 'false');
            });
        }
    });

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.workspace-combobox.open').forEach(cb => {
                cb.classList.remove('open');
                const pCol = cb.closest('.col-md-6, .col-md-4');
                if (pCol) pCol.style.removeProperty('z-index');
                const b = cb.querySelector('.workspace-combobox-btn');
                if (b) b.setAttribute('aria-expanded', 'false');
            });
        }
    });

    /* =========================================================================
       6. SHADCN TESTIMONIAL COMPONENT (PROMPT 3)
       Heading and lede left, quote card with star rating right, dot pagination,
       aria-current, cross-fade rather than snapping, initial-based avatar
       ========================================================================= */
    const testimonialCard = document.getElementById('shadcnTestimonialCard');
    const testimonialDots = document.querySelectorAll('.shadcn-dot');
    if (testimonialCard && testimonialDots.length > 0) {
        const items = testimonialCard.querySelectorAll('.shadcn-testimonial-item');
        let activeIdx = 0;
        let autoPlayTimer = null;
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function goToTestimonial(newIdx) {
            if (newIdx === activeIdx || newIdx < 0 || newIdx >= items.length) return;

            // Update dots
            testimonialDots.forEach((dot, idx) => {
                const isActive = idx === newIdx;
                dot.classList.toggle('active', isActive);
                dot.setAttribute('aria-current', isActive ? 'true' : 'false');
            });

            // Cross-fade items
            items.forEach((item, idx) => {
                item.classList.toggle('is-active', idx === newIdx);
            });

            activeIdx = newIdx;
        }

        testimonialDots.forEach(dot => {
            dot.addEventListener('click', function () {
                const targetIdx = parseInt(this.getAttribute('data-index'), 10);
                goToTestimonial(targetIdx);
                resetAutoPlay();
            });
        });

        function startAutoPlay() {
            if (prefersReducedMotion) return;
            stopAutoPlay();
            autoPlayTimer = setInterval(() => {
                const nextIdx = (activeIdx + 1) % items.length;
                goToTestimonial(nextIdx);
            }, 6500);
        }

        function stopAutoPlay() {
            if (autoPlayTimer) {
                clearInterval(autoPlayTimer);
                autoPlayTimer = null;
            }
        }

        function resetAutoPlay() {
            stopAutoPlay();
            startAutoPlay();
        }

        // Pause on mouse hover or focus
        testimonialCard.addEventListener('mouseenter', stopAutoPlay);
        testimonialCard.addEventListener('mouseleave', startAutoPlay);
        const dotsWrap = document.querySelector('.shadcn-dots');
        if (dotsWrap) {
            dotsWrap.addEventListener('mouseenter', stopAutoPlay);
            dotsWrap.addEventListener('mouseleave', startAutoPlay);
        }

        startAutoPlay();
    }

    // =========================================================================
    // Self-Contained Shadcn Timeline Component Logic (Nilai Utama)
    // Vertical spine fills dynamically based on entries revealed by one IntersectionObserver.
    // Spec: Reduced-motion fallback removes motion mechanic entirely.
    // =========================================================================
    const timelineRoot = document.getElementById('shadcnTimeline');
    if (timelineRoot) {
        const entries = Array.from(timelineRoot.querySelectorAll('.timeline-entry'));
        const spineRail = timelineRoot.querySelector('.timeline-spine-rail');
        const spineFill = document.getElementById('timelineSpineFill');
        const total = entries.length;

        function alignSpine() {
            if (entries.length === 0 || !spineRail) return;
            const firstDot = entries[0].querySelector('.timeline-dot');
            const lastDot = entries[entries.length - 1].querySelector('.timeline-dot');
            if (firstDot && lastDot) {
                const rootRect = timelineRoot.getBoundingClientRect();
                const firstRect = firstDot.getBoundingClientRect();
                const lastRect = lastDot.getBoundingClientRect();

                const top = (firstRect.top - rootRect.top) + (firstRect.height / 2);
                const height = lastRect.top - firstRect.top;
                const left = (firstRect.left - rootRect.left) + (firstRect.width / 2) - 1;

                spineRail.style.top = `${top}px`;
                spineRail.style.height = `${height}px`;
                spineRail.style.left = `${left}px`;
            }
        }

        alignSpine();
        window.addEventListener('resize', alignSpine, { passive: true });

        const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (prefersReduced) {
            entries.forEach(e => e.classList.add('is-revealed'));
            if (spineFill) spineFill.style.height = '100%';
        } else {
            function updateSpineFill() {
                if (!spineFill || total <= 1) return;
                let maxRevealed = -1;
                entries.forEach((entry, idx) => {
                    if (entry.classList.contains('is-revealed')) {
                        maxRevealed = idx;
                    }
                });

                if (maxRevealed <= 0) {
                    spineFill.style.height = '0%';
                } else {
                    const pct = (maxRevealed / (total - 1)) * 100;
                    spineFill.style.height = `${pct}%`;
                }
            }

            // Single IntersectionObserver observing all entries
            const timelineObserver = new IntersectionObserver((obsEntries) => {
                obsEntries.forEach(obsEntry => {
                    const el = obsEntry.target;
                    const idx = parseInt(el.getAttribute('data-index'), 10);
                    if (obsEntry.isIntersecting) {
                        el.classList.add('is-revealed');
                        for (let i = 0; i <= idx; i++) {
                            entries[i].classList.add('is-revealed');
                        }
                    } else {
                        const rect = obsEntry.boundingClientRect;
                        const vh = window.innerHeight || document.documentElement.clientHeight;
                        if (rect.top > vh * 0.75) {
                            el.classList.remove('is-revealed');
                            for (let i = idx; i < total; i++) {
                                entries[i].classList.remove('is-revealed');
                            }
                        }
                    }
                });
                updateSpineFill();
            }, {
                threshold: 0.2,
                rootMargin: '0px 0px -10% 0px'
            });

            entries.forEach(entry => timelineObserver.observe(entry));
        }
    }
});
</script>
@endpush
