@extends('layouts.app')

@section('title', 'Pusat Bacaan & Tips Hunian Kos - TEMPATIN')

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
                        Artikel &amp; Panduan
                    </li>
                </ol>
            </nav>
        </div>

        <!-- HERO HEADER -->
        <section class="container mb-5">
            <div style="max-width: 820px;">
                <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); border: 1px solid rgba(0, 117, 222, 0.2); font-size: 12px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.04em;">
                    <i class="fa fa-book-open mr-2"></i> PUSAT BACAAN &amp; PANDUAN SEWA
                </div>
                <h1 style="font-family: var(--font-serif); font-size: clamp(2rem, 3.6vw, 2.75rem); font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.025em; line-height: 1.25;" class="mb-3">
                    Wawasan &amp; Panduan Memilih Hunian Ideal.
                </h1>
                <p style="font-size: 16px; color: var(--color-stone); line-height: 1.65; max-width: 720px; margin-bottom: 0;">
                    Kumpulan panduan independen dari tim TEMPATIN mengenai tips survei fisik kamar, simulasi estimasi biaya, proteksi transaksi pembayaran, serta checklist keamanan tinggal mandiri.
                </p>
            </div>

            <!-- FILTER TABS (CLIENT-SIDE) -->
            <div class="d-flex flex-wrap align-items-center gap-2 mt-4 pt-2" style="border-top: var(--border-hairline);">
                <button type="button" class="btn btn-sm btn-filter-tab active font-weight-bold px-3 py-2 mr-2 mb-2" data-filter="all" style="border-radius: 9999px; font-size: 13px; border: 1px solid rgba(0,0,0,0.12); background-color: var(--color-notion-blue); color: #ffffff;">
                    Semua Panduan (4)
                </button>
                <button type="button" class="btn btn-sm btn-filter-tab font-weight-bold px-3 py-2 mr-2 mb-2" data-filter="pemula" style="border-radius: 9999px; font-size: 13px; border: 1px solid rgba(0,0,0,0.12); background-color: #ffffff; color: var(--color-charcoal);">
                    Panduan Pemula (1)
                </button>
                <button type="button" class="btn btn-sm btn-filter-tab font-weight-bold px-3 py-2 mr-2 mb-2" data-filter="transaksi" style="border-radius: 9999px; font-size: 13px; border: 1px solid rgba(0,0,0,0.12); background-color: #ffffff; color: var(--color-charcoal);">
                    Transaksi Aman (1)
                </button>
                <button type="button" class="btn btn-sm btn-filter-tab font-weight-bold px-3 py-2 mr-2 mb-2" data-filter="tipe" style="border-radius: 9999px; font-size: 13px; border: 1px solid rgba(0,0,0,0.12); background-color: #ffffff; color: var(--color-charcoal);">
                    Tipe Properti (1)
                </button>
                <button type="button" class="btn btn-sm btn-filter-tab font-weight-bold px-3 py-2 mr-2 mb-2" data-filter="finansial" style="border-radius: 9999px; font-size: 13px; border: 1px solid rgba(0,0,0,0.12); background-color: #ffffff; color: var(--color-charcoal);">
                    Budget &amp; Finansial (1)
                </button>
            </div>
        </section>

        <!-- MAIN CONTENT WITH SIDEBAR -->
        <section class="container">
            <div class="row">
                <!-- ARTICLES FEED -->
                <div class="col-lg-8 mb-5 mb-lg-0" id="articlesContainer">

                    <!-- Article 1: Panduan Pemula -->
                    <article class="p-4 p-md-5 mb-4 article-item" data-category="pemula" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: border-color 0.2s ease;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge mr-2 px-2 py-1" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 700; font-size: 11px; letter-spacing: 0.04em; border-radius: 4px; border: 1px solid rgba(0, 117, 222, 0.15);">PANDUAN PEMULA</span>
                                <span class="small" style="color: var(--color-stone);"><i class="fa fa-calendar-alt mr-1"></i> 05 Agustus 2026</span>
                            </div>
                            <span class="small" style="color: var(--color-stone);"><i class="fa fa-clock mr-1"></i> 4 Menit Baca</span>
                        </div>

                        <h2 style="font-family: var(--font-serif); font-size: 1.55rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 16px; line-height: 1.35; letter-spacing: -0.02em;">
                            Cara Memilih Kos yang Aman, Nyaman, dan Dekat Aktivitas Harian
                        </h2>

                        <div class="mb-4 overflow-hidden rounded position-relative" style="border: var(--border-hairline); max-height: 340px;">
                            <img src="{{ asset('assets/img/artikel-survey.jpg') }}" alt="Cara memilih kos yang aman dan nyaman" class="img-fluid w-100" style="object-fit: cover; width: 100%; height: 320px; display: block;">
                        </div>

                        <p style="font-size: 15px; color: var(--color-charcoal); line-height: 1.7; margin-bottom: 20px;">
                            Memilih kos bukan sekadar mencari tempat tidur dan mandi. Lingkungan yang kondusif, ventilasi sirkulasi udara alami yang segar, serta kepastian keamanan akses 24 jam merupakan faktor primer yang menentukan produktivitas dan kenyamanan istirahat harianmu sebagai perantau.
                        </p>

                        <!-- Callout box -->
                        <div class="p-3 p-md-4 mb-4 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.07); font-size: 13.5px;">
                            <div class="font-weight-bold mb-2" style="color: var(--color-midnight-ink); font-size: 14px;"><i class="fa fa-clipboard-check text-primary mr-2"></i> Checklist Wajib Sebelum Tanda Tangan Sewa:</div>
                            <ul class="mb-0 pl-3" style="color: var(--color-stone); line-height: 1.7;">
                                <li><strong>Sirkulasi &amp; Cahaya:</strong> Pastikan kamar memiliki jendela yang dapat dibuka langsung ke udara luar, bukan sekadar lorong tertutup.</li>
                                <li><strong>Kekuatan Sinyal &amp; WiFi:</strong> Lakukan speed test internet langsung di dalam kamar saat jam malam untuk menguji kestabilan koneksi.</li>
                                <li><strong>Akses &amp; Lingkungan:</strong> Periksa apakah gerbang terkunci teratur dan apakah jalan akses kos cukup terang dilewati malam hari.</li>
                            </ul>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: var(--border-hairline);">
                            <div class="d-flex align-items-center">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-2" style="width: 32px; height: 32px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 12px; font-weight: 700;">
                                    <i class="fa fa-pen-nib"></i>
                                </div>
                                <span class="small font-weight-bold" style="color: var(--color-midnight-ink);">Tim Edukasi TEMPATIN</span>
                            </div>
                            <span class="badge" style="background-color: var(--surface-page-canvas); color: var(--color-stone); border: var(--border-hairline); font-size: 11px; padding: 4px 8px;">Panduan Terverifikasi</span>
                        </div>
                    </article>

                    <!-- Article 2: Transaksi Aman -->
                    <article class="p-4 p-md-5 mb-4 article-item" data-category="transaksi" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: border-color 0.2s ease;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge mr-2 px-2 py-1" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 700; font-size: 11px; letter-spacing: 0.04em; border-radius: 4px; border: 1px solid rgba(0, 117, 222, 0.15);">TRANSAKSI AMAN</span>
                                <span class="small" style="color: var(--color-stone);"><i class="fa fa-calendar-alt mr-1"></i> 02 Agustus 2026</span>
                            </div>
                            <span class="small" style="color: var(--color-stone);"><i class="fa fa-clock mr-1"></i> 3 Menit Baca</span>
                        </div>

                        <h2 style="font-family: var(--font-serif); font-size: 1.55rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 16px; line-height: 1.35; letter-spacing: -0.02em;">
                            5 Hal Wajib Diperiksa Sebelum Membayar Uang Muka Booking Kos
                        </h2>

                        <div class="mb-4 overflow-hidden rounded position-relative" style="border: var(--border-hairline); max-height: 340px;">
                            <img src="{{ asset('assets/img/artikel-1.png') }}" alt="5 hal wajib diperhatikan sebelum booking kos" class="img-fluid w-100" style="object-fit: cover; width: 100%; height: 320px; display: block;">
                        </div>

                        <p style="font-size: 15px; color: var(--color-charcoal); line-height: 1.7; margin-bottom: 20px;">
                            Sebelum mentransfer dana muka (DP) atau biaya sewa bulanan, pastikan kamu telah memahami seluruh klausul tagihan. Mulai dari kepastian token listrik (apakah mandiri atau patungan), biaya air, iuran kebersihan, serta keabsahan identitas pemilik kos.
                        </p>

                        <!-- Callout box -->
                        <div class="p-3 p-md-4 mb-4 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.07); font-size: 13.5px;">
                            <div class="font-weight-bold mb-2" style="color: var(--color-midnight-ink); font-size: 14px;"><i class="fa fa-shield-alt text-primary mr-2"></i> Proteksi Pembayaran Resmi:</div>
                            <ul class="mb-0 pl-3" style="color: var(--color-stone); line-height: 1.7;">
                                <li><strong>Gunakan Rekening Resmi:</strong> Jangan pernah mengirim transfer ke rekening pribadi tanpa surat invoice atau tanda terima resmi platform.</li>
                                <li><strong>Status Deposit Jaminan:</strong> Minta kesepakatan tertulis tentang syarat pengembalian deposit (contoh: kondisi kamar bersih saat checkout).</li>
                                <li><strong>Fitur Escrow TEMPATIN:</strong> Manfaatkan penampungan pembayaran digital di mana uang sewa baru diteruskan setelah kamu sukses serah terima kunci.</li>
                            </ul>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: var(--border-hairline);">
                            <div class="d-flex align-items-center">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-2" style="width: 32px; height: 32px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 12px; font-weight: 700;">
                                    <i class="fa fa-shield-alt"></i>
                                </div>
                                <span class="small font-weight-bold" style="color: var(--color-midnight-ink);">Legal &amp; Finansial TEMPATIN</span>
                            </div>
                            <span class="badge" style="background-color: var(--surface-page-canvas); color: var(--color-stone); border: var(--border-hairline); font-size: 11px; padding: 4px 8px;">Proteksi Escrow</span>
                        </div>
                    </article>

                    <!-- Article 3: Tipe Properti -->
                    <article class="p-4 p-md-5 mb-4 article-item" data-category="tipe" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: border-color 0.2s ease;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge mr-2 px-2 py-1" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 700; font-size: 11px; letter-spacing: 0.04em; border-radius: 4px; border: 1px solid rgba(0, 117, 222, 0.15);">TIPE PROPERTI</span>
                                <span class="small" style="color: var(--color-stone);"><i class="fa fa-calendar-alt mr-1"></i> 28 Juli 2026</span>
                            </div>
                            <span class="small" style="color: var(--color-stone);"><i class="fa fa-clock mr-1"></i> 5 Menit Baca</span>
                        </div>

                        <h2 style="font-family: var(--font-serif); font-size: 1.55rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 16px; line-height: 1.35; letter-spacing: -0.02em;">
                            Perbedaan Karakteristik Kos Putra, Putri, Campur &amp; Eksklusif
                        </h2>

                        <div class="mb-4 overflow-hidden rounded position-relative" style="border: var(--border-hairline); max-height: 340px;">
                            <img src="{{ asset('assets/img/kos-anggrek.jpg') }}" alt="Perbedaan tipe kos" class="img-fluid w-100" style="object-fit: cover; width: 100%; height: 320px; display: block;">
                        </div>

                        <p style="font-size: 15px; color: var(--color-charcoal); line-height: 1.7; margin-bottom: 20px;">
                            Setiap tipe kos mengusung peraturan dan dinamika interaksi yang berlainan. Memahami batas privasi, aturan jam malam, serta pembagian fasilitas bersama akan membantumu memilih hunian yang pas dengan ritme kuliah maupun pekerjaan sehari-hari.
                        </p>

                        <!-- Callout box -->
                        <div class="p-3 p-md-4 mb-4 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.07); font-size: 13.5px;">
                            <div class="font-weight-bold mb-2" style="color: var(--color-midnight-ink); font-size: 14px;"><i class="fa fa-layer-group text-primary mr-2"></i> Ringkasan Karakteristik:</div>
                            <ul class="mb-0 pl-3" style="color: var(--color-stone); line-height: 1.7;">
                                <li><strong>Kos Putra &amp; Putri:</strong> Memiliki aturan pengunjung lawan jenis yang ketat, biasanya dibatasi di ruang tamu utama atau teras luar.</li>
                                <li><strong>Kos Campur:</strong> Dihuni oleh mahasiswa senior dan pekerja kantoran, dengan privasi lantai terpisah dan aturan tata tertib mandiri.</li>
                                <li><strong>Kos Eksklusif:</strong> Fasilitas setara apartemen (kamar mandi dalam, water heater, smart lock, cleaning rutin, dan parkir mobil luas).</li>
                            </ul>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: var(--border-hairline);">
                            <div class="d-flex align-items-center">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-2" style="width: 32px; height: 32px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 12px; font-weight: 700;">
                                    <i class="fa fa-home"></i>
                                </div>
                                <span class="small font-weight-bold" style="color: var(--color-midnight-ink);">Riset Komunitas Hunian</span>
                            </div>
                            <span class="badge" style="background-color: var(--surface-page-canvas); color: var(--color-stone); border: var(--border-hairline); font-size: 11px; padding: 4px 8px;">Panduan Komprehensif</span>
                        </div>
                    </article>

                    <!-- Article 4: Budget & Finansial -->
                    <article class="p-4 p-md-5 mb-4 article-item" data-category="finansial" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: border-color 0.2s ease;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge mr-2 px-2 py-1" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 700; font-size: 11px; letter-spacing: 0.04em; border-radius: 4px; border: 1px solid rgba(0, 117, 222, 0.15);">BUDGET &amp; FINANSIAL</span>
                                <span class="small" style="color: var(--color-stone);"><i class="fa fa-calendar-alt mr-1"></i> 20 Juli 2026</span>
                            </div>
                            <span class="small" style="color: var(--color-stone);"><i class="fa fa-clock mr-1"></i> 4 Menit Baca</span>
                        </div>

                        <h2 style="font-family: var(--font-serif); font-size: 1.55rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 16px; line-height: 1.35; letter-spacing: -0.02em;">
                            Simulasi Budget Sewa Kos: Biaya Pokok vs Biaya Tersembunyi
                        </h2>

                        <div class="mb-4 overflow-hidden rounded position-relative" style="border: var(--border-hairline); max-height: 340px;">
                            <img src="{{ asset('assets/img/artikel-budget.jpg') }}" alt="Simulasi budget sewa kos" class="img-fluid w-100" style="object-fit: cover; width: 100%; height: 320px; display: block;">
                        </div>

                        <p style="font-size: 15px; color: var(--color-charcoal); line-height: 1.7; margin-bottom: 20px;">
                            Pengeluaran riil tempat tinggal anak rantau seringkali melebihi angka sewa pokok yang tertera di iklan. Pastikan kamu menghitung biaya variabel seperti token listrik AC, air galon minum, laundry, dan biaya parkir kendaraan bermotor.
                        </p>

                        <!-- Callout box -->
                        <div class="p-3 p-md-4 mb-4 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.07); font-size: 13.5px;">
                            <div class="font-weight-bold mb-2" style="color: var(--color-midnight-ink); font-size: 14px;"><i class="fa fa-calculator text-primary mr-2"></i> Rumus Alokasi Finansial Ideal:</div>
                            <ul class="mb-0 pl-3" style="color: var(--color-stone); line-height: 1.7;">
                                <li><strong>Rasio Sewa Maksimal:</strong> Alokasikan tidak lebih dari 30% hingga 35% pendapatan bulanan untuk total sewa tempat tinggal.</li>
                                <li><strong>Dana Darurat Kos:</strong> Siapkan cadangan biaya deposit (setara 1 bulan sewa) di awal kedatangan untuk antisipasi pindah mendadak.</li>
                                <li><strong>Opsi Sewa Tahunan:</strong> Jika yakin betah minimal 1 tahun, negosiasikan diskon bayar tahunan yang biasanya hemat 1 hingga 2 bulan sewa.</li>
                            </ul>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: var(--border-hairline);">
                            <div class="d-flex align-items-center">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-2" style="width: 32px; height: 32px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 12px; font-weight: 700;">
                                    <i class="fa fa-chart-line"></i>
                                </div>
                                <span class="small font-weight-bold" style="color: var(--color-midnight-ink);">Konsultan Finansial Muda</span>
                            </div>
                            <span class="badge" style="background-color: var(--surface-page-canvas); color: var(--color-stone); border: var(--border-hairline); font-size: 11px; padding: 4px 8px;">Manajemen Finansial</span>
                        </div>
                    </article>

                    <!-- EMPTY STATE -->
                    <div id="articleEmptyState" class="p-5 text-center rounded d-none" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 22px;">
                            <i class="fa fa-search"></i>
                        </div>
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Artikel Tidak Ditemukan</h3>
                        <p style="font-size: 14px; color: var(--color-stone); max-width: 440px; margin: 0 auto 20px;">
                            Tidak ada panduan atau artikel yang cocok dengan pencarianmu. Coba gunakan kata kunci lain seperti "survei", "listrik", atau "deposit".
                        </p>
                        <button type="button" id="btnResetArticleSearch" class="btn btn-sm" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; padding: 8px 18px; border-radius: var(--radius-buttons);">
                            Tampilkan Semua Artikel
                        </button>
                    </div>

                </div>

                <!-- SIDEBAR -->
                <div class="col-lg-4">
                    <div style="position: sticky; top: 84px;">

                        <!-- Search Articles Widget -->
                        <div class="p-4 mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <h3 style="font-size: 13px; font-weight: 700; color: var(--color-midnight-ink); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px;">
                                <i class="fa fa-search text-muted mr-1"></i> Cari Panduan
                            </h3>
                            <div class="input-group">
                                <input type="text" id="articleSearchInput" class="form-control" placeholder="Ketik kata kunci..." style="border-radius: 6px 0 0 6px; font-size: 13.5px; height: 42px; border: var(--border-hairline);">
                                <div class="input-group-append">
                                    <button class="btn" type="button" style="border-radius: 0 6px 6px 0; padding: 0 16px; background-color: var(--color-notion-blue); color: #ffffff; border: none;">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block" id="searchMatchCount" style="font-size: 12px;">Menampilkan semua 4 artikel</small>
                        </div>

                        <!-- Categories Navigation -->
                        <div class="p-4 mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <h3 style="font-size: 13px; font-weight: 700; color: var(--color-midnight-ink); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 14px;">
                                <i class="fa fa-folder-open text-muted mr-1"></i> Telusuri Kos Pilihan
                            </h3>
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('kos.index', ['gender' => 'putra']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded text-decoration-none" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); font-size: 13px; font-weight: 600; border: 1px solid rgba(0,0,0,0.05); transition: background 0.15s ease;">
                                    <span><i class="fa fa-male mr-2 text-primary"></i> Kos Putra Terverifikasi</span>
                                    <span class="badge" style="background-color: #ffffff; color: var(--color-stone); border: var(--border-hairline); font-size: 11px;">Filter &rarr;</span>
                                </a>
                                <a href="{{ route('kos.index', ['gender' => 'putri']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded text-decoration-none" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); font-size: 13px; font-weight: 600; border: 1px solid rgba(0,0,0,0.05); transition: background 0.15s ease;">
                                    <span><i class="fa fa-female mr-2 text-primary"></i> Kos Putri Terverifikasi</span>
                                    <span class="badge" style="background-color: #ffffff; color: var(--color-stone); border: var(--border-hairline); font-size: 11px;">Filter &rarr;</span>
                                </a>
                                <a href="{{ route('kos.index', ['gender' => 'campur']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded text-decoration-none" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); font-size: 13px; font-weight: 600; border: 1px solid rgba(0,0,0,0.05); transition: background 0.15s ease;">
                                    <span><i class="fa fa-users mr-2 text-primary"></i> Kos Campur Terverifikasi</span>
                                    <span class="badge" style="background-color: #ffffff; color: var(--color-stone); border: var(--border-hairline); font-size: 11px;">Filter &rarr;</span>
                                </a>
                                <a href="{{ route('kos.index') }}" class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); font-size: 13px; font-weight: 600; border: 1px solid rgba(0,0,0,0.05); transition: background 0.15s ease;">
                                    <span><i class="fa fa-gem mr-2 text-primary"></i> Kos Eksklusif &amp; AC</span>
                                    <span class="badge" style="background-color: #ffffff; color: var(--color-stone); border: var(--border-hairline); font-size: 11px;">Lihat &rarr;</span>
                                </a>
                            </div>
                        </div>

                        <!-- Help / Concierge Box -->
                        <div class="p-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 10px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px;">
                                <i class="fa fa-headset"></i>
                            </div>
                            <h3 style="font-size: 16px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">
                                Butuh Rekomendasi Kos?
                            </h3>
                            <p style="font-size: 13px; color: var(--color-stone); line-height: 1.6; margin-bottom: 16px;">
                                Konsultasikan kampus atau area kantor tujuan serta batas budget kamu dengan konsultan hunian TEMPATIN tanpa dipungut biaya.
                            </p>
                            <a href="{{ route('contact') }}" class="btn btn-block font-weight-bold" style="background-color: var(--color-midnight-ink); color: #ffffff; font-size: 13px; padding: 10px 16px; border-radius: var(--radius-buttons); text-decoration: none;">
                                <i class="fa fa-comments mr-2"></i> Konsultasi Gratis Sekarang
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterTabs = document.querySelectorAll('.btn-filter-tab');
    const articles = document.querySelectorAll('.article-item');
    const searchInput = document.getElementById('articleSearchInput');
    const matchCount = document.getElementById('searchMatchCount');
    const emptyState = document.getElementById('articleEmptyState');
    const btnReset = document.getElementById('btnResetArticleSearch');

    let currentFilter = 'all';
    let searchQuery = '';

    function applyFilterAndSearch() {
        let visibleCount = 0;

        articles.forEach(article => {
            const category = article.getAttribute('data-category');
            const title = article.querySelector('h2').textContent.toLowerCase();
            const text = article.textContent.toLowerCase();

            const matchesCategory = (currentFilter === 'all' || category === currentFilter);
            const matchesSearch = searchQuery === '' || title.includes(searchQuery) || text.includes(searchQuery);

            if (matchesCategory && matchesSearch) {
                article.style.display = 'block';
                visibleCount++;
            } else {
                article.style.display = 'none';
            }
        });

        if (matchCount) {
            matchCount.textContent = `Menampilkan ${visibleCount} dari ${articles.length} artikel`;
        }

        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.classList.remove('d-none');
            } else {
                emptyState.classList.add('d-none');
            }
        }
    }

    // Filter tab buttons
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            filterTabs.forEach(t => {
                t.style.backgroundColor = '#ffffff';
                t.style.color = 'var(--color-charcoal)';
                t.classList.remove('active');
            });
            this.style.backgroundColor = 'var(--color-notion-blue)';
            this.style.color = '#ffffff';
            this.classList.add('active');

            currentFilter = this.getAttribute('data-filter');
            applyFilterAndSearch();
        });
    });

    // Search input
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            searchQuery = this.value.trim().toLowerCase();
            applyFilterAndSearch();
        });
    }

    // Reset button
    if (btnReset) {
        btnReset.addEventListener('click', function () {
            currentFilter = 'all';
            searchQuery = '';
            if (searchInput) searchInput.value = '';
            filterTabs.forEach(t => {
                t.style.backgroundColor = '#ffffff';
                t.style.color = 'var(--color-charcoal)';
                t.classList.remove('active');
                if (t.getAttribute('data-filter') === 'all') {
                    t.style.backgroundColor = 'var(--color-notion-blue)';
                    t.style.color = '#ffffff';
                    t.classList.add('active');
                }
            });
            applyFilterAndSearch();
        });
    }
});
</script>
@endpush
@endsection
