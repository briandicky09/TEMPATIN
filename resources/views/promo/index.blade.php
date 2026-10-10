@extends('layouts.app')

@section('title', 'Promo TEMPATIN - Penawaran Kos Terbaik & Voucher Hemat')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 6px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Promo</li>
                </ol>
            </nav>
        </div>

        <!-- HERO HEADER -->
        <section class="container mb-5">
            <div style="max-width: 760px;">
                <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); border: 1px solid rgba(0, 117, 222, 0.2); font-size: 13px; font-weight: 600; color: var(--color-notion-blue);">
                    <i class="fa fa-percent mr-2"></i> Penawaran Khusus Bulan Ini
                </div>
                <h1 style="font-family: var(--font-serif); font-size: clamp(2rem, 3.5vw, 2.75rem); font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.02em; line-height: 1.25;" class="mb-3">
                    Hemat Lebih Banyak untuk Kos Impianmu.
                </h1>
                <p style="font-size: 16px; color: var(--color-stone); line-height: 1.6; margin-bottom: 0;">
                    Gunakan kode voucher eksklusif, nikmati potongan biaya sewa bulanan, dan dapatkan jaminan cashback langsung dari TEMPATIN.
                </p>
            </div>
        </section>

        <!-- VOUCHER BENTO GRID -->
        <section class="container mb-5">
            <div class="row">
                <!-- Voucher 1 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="notion-card h-100 p-4 d-flex flex-column justify-content-between position-relative" style="background: #ffffff; border-radius: var(--radius-cards); border: var(--border-hairline);">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600; font-size: 12px; padding: 4px 10px; border-radius: 4px; border: 1px solid rgba(0, 117, 222, 0.18);">PENGHUNI BARU</span>
                                <span style="font-size: 12px; color: var(--color-stone);"><i class="fa fa-clock mr-1"></i> s/d 30 Nov</span>
                            </div>
                            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Diskon 20% Bulan Pertama</h3>
                            <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 20px;">
                                Potongan langsung hingga Rp 300.000 untuk booking kos pertama kali via pembayaran digital TEMPATIN.
                            </p>
                        </div>
                        <div class="pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                            <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background-color: var(--surface-page-canvas); border: 1px dashed rgba(0,0,0,0.15);">
                                <code style="font-size: 14px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.05em;">KOSBARU20</code>
                                <button type="button" class="btn btn-sm btn-ghost" onclick="navigator.clipboard.writeText('KOSBARU20'); alert('Kode voucher KOSBARU20 berhasil disalin!');" style="font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px;">
                                    <i class="fa fa-copy mr-1"></i> Salin
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Voucher 2 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="notion-card h-100 p-4 d-flex flex-column justify-content-between position-relative" style="background: #ffffff; border-radius: var(--radius-cards); border: var(--border-hairline);">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge" style="background-color: #edf7ee; color: #166534; font-weight: 600; font-size: 12px; padding: 4px 10px; border-radius: 4px; border: 1px solid rgba(22, 101, 52, 0.18);">GRATIS ADMIN</span>
                                <span style="font-size: 12px; color: var(--color-stone);"><i class="fa fa-bolt mr-1"></i> Kuota Terbatas</span>
                            </div>
                            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Bebas Biaya Administrasi</h3>
                            <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 20px;">
                                Nol rupiah biaya admin tanpa minimum transaksi untuk seluruh kos bertanda verified TEMPATIN.
                            </p>
                        </div>
                        <div class="pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                            <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background-color: var(--surface-page-canvas); border: 1px dashed rgba(0,0,0,0.15);">
                                <code style="font-size: 14px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.05em;">FREEADMIN</code>
                                <button type="button" class="btn btn-sm btn-ghost" onclick="navigator.clipboard.writeText('FREEADMIN'); alert('Kode voucher FREEADMIN berhasil disalin!');" style="font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px;">
                                    <i class="fa fa-copy mr-1"></i> Salin
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Voucher 3 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="notion-card h-100 p-4 d-flex flex-column justify-content-between position-relative" style="background: #ffffff; border-radius: var(--radius-cards); border: var(--border-hairline);">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge" style="background-color: #fef9c3; color: #854d0e; font-weight: 600; font-size: 12px; padding: 4px 10px; border-radius: 4px; border: 1px solid rgba(133, 77, 14, 0.18);">CASHBACK SEWA</span>
                                <span style="font-size: 12px; color: var(--color-stone);"><i class="fa fa-calendar mr-1"></i> 6+ Bulan</span>
                            </div>
                            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">Cashback Rp 500.000</h3>
                            <p style="font-size: 13px; color: var(--color-stone); line-height: 1.5; margin-bottom: 20px;">
                                Sewa kos minimal 6 bulan atau 1 tahun dan dapatkan saldo e-wallet langsung terkirim setelah konfirmasi masuk.
                            </p>
                        </div>
                        <div class="pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                            <div class="d-flex align-items-center justify-content-between p-2 rounded" style="background-color: var(--surface-page-canvas); border: 1px dashed rgba(0,0,0,0.15);">
                                <code style="font-size: 14px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.05em;">SEMESTERAN500</code>
                                <button type="button" class="btn btn-sm btn-ghost" onclick="navigator.clipboard.writeText('SEMESTERAN500'); alert('Kode voucher SEMESTERAN500 berhasil disalin!');" style="font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px;">
                                    <i class="fa fa-copy mr-1"></i> Salin
                                </button>
                            </div>
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
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0;">Fasilitas dan kamar disurvei langsung oleh tim TEMPATIN.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4 mb-md-0">
                        <div class="p-3">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 8px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 1.25rem;">
                                <i class="fa fa-tag"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Garansi Harga</h4>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0;">Tarif sama atau lebih murah dibanding langsung ke pemilik.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4 mb-md-0">
                        <div class="p-3">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 8px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 1.25rem;">
                                <i class="fa fa-lock"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Transaksi Aman</h4>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0;">Dana aman tertampung hingga kamu resmi check-in.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4 mb-md-0">
                        <div class="p-3">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 48px; height: 48px; border-radius: 8px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 1.25rem;">
                                <i class="fa fa-headset"></i>
                            </div>
                            <h4 style="font-size: 15px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 6px;">Bantuan 24/7</h4>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0;">Tim operasional sigap mendampingi proses booking hingga masuk.</p>
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
                    <p style="color: rgba(255,255,255,0.7); font-size: 14px; margin-bottom: 0;">Jelajahi ratusan kos pilihan dengan filter kampus, lokasi strategis, dan fasilitas komplit.</p>
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
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500;">Kota & Area</div>
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
@endsection
