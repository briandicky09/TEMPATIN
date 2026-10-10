@extends('layouts.app')

@section('title', 'Tentang TEMPATIN - Visi, Cerita & Standar Hunian Kami')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 12px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" style="color: var(--color-stone); text-decoration: none;">
                            <i class="fa fa-home mr-1"></i> Beranda
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 600;">
                        Tentang Kami
                    </li>
                </ol>
            </nav>
        </div>

        <!-- HERO HEADER WITH REAL COMMUNITY IMAGE -->
        <section class="container mb-5">
            <div class="p-4 p-md-5 rounded overflow-hidden" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); border: 1px solid rgba(0, 117, 222, 0.2); font-size: 12px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.04em;">
                            <i class="fa fa-compass mr-2"></i> MENGENAL PLATFORM TEMPATIN
                        </div>
                        <h1 style="font-family: var(--font-serif); font-size: clamp(2rem, 3.6vw, 2.85rem); font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.025em; line-height: 1.25;" class="mb-3">
                            Mendefinisikan Ulang Pengalaman Mencari Kos di Indonesia.
                        </h1>
                        <p style="font-size: 16px; color: var(--color-stone); line-height: 1.65; margin-bottom: 24px; max-width: 620px;">
                            Kami membangun jembatan terpercaya antara mahasiswa, profesional muda, dan pemilik properti kos melalui transparansi data fisik, verifikasi lapangan yang ketat, serta perlindungan transaksi digital tanpa rasa cemas.
                        </p>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <a href="{{ route('kos.index') }}" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13.5px; padding: 10px 22px; border-radius: var(--radius-buttons); text-decoration: none;">
                                <i class="fa fa-search mr-2"></i> Jelajahi Kos Terverifikasi
                            </a>
                            <a href="{{ route('register') }}" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 13.5px; padding: 10px 22px; border-radius: var(--radius-buttons); text-decoration: none;">
                                <i class="fa fa-handshake mr-2"></i> Daftar Sebagai Pemilik
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="position-relative rounded overflow-hidden shadow-sm" style="border: var(--border-hairline); max-height: 330px;">
                            <img src="{{ asset('assets/img/tentang-hero.jpg') }}" alt="Komunitas Hunian TEMPATIN" class="img-fluid w-100" style="object-fit: cover; height: 310px; display: block;">
                            <div class="position-absolute" style="bottom: 12px; left: 12px; right: 12px; background: rgba(2, 9, 58, 0.88); backdrop-filter: blur(8px); padding: 10px 14px; border-radius: 8px; color: #ffffff; font-size: 12px; border: 1px solid rgba(255,255,255,0.15);">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span><i class="fa fa-shield-alt text-primary mr-1"></i> Standar Terverifikasi</span>
                                    <span class="font-weight-bold" style="color: #ffffff;">5.200+ Kamar Aktif</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- MISSION & STORY SECTION -->
        <section class="container mb-5">
            <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="d-inline-flex align-items-center mb-2 px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 700; letter-spacing: 0.05em;">
                            CERITA KAMI
                        </div>
                        <h2 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 16px; line-height: 1.3; letter-spacing: -0.02em;">
                            Mencari tempat tinggal tidak boleh serumit dan seberisiko itu.
                        </h2>
                        <p style="font-size: 14.5px; color: var(--color-charcoal); line-height: 1.7; margin-bottom: 14px;">
                            Bermula dari pengalaman sulitnya mencari kos yang sesuai deskripsi foto dan kekhawatiran transfer uang muka (DP) tanpa kepastian hukum, TEMPATIN hadir sebagai platform hunian kos modern berbasis transparansi total.
                        </p>
                        <p style="font-size: 14px; color: var(--color-stone); line-height: 1.7; margin-bottom: 24px;">
                            Kami merevolusi sistem booking konvensional menjadi serba terintegrasi: dari kurasi survei fisik, pemilihan nomor kamar spesifik, jadwal tagihan otomatis, hingga invoice resmi yang melindungi hak penyewa dan pemilik hunian.
                        </p>
                        <a href="{{ route('kos.index') }}" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13px; padding: 12px 24px; border-radius: var(--radius-buttons); text-decoration: none;">
                            <i class="fa fa-compass mr-2"></i> Mulai Cari Tempat Tinggal
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="p-4 rounded h-100" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width: 36px; height: 36px; border-radius: 8px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 16px;">
                                        <i class="fa fa-eye"></i>
                                    </div>
                                    <div class="font-weight-bold mb-1" style="color: var(--color-midnight-ink); font-size: 15px;">Transparansi Total</div>
                                    <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.55;">Nol mark-up harga sewa atau biaya tersembunyi tanpa persetujuan.</p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="p-4 rounded h-100" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width: 36px; height: 36px; border-radius: 8px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 16px;">
                                        <i class="fa fa-check-double"></i>
                                    </div>
                                    <div class="font-weight-bold mb-1" style="color: var(--color-midnight-ink); font-size: 15px;">Verifikasi Lapangan</div>
                                    <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.55;">Kamar dan fasilitas disurvei langsung oleh tim verifikator resmi.</p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class="p-4 rounded h-100" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width: 36px; height: 36px; border-radius: 8px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 16px;">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                    <div class="font-weight-bold mb-1" style="color: var(--color-midnight-ink); font-size: 15px;">Proteksi Escrow</div>
                                    <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.55;">Dana sewa tertahan aman hingga kunci kamar sukses diterima penyewa.</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-4 rounded h-100" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="d-inline-flex align-items-center justify-content-center mb-2" style="width: 36px; height: 36px; border-radius: 8px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 16px;">
                                        <i class="fa fa-heart"></i>
                                    </div>
                                    <div class="font-weight-bold mb-1" style="color: var(--color-midnight-ink); font-size: 15px;">Komunitas Sehat</div>
                                    <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.55;">Menciptakan lingkungan hunian yang saling menghargai privasi dan aman.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4-STEP HOW IT WORKS -->
        <section class="container mb-5">
            <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="text-center mb-5" style="max-width: 620px; margin: 0 auto;">
                    <div class="d-inline-flex align-items-center mb-2 px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 700; letter-spacing: 0.05em;">
                        CARA KERJA PLATFORM
                    </div>
                    <h2 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.02em;">
                        Empat Langkah Mudah Menemukan Kos Impian
                    </h2>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Dirancang tanpa ribet agar kamu fokus mempersiapkan kuliah dan karir barumu.
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
                        <div class="p-3 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px; font-weight: 700;">
                                1
                            </div>
                            <h4 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Pencarian Detail</h4>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.55;">Filter lokasi kampus, rentang budget bulanan, dan fasilitas penting.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
                        <div class="p-3 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px; font-weight: 700;">
                                2
                            </div>
                            <h4 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Cek Verifikasi</h4>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.55;">Lihat foto riil kamar, video tur, serta catatan survei independen.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
                        <div class="p-3 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px; font-weight: 700;">
                                3
                            </div>
                            <h4 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Booking &amp; Bayar Aman</h4>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.55;">Pesan kamar spesifik, gunakan voucher promo, dan bayar via escrow.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="p-3 text-center">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px; font-weight: 700;">
                                4
                            </div>
                            <h4 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Check-in Tenang</h4>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.55;">Terima kunci kamar, lakukan pengecekan fisik, dan tempati kamar barumu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TEAM SECTION -->
        <section class="container mb-5">
            <div class="text-center mb-5" style="max-width: 600px; margin: 0 auto;">
                <div class="d-inline-flex align-items-center mb-2 px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 700; letter-spacing: 0.05em;">
                    DEDIKASI KAMI
                </div>
                <h2 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink);">
                    Digerakkan oleh Tim yang Berpengalaman
                </h2>
                <p style="font-size: 14px; color: var(--color-stone);">
                    Para profesional yang berkomitmen memberikan standar kenyamanan kos terbaik di Indonesia.
                </p>
            </div>

            <div class="row">
                <!-- Person 1 -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded h-100 text-center" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <img src="{{ asset('assets/img/img-person-01.jpg') }}" alt="Rina Salsabila" class="rounded-circle mb-3" style="width: 92px; height: 92px; object-fit: cover; border: 3px solid var(--surface-page-canvas);">
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">Rina Salsabila</h3>
                        <span class="badge mb-3" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 4px;">FOUNDER &amp; CEO</span>
                        <p style="font-size: 13px; color: var(--color-stone); line-height: 1.6; margin-bottom: 0;">
                            Memimpin visi strategis TEMPATIN untuk mendigitalisasi industri kos tradisional di seluruh kota pendidikan di Indonesia.
                        </p>
                    </div>
                </div>

                <!-- Person 2 -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded h-100 text-center" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <img src="{{ asset('assets/img/img-person-02.jpg') }}" alt="Andi Prasetyo" class="rounded-circle mb-3" style="width: 92px; height: 92px; object-fit: cover; border: 3px solid var(--surface-page-canvas);">
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">Andi Prasetyo</h3>
                        <span class="badge mb-3" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 4px;">HEAD OF PARTNERSHIP</span>
                        <p style="font-size: 13px; color: var(--color-stone); line-height: 1.6; margin-bottom: 0;">
                            Membangun kemitraan strategis dengan pemilik kos dan paguyuban hunian guna menjaga standar fasilitas terverifikasi.
                        </p>
                    </div>
                </div>

                <!-- Person 3 -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded h-100 text-center" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <img src="{{ asset('assets/img/img-person-03.jpg') }}" alt="Fitri Anindya" class="rounded-circle mb-3" style="width: 92px; height: 92px; object-fit: cover; border: 3px solid var(--surface-page-canvas);">
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">Fitri Anindya</h3>
                        <span class="badge mb-3" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 4px;">HEAD OF CUSTOMER CARE</span>
                        <p style="font-size: 13px; color: var(--color-stone); line-height: 1.6; margin-bottom: 0;">
                            Memastikan setiap penyewa kos mendapatkan pendampingan ramah, cepat, dan solutif selama masa tinggal.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- IMPACT METRICS -->
        <section class="container mb-5">
            <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline);">
                <div class="row text-center">
                    <div class="col-md-3 col-6 py-2 border-right" style="border-color: rgba(0,0,0,0.06) !important;">
                        <div style="font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink);">5.200+</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 600;">Kos Terverifikasi</div>
                    </div>
                    <div class="col-md-3 col-6 py-2 border-right-md" style="border-color: rgba(0,0,0,0.06) !important;">
                        <div style="font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink);">120+</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 600;">Kota &amp; Kabupaten</div>
                    </div>
                    <div class="col-md-3 col-6 py-2 border-right" style="border-color: rgba(0,0,0,0.06) !important;">
                        <div style="font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink);">38.000+</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 600;">Penghuni Aktif</div>
                    </div>
                    <div class="col-md-3 col-6 py-2">
                        <div style="font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink);">99.4%</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 600;">Tingkat Kepuasan</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- UNIVERSITY PARTNERS WALL -->
        <section class="container mb-5">
            <div class="p-4 p-md-5 rounded text-center" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div style="font-size: 12px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.08em; color: var(--color-stone); margin-bottom: 24px;">
                    DIPERCAYA MAHASISWA &amp; DOSEN DARI KAMPUS TERKEMUKA
                </div>
                <div class="notion-partner-wall d-flex flex-wrap justify-content-center align-items-center">
                    <span class="partner-item">Universitas Indonesia</span>
                    <span class="partner-item">Institut Teknologi Bandung</span>
                    <span class="partner-item">Universitas Gadjah Mada</span>
                    <span class="partner-item">Institut Teknologi Sepuluh Nopember</span>
                    <span class="partner-item">Universitas Airlangga</span>
                    <span class="partner-item">Universitas Brawijaya</span>
                </div>
            </div>
        </section>

        <!-- DUAL BOTTOM CTA -->
        <section class="container">
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="p-4 p-md-5 rounded h-100 d-flex flex-column justify-content-between" style="background: var(--color-midnight-ink); color: #ffffff; border-radius: var(--radius-cards);">
                        <div>
                            <span class="badge mb-2 px-2 py-1" style="background: rgba(255,255,255,0.15); color: #ffffff; font-size: 11px;">PENCARI KOS</span>
                            <h3 style="font-family: var(--font-serif); font-size: 1.55rem; font-weight: 700; margin-bottom: 8px;">Cari Kos Sesuai Kebutuhan</h3>
                            <p style="color: rgba(255,255,255,0.75); font-size: 14px; margin-bottom: 20px;">Temukan kamar kos dengan fasilitas lengkap dan lokasi terdekat dari tempat aktivitasmu.</p>
                        </div>
                        <div>
                            <a href="{{ route('kos.index') }}" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13.5px; padding: 10px 20px; border-radius: var(--radius-buttons); text-decoration: none;">
                                <i class="fa fa-search mr-2"></i> Jelajahi Direktori Kos
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 p-md-5 rounded h-100 d-flex flex-column justify-content-between" style="background: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div>
                            <span class="badge mb-2 px-2 py-1" style="background: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 700;">PEMILIK PROPERTI</span>
                            <h3 style="font-family: var(--font-serif); font-size: 1.55rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Daftarkan Properti Kos Anda</h3>
                            <p style="color: var(--color-stone); font-size: 14px; margin-bottom: 20px;">Dapatkan okupansi kamar maksimal, sistem penagihan otomatis, dan calon penyewa terverifikasi.</p>
                        </div>
                        <div>
                            <a href="{{ route('register') }}" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13.5px; padding: 10px 20px; border-radius: var(--radius-buttons); text-decoration: none;">
                                <i class="fa fa-handshake mr-2"></i> Gabung Sebagai Mitra
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
