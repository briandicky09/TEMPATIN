@extends('layouts.app')

@section('title', 'Tentang TEMPATIN - Visi & Cerita Kami')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 100px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Tentang Kami</li>
                </ol>
            </nav>
        </div>

        <!-- HERO HEADER -->
        <section class="container mb-5">
            <div style="max-width: 820px;">
                <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill" style="background-color: var(--surface-card); border: var(--border-hairline); font-size: 13px; font-weight: 600; color: var(--color-ink-black);">
                    <i class="fa fa-compass mr-2" style="color: var(--color-stone);"></i> Mengenal TEMPATIN
                </div>
                <h1 style="font-family: var(--font-serif); font-size: clamp(2rem, 3.5vw, 2.85rem); font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.02em; line-height: 1.25;" class="mb-3">
                    Mendefinisikan Ulang Pengalaman Mencari Kos di Indonesia.
                </h1>
                <p style="font-size: 16px; color: var(--color-stone); line-height: 1.6; margin-bottom: 0;">
                    Kami membangun jembatan terpercaya antara mahasiswa, profesional muda, dan pemilik properti kos melalui transparansi data, kemudahan verifikasi, dan transaksi digital yang aman.
                </p>
            </div>
        </section>

        <!-- MISSION & STORY -->
        <section class="container mb-5">
            <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <span class="badge mb-2 px-2 py-1" style="background-color: var(--color-paper-warmth); color: var(--color-stone); border: 1px solid rgba(0,0,0,0.08); font-size: 11px;">CERITA KAMI</span>
                        <h2 style="font-family: var(--font-serif); font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 16px; line-height: 1.3;">
                            Mencari tempat tinggal tidak boleh serumit itu.
                        </h2>
                        <p style="font-size: 14px; color: var(--color-charcoal); line-height: 1.7; margin-bottom: 14px;">
                            Bermula dari pengalaman sulitnya mencari kos yang sesuai deskripsi foto dan kekhawatiran transfer uang sewa tanpa kepastian, TEMPATIN hadir sebagai platform hunian kos modern berbasis transparansi total.
                        </p>
                        <p style="font-size: 14px; color: var(--color-stone); line-height: 1.7; margin-bottom: 24px;">
                            Kami merevolusi sistem booking konvensional menjadi serba terintegrasi: dari survei virtual 360°, pemilihan nomor kamar spesifik, jadwal tagihan otomatis, hingga invoice resmi yang berkekuatan hukum.
                        </p>
                        <a href="{{ route('register') }}" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13px; padding: 12px 24px; border-radius: var(--radius-buttons); border: none;">
                            <i class="fa fa-handshake mr-2"></i> Gabung Jadi Mitra Pemilik
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <div class="p-4 rounded h-100" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="font-weight-bold mb-2" style="color: var(--color-midnight-ink); font-size: 15px;"><i class="fa fa-eye mr-2" style="color: var(--color-charcoal);"></i> Transparansi</div>
                                    <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.5;">Tidak ada mark-up harga sewa atau biaya admin siluman.</p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <div class="p-4 rounded h-100" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="font-weight-bold mb-2" style="color: var(--color-midnight-ink); font-size: 15px;"><i class="fa fa-check-double mr-2" style="color: var(--color-charcoal);"></i> Verifikasi Fisik</div>
                                    <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.5;">Setiap kamar melalui kurasi lapangan ketat.</p>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <div class="p-4 rounded h-100" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="font-weight-bold mb-2" style="color: var(--color-midnight-ink); font-size: 15px;"><i class="fa fa-lock mr-2" style="color: var(--color-charcoal);"></i> Keamanan Finansial</div>
                                    <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.5;">Dana tertahan aman hingga kunci kamar diterima.</p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-4 rounded h-100" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                                    <div class="font-weight-bold mb-2" style="color: var(--color-midnight-ink); font-size: 15px;"><i class="fa fa-heart mr-2" style="color: var(--color-charcoal);"></i> Komunitas Sehat</div>
                                    <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.5;">Menciptakan lingkungan hunian yang saling menghormati.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- TEAM SECTION -->
        <section class="container mb-5">
            <div class="text-center mb-5" style="max-width: 600px; margin: 0 auto;">
                <span class="badge mb-2 px-2 py-1" style="background-color: var(--color-paper-warmth); color: var(--color-stone); border: 1px solid rgba(0,0,0,0.08); font-size: 11px;">ORANG DI BALIK TEMPATIN</span>
                <h2 style="font-family: var(--font-serif); font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink);">
                    Digerakkan oleh Tim yang Berdedikasi
                </h2>
                <p style="font-size: 14px; color: var(--color-stone);">
                    Para profesional yang berkomitmen memberikan standar kenyamanan kos terbaik di Indonesia.
                </p>
            </div>

            <div class="row">
                <!-- Person 1 -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded h-100 text-center" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <img src="{{ asset('assets/img/img-person-01.jpg') }}" alt="Rina Salsabila" class="rounded-circle mb-3" style="width: 88px; height: 88px; object-fit: cover; border: 2px solid var(--surface-page-canvas);">
                        <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">Rina Salsabila</h3>
                        <span class="badge mb-3" style="background-color: var(--color-paper-warmth); color: var(--color-charcoal); border: 1px solid rgba(0,0,0,0.08); font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 4px;">FOUNDER & CEO</span>
                        <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 0;">
                            Memimpin visi strategis TEMPATIN untuk mendigitalisasi industri kos tradisional di seluruh kota pendidikan di Indonesia.
                        </p>
                    </div>
                </div>

                <!-- Person 2 -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded h-100 text-center" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <img src="{{ asset('assets/img/img-person-02.jpg') }}" alt="Andi Prasetyo" class="rounded-circle mb-3" style="width: 88px; height: 88px; object-fit: cover; border: 2px solid var(--surface-page-canvas);">
                        <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">Andi Prasetyo</h3>
                        <span class="badge mb-3" style="background-color: var(--color-paper-warmth); color: var(--color-charcoal); border: 1px solid rgba(0,0,0,0.08); font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 4px;">HEAD OF PARTNERSHIP</span>
                        <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 0;">
                            Membangun kemitraan strategis dengan pemilik kos dan paguyuban hunian guna menjaga standar fasilitas terverifikasi.
                        </p>
                    </div>
                </div>

                <!-- Person 3 -->
                <div class="col-md-4 mb-4">
                    <div class="p-4 rounded h-100 text-center" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <img src="{{ asset('assets/img/img-person-03.jpg') }}" alt="Fitri Anindya" class="rounded-circle mb-3" style="width: 88px; height: 88px; object-fit: cover; border: 2px solid var(--surface-page-canvas);">
                        <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">Fitri Anindya</h3>
                        <span class="badge mb-3" style="background-color: var(--color-paper-warmth); color: var(--color-charcoal); border: 1px solid rgba(0,0,0,0.08); font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 4px;">HEAD OF CUSTOMER CARE</span>
                        <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 0;">
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
                        <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink);">5.200+</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500;">Kos Terverifikasi</div>
                    </div>
                    <div class="col-md-3 col-6 py-2 border-right-md" style="border-color: rgba(0,0,0,0.06) !important;">
                        <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink);">120+</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500;">Kota & Kabupaten</div>
                    </div>
                    <div class="col-md-3 col-6 py-2 border-right" style="border-color: rgba(0,0,0,0.06) !important;">
                        <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink);">38.000+</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500;">Penghuni Bahagia</div>
                    </div>
                    <div class="col-md-3 col-6 py-2">
                        <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink);">99.4%</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500;">Tingkat Kepuasan</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- UNIVERSITY PARTNERS WALL -->
        <section class="container">
            <div class="p-4 p-md-5 rounded text-center" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div style="font-size: 12px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.08em; color: var(--color-stone); margin-bottom: 24px;">
                    DIPERCAYA MAHASISWA & DOSEN DARI KAMPUS TERKEMUKA
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

    </main>

    @include('partials.footer')

</div>
@endsection
