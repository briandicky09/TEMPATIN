@extends('layouts.app')

@section('title', 'Promo & Voucher Hemat Kos - TEMPATIN')

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
                        Promo &amp; Voucher
                    </li>
                </ol>
            </nav>
        </div>

        <!-- HERO HEADER WITH REAL BANNER IMAGE -->
        <section class="container mb-5">
            <div class="p-4 p-md-5 rounded overflow-hidden position-relative" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); border: 1px solid rgba(0, 117, 222, 0.2); font-size: 12px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.04em;">
                            <i class="fa fa-percent mr-2"></i> PENAWARAN KHUSUS &amp; VOUCHER TERVERIFIKASI
                        </div>
                        <h1 style="font-family: var(--font-serif); font-size: clamp(2rem, 3.6vw, 2.75rem); font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.025em; line-height: 1.25;" class="mb-3">
                            Hemat Lebih Banyak untuk Hunian Kos Impianmu.
                        </h1>
                        <p style="font-size: 15.5px; color: var(--color-stone); line-height: 1.65; margin-bottom: 24px; max-width: 620px;">
                            Gunakan kode voucher eksklusif TEMPATIN, nikmati potongan sewa bulanan hingga Rp 500.000, serta dapatkan jaminan bebas biaya administrasi untuk kos terverifikasi.
                        </p>
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <a href="#daftar-promo" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13.5px; padding: 10px 22px; border-radius: var(--radius-buttons); text-decoration: none;">
                                <i class="fa fa-tag mr-2"></i> Lihat Semua Voucher
                            </a>
                            <a href="{{ route('kos.index') }}" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 13.5px; padding: 10px 22px; border-radius: var(--radius-buttons); text-decoration: none;">
                                <i class="fa fa-search mr-2"></i> Cari Kos Sesuai Promo
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="position-relative rounded overflow-hidden shadow-sm" style="border: var(--border-hairline); max-height: 320px;">
                            <img src="{{ asset('assets/img/promo-hero.jpg') }}" alt="Promo Hunian Kos TEMPATIN" class="img-fluid w-100" style="object-fit: cover; height: 300px; display: block;">
                            <div class="position-absolute" style="bottom: 12px; left: 12px; right: 12px; background: rgba(2, 9, 58, 0.88); backdrop-filter: blur(8px); padding: 10px 14px; border-radius: 8px; color: #ffffff; font-size: 12px; border: 1px solid rgba(255,255,255,0.15);">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span><i class="fa fa-check-circle text-primary mr-1"></i> Garansi Resmi TEMPATIN</span>
                                    <span class="font-weight-bold" style="color: #ffffff;">Update Setiap Bulan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- PROMO FILTER TABS -->
        <section class="container mb-4" id="daftar-promo">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 pb-3" style="border-bottom: var(--border-hairline);">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-promo-filter active font-weight-bold px-3 py-2 mr-2 mb-2" data-filter="all" style="border-radius: 9999px; font-size: 13px; border: 1px solid rgba(0,0,0,0.12); background-color: var(--color-notion-blue); color: #ffffff;">
                        Semua Promo (6)
                    </button>
                    <button type="button" class="btn btn-sm btn-promo-filter font-weight-bold px-3 py-2 mr-2 mb-2" data-filter="penghuni-baru" style="border-radius: 9999px; font-size: 13px; border: 1px solid rgba(0,0,0,0.12); background-color: #ffffff; color: var(--color-charcoal);">
                        Penghuni Baru (2)
                    </button>
                    <button type="button" class="btn btn-sm btn-promo-filter font-weight-bold px-3 py-2 mr-2 mb-2" data-filter="sewa-panjang" style="border-radius: 9999px; font-size: 13px; border: 1px solid rgba(0,0,0,0.12); background-color: #ffffff; color: var(--color-charcoal);">
                        Sewa Panjang (2)
                    </button>
                    <button type="button" class="btn btn-sm btn-promo-filter font-weight-bold px-3 py-2 mr-2 mb-2" data-filter="bebas-admin" style="border-radius: 9999px; font-size: 13px; border: 1px solid rgba(0,0,0,0.12); background-color: #ffffff; color: var(--color-charcoal);">
                        Bebas Biaya Admin (2)
                    </button>
                </div>
                <div style="min-width: 240px;">
                    <div class="input-group input-group-sm">
                        <input type="text" id="promoSearchInput" class="form-control" placeholder="Cari kode atau promo..." style="border-radius: 6px 0 0 6px; font-size: 13px; height: 36px; border: var(--border-hairline);">
                        <div class="input-group-append">
                            <span class="input-group-text bg-white" style="border-radius: 0 6px 6px 0; border: var(--border-hairline); border-left: none;">
                                <i class="fa fa-search text-muted"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- VOUCHER CARDS GRID -->
        <section class="container mb-5">
            <div class="row" id="promoCardsGrid">

                <!-- Promo 1: KOSBARU20 -->
                <div class="col-lg-4 col-md-6 mb-4 promo-card-item" data-category="penghuni-baru" data-code="KOSBARU20">
                    <div class="notion-card h-100 d-flex flex-column justify-content-between overflow-hidden" style="background: #ffffff; border-radius: var(--radius-cards); border: var(--border-hairline);">
                        <div>
                            <div class="position-relative overflow-hidden" style="height: 160px; background-color: var(--surface-page-canvas);">
                                <img src="{{ asset('assets/img/kos-anggrek.jpg') }}" alt="Diskon Penghuni Baru" class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute" style="top: 12px; left: 12px;">
                                    <span class="badge" style="background-color: #ffffff; color: var(--color-notion-blue); font-weight: 700; font-size: 11px; padding: 5px 10px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">PENGHUNI BARU</span>
                                </div>
                                <div class="position-absolute" style="top: 12px; right: 12px;">
                                    <span class="badge" style="background-color: rgba(2, 9, 58, 0.85); color: #ffffff; font-weight: 500; font-size: 11px; padding: 5px 8px; border-radius: 6px;"><i class="fa fa-clock mr-1"></i> s/d 31 Des 2026</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex align-items-baseline mb-2">
                                    <span style="font-size: 1.5rem; font-weight: 800; color: var(--color-notion-blue); letter-spacing: -0.02em;">Diskon 20%</span>
                                    <span class="ml-2 text-muted small">Maksimal Rp 300.000</span>
                                </div>
                                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Potongan Sewa Bulan Pertama</h3>
                                <p style="font-size: 13px; color: var(--color-stone); line-height: 1.55; margin-bottom: 16px;">
                                    Berlaku khusus pengguna pertama TEMPATIN dengan minimum sewa 1 bulan di seluruh kos terverifikasi.
                                </p>
                                <ul class="list-unstyled mb-0" style="font-size: 12px; color: var(--color-stone); line-height: 1.6;">
                                    <li><i class="fa fa-check text-primary mr-1"></i> Minimum transaksi Rp 800.000</li>
                                    <li><i class="fa fa-check text-primary mr-1"></i> Berlaku 1x per akun terverifikasi</li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <div class="pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded mb-2" style="background-color: var(--surface-page-canvas); border: 1px dashed rgba(0, 117, 222, 0.4);">
                                    <code style="font-size: 14px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.06em;">KOSBARU20</code>
                                    <button type="button" class="btn btn-sm copy-btn" data-code="KOSBARU20" style="font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 4px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: none;">
                                        <i class="fa fa-copy mr-1"></i> Salin Kode
                                    </button>
                                </div>
                                <a href="{{ route('kos.index') }}" class="btn btn-block btn-sm" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 12.5px; padding: 8px 12px; border-radius: var(--radius-buttons); text-decoration: none;">
                                    Gunakan Voucher &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promo 2: FREEADMIN -->
                <div class="col-lg-4 col-md-6 mb-4 promo-card-item" data-category="bebas-admin" data-code="FREEADMIN">
                    <div class="notion-card h-100 d-flex flex-column justify-content-between overflow-hidden" style="background: #ffffff; border-radius: var(--radius-cards); border: var(--border-hairline);">
                        <div>
                            <div class="position-relative overflow-hidden" style="height: 160px; background-color: var(--surface-page-canvas);">
                                <img src="{{ asset('assets/img/kos-mawar.webp') }}" alt="Bebas Biaya Administrasi" class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute" style="top: 12px; left: 12px;">
                                    <span class="badge" style="background-color: #ffffff; color: var(--color-notion-blue); font-weight: 700; font-size: 11px; padding: 5px 10px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">BEBAS ADMIN</span>
                                </div>
                                <div class="position-absolute" style="top: 12px; right: 12px;">
                                    <span class="badge" style="background-color: rgba(2, 9, 58, 0.85); color: #ffffff; font-weight: 500; font-size: 11px; padding: 5px 8px; border-radius: 6px;"><i class="fa fa-bolt mr-1"></i> Kuota Harian</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex align-items-baseline mb-2">
                                    <span style="font-size: 1.5rem; font-weight: 800; color: var(--color-notion-blue); letter-spacing: -0.02em;">Rp 0 Biaya Admin</span>
                                </div>
                                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Gratis Administrasi Platform</h3>
                                <p style="font-size: 13px; color: var(--color-stone); line-height: 1.55; margin-bottom: 16px;">
                                    Bebas biaya pemrosesan platform tanpa minimum transaksi untuk seluruh metode pembayaran digital resmi.
                                </p>
                                <ul class="list-unstyled mb-0" style="font-size: 12px; color: var(--color-stone); line-height: 1.6;">
                                    <li><i class="fa fa-check text-primary mr-1"></i> Tanpa batas minimum nominal sewa</li>
                                    <li><i class="fa fa-check text-primary mr-1"></i> Mendukung Virtual Account &amp; QRIS</li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <div class="pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded mb-2" style="background-color: var(--surface-page-canvas); border: 1px dashed rgba(0, 117, 222, 0.4);">
                                    <code style="font-size: 14px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.06em;">FREEADMIN</code>
                                    <button type="button" class="btn btn-sm copy-btn" data-code="FREEADMIN" style="font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 4px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: none;">
                                        <i class="fa fa-copy mr-1"></i> Salin Kode
                                    </button>
                                </div>
                                <a href="{{ route('kos.index') }}" class="btn btn-block btn-sm" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 12.5px; padding: 8px 12px; border-radius: var(--radius-buttons); text-decoration: none;">
                                    Gunakan Voucher &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promo 3: SEMESTERAN500 -->
                <div class="col-lg-4 col-md-6 mb-4 promo-card-item" data-category="sewa-panjang" data-code="SEMESTERAN500">
                    <div class="notion-card h-100 d-flex flex-column justify-content-between overflow-hidden" style="background: #ffffff; border-radius: var(--radius-cards); border: var(--border-hairline);">
                        <div>
                            <div class="position-relative overflow-hidden" style="height: 160px; background-color: var(--surface-page-canvas);">
                                <img src="{{ asset('assets/img/kos-melati.png') }}" alt="Cashback Sewa Semesteran" class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute" style="top: 12px; left: 12px;">
                                    <span class="badge" style="background-color: #ffffff; color: var(--color-notion-blue); font-weight: 700; font-size: 11px; padding: 5px 10px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">SEWA PANJANG</span>
                                </div>
                                <div class="position-absolute" style="top: 12px; right: 12px;">
                                    <span class="badge" style="background-color: rgba(2, 9, 58, 0.85); color: #ffffff; font-weight: 500; font-size: 11px; padding: 5px 8px; border-radius: 6px;"><i class="fa fa-calendar mr-1"></i> Min. 6 Bulan</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex align-items-baseline mb-2">
                                    <span style="font-size: 1.5rem; font-weight: 800; color: var(--color-notion-blue); letter-spacing: -0.02em;">Rp 500.000</span>
                                    <span class="ml-2 text-muted small">Cashback Saldo</span>
                                </div>
                                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Cashback Sewa Semesteran</h3>
                                <p style="font-size: 13px; color: var(--color-stone); line-height: 1.55; margin-bottom: 16px;">
                                    Pesan langsung durasi 6 atau 12 bulan dan dapatkan saldo e-wallet terkirim otomatis setelah konfirmasi check-in.
                                </p>
                                <ul class="list-unstyled mb-0" style="font-size: 12px; color: var(--color-stone); line-height: 1.6;">
                                    <li><i class="fa fa-check text-primary mr-1"></i> Berlaku perpanjangan atau sewa baru</li>
                                    <li><i class="fa fa-check text-primary mr-1"></i> Cair maksimal 2x24 jam pasca check-in</li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <div class="pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded mb-2" style="background-color: var(--surface-page-canvas); border: 1px dashed rgba(0, 117, 222, 0.4);">
                                    <code style="font-size: 14px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.06em;">SEMESTERAN500</code>
                                    <button type="button" class="btn btn-sm copy-btn" data-code="SEMESTERAN500" style="font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 4px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: none;">
                                        <i class="fa fa-copy mr-1"></i> Salin Kode
                                    </button>
                                </div>
                                <a href="{{ route('kos.index') }}" class="btn btn-block btn-sm" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 12.5px; padding: 8px 12px; border-radius: var(--radius-buttons); text-decoration: none;">
                                    Gunakan Voucher &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promo 4: KAMPUSHEMAT -->
                <div class="col-lg-4 col-md-6 mb-4 promo-card-item" data-category="penghuni-baru" data-code="KAMPUSHEMAT">
                    <div class="notion-card h-100 d-flex flex-column justify-content-between overflow-hidden" style="background: #ffffff; border-radius: var(--radius-cards); border: var(--border-hairline);">
                        <div>
                            <div class="position-relative overflow-hidden" style="height: 160px; background-color: var(--surface-page-canvas);">
                                <img src="{{ asset('assets/img/banner-kos.jpg') }}" alt="Subsidi Mahasiswa" class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute" style="top: 12px; left: 12px;">
                                    <span class="badge" style="background-color: #ffffff; color: var(--color-notion-blue); font-weight: 700; font-size: 11px; padding: 5px 10px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">PENGHUNI BARU</span>
                                </div>
                                <div class="position-absolute" style="top: 12px; right: 12px;">
                                    <span class="badge" style="background-color: rgba(2, 9, 58, 0.85); color: #ffffff; font-weight: 500; font-size: 11px; padding: 5px 8px; border-radius: 6px;"><i class="fa fa-graduation-cap mr-1"></i> Khusus Mahasiswa</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex align-items-baseline mb-2">
                                    <span style="font-size: 1.5rem; font-weight: 800; color: var(--color-notion-blue); letter-spacing: -0.02em;">Diskon Rp 150.000</span>
                                </div>
                                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Subsidi Mahasiswa Baru</h3>
                                <p style="font-size: 13px; color: var(--color-stone); line-height: 1.55; margin-bottom: 16px;">
                                    Dukungan adaptasi tempat tinggal bagi mahasiswa di sekitar area kampus mitra terdaftar TEMPATIN.
                                </p>
                                <ul class="list-unstyled mb-0" style="font-size: 12px; color: var(--color-stone); line-height: 1.6;">
                                    <li><i class="fa fa-check text-primary mr-1"></i> Masukkan nomor kartu tanda mahasiswa (KTM)</li>
                                    <li><i class="fa fa-check text-primary mr-1"></i> Berlaku di seluruh kos radius kampus</li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <div class="pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded mb-2" style="background-color: var(--surface-page-canvas); border: 1px dashed rgba(0, 117, 222, 0.4);">
                                    <code style="font-size: 14px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.06em;">KAMPUSHEMAT</code>
                                    <button type="button" class="btn btn-sm copy-btn" data-code="KAMPUSHEMAT" style="font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 4px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: none;">
                                        <i class="fa fa-copy mr-1"></i> Salin Kode
                                    </button>
                                </div>
                                <a href="{{ route('kos.index') }}" class="btn btn-block btn-sm" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 12.5px; padding: 8px 12px; border-radius: var(--radius-buttons); text-decoration: none;">
                                    Gunakan Voucher &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promo 5: TAHUNANPLUS -->
                <div class="col-lg-4 col-md-6 mb-4 promo-card-item" data-category="sewa-panjang" data-code="TAHUNANPLUS">
                    <div class="notion-card h-100 d-flex flex-column justify-content-between overflow-hidden" style="background: #ffffff; border-radius: var(--radius-cards); border: var(--border-hairline);">
                        <div>
                            <div class="position-relative overflow-hidden" style="height: 160px; background-color: var(--surface-page-canvas);">
                                <img src="{{ asset('assets/img/artikel-survey.jpg') }}" alt="Promo Sewa Tahunan" class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute" style="top: 12px; left: 12px;">
                                    <span class="badge" style="background-color: #ffffff; color: var(--color-notion-blue); font-weight: 700; font-size: 11px; padding: 5px 10px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">SEWA PANJANG</span>
                                </div>
                                <div class="position-absolute" style="top: 12px; right: 12px;">
                                    <span class="badge" style="background-color: rgba(2, 9, 58, 0.85); color: #ffffff; font-weight: 500; font-size: 11px; padding: 5px 8px; border-radius: 6px;"><i class="fa fa-crown mr-1"></i> Superhost</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex align-items-baseline mb-2">
                                    <span style="font-size: 1.5rem; font-weight: 800; color: var(--color-notion-blue); letter-spacing: -0.02em;">Gratis 1 Bulan</span>
                                    <span class="ml-2 text-muted small">Sewa 12 Bulan</span>
                                </div>
                                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Paket Sewa Tahunan Super</h3>
                                <p style="font-size: 13px; color: var(--color-stone); line-height: 1.55; margin-bottom: 16px;">
                                    Bayar kontrak tahunan dan nikmati potongan setara sewa 1 bulan penuh di kos bertanda Mitra Prioritas.
                                </p>
                                <ul class="list-unstyled mb-0" style="font-size: 12px; color: var(--color-stone); line-height: 1.6;">
                                    <li><i class="fa fa-check text-primary mr-1"></i> Termasuk garansi pemeliharaan fasilitas kamar</li>
                                    <li><i class="fa fa-check text-primary mr-1"></i> Cicilan 0% tersedia via mitra perbankan</li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <div class="pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded mb-2" style="background-color: var(--surface-page-canvas); border: 1px dashed rgba(0, 117, 222, 0.4);">
                                    <code style="font-size: 14px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.06em;">TAHUNANPLUS</code>
                                    <button type="button" class="btn btn-sm copy-btn" data-code="TAHUNANPLUS" style="font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 4px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: none;">
                                        <i class="fa fa-copy mr-1"></i> Salin Kode
                                    </button>
                                </div>
                                <a href="{{ route('kos.index') }}" class="btn btn-block btn-sm" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 12.5px; padding: 8px 12px; border-radius: var(--radius-buttons); text-decoration: none;">
                                    Gunakan Voucher &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Promo 6: DIGITALPAY -->
                <div class="col-lg-4 col-md-6 mb-4 promo-card-item" data-category="bebas-admin" data-code="DIGITALPAY">
                    <div class="notion-card h-100 d-flex flex-column justify-content-between overflow-hidden" style="background: #ffffff; border-radius: var(--radius-cards); border: var(--border-hairline);">
                        <div>
                            <div class="position-relative overflow-hidden" style="height: 160px; background-color: var(--surface-page-canvas);">
                                <img src="{{ asset('assets/img/artikel-budget.jpg') }}" alt="Cashback Digital Pay" class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute" style="top: 12px; left: 12px;">
                                    <span class="badge" style="background-color: #ffffff; color: var(--color-notion-blue); font-weight: 700; font-size: 11px; padding: 5px 10px; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">BEBAS ADMIN</span>
                                </div>
                                <div class="position-absolute" style="top: 12px; right: 12px;">
                                    <span class="badge" style="background-color: rgba(2, 9, 58, 0.85); color: #ffffff; font-weight: 500; font-size: 11px; padding: 5px 8px; border-radius: 6px;"><i class="fa fa-qrcode mr-1"></i> QRIS &amp; VA</span>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="d-flex align-items-baseline mb-2">
                                    <span style="font-size: 1.5rem; font-weight: 800; color: var(--color-notion-blue); letter-spacing: -0.02em;">Diskon Rp 50.000</span>
                                </div>
                                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Potongan Pembayaran Digital</h3>
                                <p style="font-size: 13px; color: var(--color-stone); line-height: 1.55; margin-bottom: 16px;">
                                    Nikmati potongan instan untuk pelunasan tagihan sewa menggunakan Virtual Account BCA, Mandiri, BRI, atau QRIS.
                                </p>
                                <ul class="list-unstyled mb-0" style="font-size: 12px; color: var(--color-stone); line-height: 1.6;">
                                    <li><i class="fa fa-check text-primary mr-1"></i> Tanpa kuota, aktif setiap hari kerja</li>
                                    <li><i class="fa fa-check text-primary mr-1"></i> Otomatis terverifikasi sistem dalam hitungan detik</li>
                                </ul>
                            </div>
                        </div>
                        <div class="p-4 pt-0">
                            <div class="pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                                <div class="d-flex align-items-center justify-content-between p-2 rounded mb-2" style="background-color: var(--surface-page-canvas); border: 1px dashed rgba(0, 117, 222, 0.4);">
                                    <code style="font-size: 14px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.06em;">DIGITALPAY</code>
                                    <button type="button" class="btn btn-sm copy-btn" data-code="DIGITALPAY" style="font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 4px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: none;">
                                        <i class="fa fa-copy mr-1"></i> Salin Kode
                                    </button>
                                </div>
                                <a href="{{ route('kos.index') }}" class="btn btn-block btn-sm" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 12.5px; padding: 8px 12px; border-radius: var(--radius-buttons); text-decoration: none;">
                                    Gunakan Voucher &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- EMPTY STATE -->
            <div id="promoEmptyState" class="p-5 text-center rounded d-none" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 22px;">
                    <i class="fa fa-ticket-alt"></i>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Voucher Tidak Ditemukan</h3>
                <p style="font-size: 14px; color: var(--color-stone); max-width: 440px; margin: 0 auto 20px;">
                    Tidak ada kode voucher atau promo yang cocok dengan pencarianmu. Coba ubah kata kunci atau reset filter.
                </p>
                <button type="button" id="btnResetFilter" class="btn btn-sm" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; padding: 8px 18px; border-radius: var(--radius-buttons);">
                    Reset Semua Filter
                </button>
            </div>
        </section>

        <!-- 3-STEP GUIDE: CARA PAKAI VOUCHER -->
        <section class="container mb-5">
            <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="text-center mb-5" style="max-width: 640px; margin: 0 auto;">
                    <div class="d-inline-flex align-items-center mb-2 px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 700; letter-spacing: 0.05em;">
                        PANDUAN PRAKTIS
                    </div>
                    <h2 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.02em;">
                        Cara Menggunakan Voucher di TEMPATIN
                    </h2>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Tiga langkah mudah untuk klaim potongan biaya sewa saat proses reservasi online.
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="p-4 rounded h-100" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 38px; height: 38px; border-radius: 8px; background-color: var(--color-notion-blue); color: #ffffff; font-weight: 700; font-size: 14px;">
                                1
                            </div>
                            <h4 style="font-size: 16px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Pilih Kos &amp; Kamar</h4>
                            <p style="font-size: 13.5px; color: var(--color-stone); line-height: 1.6; margin-bottom: 0;">
                                Temukan kos idaman di direktori TEMPATIN, cek ketersediaan kamar, lalu klik tombol booking untuk melanjutkan ke rincian reservasi.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="p-4 rounded h-100" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 38px; height: 38px; border-radius: 8px; background-color: var(--color-notion-blue); color: #ffffff; font-weight: 700; font-size: 14px;">
                                2
                            </div>
                            <h4 style="font-size: 16px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Masukkan Kode Promo</h4>
                            <p style="font-size: 13.5px; color: var(--color-stone); line-height: 1.6; margin-bottom: 0;">
                                Salin salah satu kode voucher di atas, lalu tempel pada kolom voucher di halaman konfirmasi invoice pemesanan.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded h-100" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 38px; height: 38px; border-radius: 8px; background-color: var(--color-notion-blue); color: #ffffff; font-weight: 700; font-size: 14px;">
                                3
                            </div>
                            <h4 style="font-size: 16px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Potongan Langsung Aktif</h4>
                            <p style="font-size: 13.5px; color: var(--color-stone); line-height: 1.6; margin-bottom: 0;">
                                Total biaya sewa akan otomatis berkurang sesuai nominal promo. Bayar aman via sistem penampungan escrow TEMPATIN.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- VALUE PILLARS (NOTION 4-COLUMN CARDS) -->
        <section class="container mb-5">
            <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="text-center mb-5" style="max-width: 600px; margin: 0 auto;">
                    <h2 style="font-family: var(--font-serif); font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink);">
                        Keuntungan Booking Promo di TEMPATIN
                    </h2>
                    <p style="font-size: 14px; color: var(--color-stone);">
                        Semua promo transparan, tanpa biaya tersembunyi, dan berlaku di kos terverifikasi.
                    </p>
                </div>
                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-4 mb-md-0">
                        <div class="p-3">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 8px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 1.25rem;">
                                <i class="fa fa-shield-alt"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">100% Terverifikasi</h4>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0;">Fasilitas dan kamar disurvei langsung oleh tim surveior TEMPATIN.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4 mb-md-0">
                        <div class="p-3">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 8px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 1.25rem;">
                                <i class="fa fa-tag"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Garansi Tarif Resmi</h4>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0;">Tarif sama atau lebih hemat tanpa mark-up sepihak dari pemilik.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4 mb-md-0">
                        <div class="p-3">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 8px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 1.25rem;">
                                <i class="fa fa-lock"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Proteksi Escrow</h4>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0;">Uang sewa tertampung aman hingga kamu sukses serah terima kunci.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4 mb-md-0">
                        <div class="p-3">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 8px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 1.25rem;">
                                <i class="fa fa-headset"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Pendampingan 24/7</h4>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0;">Tim operasional sigap mendampingi proses booking hingga masuk kamar.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA TO LISTING -->
        <section class="container mb-5">
            <div class="p-4 p-md-5 rounded d-flex flex-column flex-md-row align-items-md-center justify-content-between" style="background: var(--color-midnight-ink); color: #ffffff; border-radius: var(--radius-cards);">
                <div class="mb-4 mb-md-0" style="max-width: 600px;">
                    <span class="badge mb-2 px-2 py-1" style="background: rgba(255,255,255,0.15); color: #ffffff; font-size: 11px; letter-spacing: 0.05em;">SIAP PINDAH KOS?</span>
                    <h3 style="font-family: var(--font-serif); font-size: 1.65rem; font-weight: 700; margin-bottom: 8px;">Cari Kos Sesuai Budget Sekarang</h3>
                    <p style="color: rgba(255,255,255,0.75); font-size: 14px; margin-bottom: 0;">Jelajahi ratusan kos pilihan dengan filter kampus, lokasi strategis, fasilitas komplit, dan klaim vouchernya hari ini.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('kos.index') }}" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 14px; padding: 12px 24px; border-radius: var(--radius-buttons); border: none;">
                        <i class="fa fa-search mr-2"></i> Jelajahi Semua Kos
                    </a>
                </div>
            </div>
        </section>

        <!-- STATS SECTION -->
        <section class="container">
            <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline);">
                <div class="row text-center">
                    <div class="col-md-3 col-6 py-2 border-right" style="border-color: rgba(0,0,0,0.06) !important;">
                        <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink);">5.200+</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500;">Kos Terdaftar</div>
                    </div>
                    <div class="col-md-3 col-6 py-2 border-right-md" style="border-color: rgba(0,0,0,0.06) !important;">
                        <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink);">120+</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500;">Kota &amp; Area</div>
                    </div>
                    <div class="col-md-3 col-6 py-2 border-right" style="border-color: rgba(0,0,0,0.06) !important;">
                        <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink);">38.000+</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500;">Penyewa Aktif</div>
                    </div>
                    <div class="col-md-3 col-6 py-2">
                        <div style="font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink);">750+</div>
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500;">Mitra Pemilik</div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>

<!-- TOAST NOTIFICATION -->
<div id="promoToast" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; background: var(--color-midnight-ink); color: #ffffff; padding: 12px 20px; border-radius: 8px; box-shadow: 0 4px 14px rgba(0,0,0,0.18); font-size: 13.5px; font-weight: 600; display: none; align-items: center; gap: 8px;">
    <i class="fa fa-check-circle text-primary"></i> <span id="promoToastText">Kode voucher berhasil disalin!</span>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterBtns = document.querySelectorAll('.btn-promo-filter');
    const searchInput = document.getElementById('promoSearchInput');
    const cards = document.querySelectorAll('.promo-card-item');
    const emptyState = document.getElementById('promoEmptyState');
    const btnResetFilter = document.getElementById('btnResetFilter');
    const toast = document.getElementById('promoToast');
    const toastText = document.getElementById('promoToastText');

    let currentCategory = 'all';
    let searchQuery = '';

    function showToast(msg) {
        if (!toast) return;
        toastText.textContent = msg;
        toast.style.display = 'flex';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 2500);
    }

    function filterCards() {
        let visibleCount = 0;
        cards.forEach(card => {
            const cat = card.getAttribute('data-category');
            const code = card.getAttribute('data-code').toLowerCase();
            const text = card.textContent.toLowerCase();

            const matchCat = (currentCategory === 'all' || cat === currentCategory);
            const matchSearch = (searchQuery === '' || code.includes(searchQuery) || text.includes(searchQuery));

            if (matchCat && matchSearch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.classList.remove('d-none');
            } else {
                emptyState.classList.add('d-none');
            }
        }
    }

    // Filter Buttons
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            filterBtns.forEach(b => {
                b.style.backgroundColor = '#ffffff';
                b.style.color = 'var(--color-charcoal)';
                b.classList.remove('active');
            });
            this.style.backgroundColor = 'var(--color-notion-blue)';
            this.style.color = '#ffffff';
            this.classList.add('active');

            currentCategory = this.getAttribute('data-filter');
            filterCards();
        });
    });

    // Search Input
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            filterCards();
        });
    }

    // Reset button
    if (btnResetFilter) {
        btnResetFilter.addEventListener('click', function () {
            currentCategory = 'all';
            searchQuery = '';
            if (searchInput) searchInput.value = '';
            filterBtns.forEach(b => {
                b.style.backgroundColor = '#ffffff';
                b.style.color = 'var(--color-charcoal)';
                b.classList.remove('active');
                if (b.getAttribute('data-filter') === 'all') {
                    b.style.backgroundColor = 'var(--color-notion-blue)';
                    b.style.color = '#ffffff';
                    b.classList.add('active');
                }
            });
            filterCards();
        });
    }

    // Copy Voucher Code
    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const code = this.getAttribute('data-code');
            if (navigator.clipboard) {
                navigator.clipboard.writeText(code).then(() => {
                    showToast('Kode voucher ' + code + ' berhasil disalin!');
                }).catch(() => {
                    showToast('Kode voucher ' + code + ' disalin!');
                });
            } else {
                showToast('Kode voucher ' + code + ' disalin!');
            }
        });
    });
});
</script>
@endpush
@endsection
