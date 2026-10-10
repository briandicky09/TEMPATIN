@extends('layouts.app')

@section('title', 'Pusat Bacaan & Panduan Kos - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 6px; padding-bottom: 80px;">

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
                        Pusat Bacaan
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
                <h1 style="font-size: clamp(2rem, 3.6vw, 2.75rem); font-weight: 700; color: var(--color-ink-black); letter-spacing: -0.035em; line-height: 1.2;" class="mb-3">
                    Wawasan &amp; Panduan Memilih Hunian Ideal.
                </h1>
                <p class="font-editorial mb-0" style="font-size: 1.15rem; color: var(--color-graphite); line-height: 1.65; max-width: 720px;">
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
                    <article class="p-4 mb-4 article-item" data-category="pemula" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: border-color 0.2s ease;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-light border text-primary font-weight-bold px-2 py-1 mr-2" style="font-size: 11px; letter-spacing: 0.04em;">PANDUAN PEMULA</span>
                                <span class="text-muted small"><i class="fa fa-calendar-alt mr-1"></i> 05 Agustus 2026</span>
                            </div>
                            <span class="text-muted small"><i class="fa fa-clock mr-1"></i> 4 Menit Baca</span>
                        </div>

                        <h2 style="font-size: 1.45rem; font-weight: 700; color: var(--color-ink-black); margin-bottom: 14px; line-height: 1.35; letter-spacing: -0.02em;">
                            Cara Memilih Kos yang Aman, Nyaman, dan Dekat Aktivitas Harian
                        </h2>

                        <div class="mb-4 overflow-hidden rounded" style="border: var(--border-hairline); max-height: 300px;">
                            <img src="{{ asset('assets/img/artikel-1.png') }}" alt="Cara memilih kos yang aman dan nyaman" class="img-fluid w-100" style="object-fit: cover; width: 100%; height: 280px;">
                        </div>

                        <p style="font-size: 15px; color: var(--color-graphite); line-height: 1.65; margin-bottom: 16px;">
                            Memilih kos bukan sekadar mencari tempat tidur dan mandi. Lingkungan yang kondusif, ventilasi sirkulasi udara alami yang segar, serta kepastian keamanan akses 24 jam merupakan faktor primer yang menentukan produktivitas dan kenyamanan istirahat harianmu sebagai perantau.
                        </p>

                        <!-- Callout box -->
                        <div class="p-3 mb-4 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13.5px;">
                            <div class="font-weight-bold mb-2 text-dark"><i class="fa fa-clipboard-check text-primary mr-2"></i> Checklist Wajib Sebelum Tanda Tangan Sewa:</div>
                            <ul class="mb-0 pl-3" style="color: var(--color-graphite); line-height: 1.65;">
                                <li><strong>Sirkulasi &amp; Cahaya:</strong> Pastikan kamar memiliki jendela yang dapat dibuka langsung ke udara luar, bukan sekadar lorong tertutup.</li>
                                <li><strong>Kekuatan Sinyal &amp; WiFi:</strong> Lakukan speed test internet langsung di dalam kamar saat jam malam untuk menguji kestabilan koneksi.</li>
                                <li><strong>Akses &amp; Lingkungan:</strong> Periksa apakah gerbang terkunci teratur dan apakah jalan akses kos cukup terang dilewati malam hari.</li>
                            </ul>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: var(--border-hairline);">
                            <div class="d-flex align-items-center">
                                <span class="notion-character-mark mr-2" style="width: 28px; height: 28px; font-size: 11px;"><i class="fa fa-pen-nib"></i></span>
                                <span class="small font-weight-bold text-dark">Tim Edukasi TEMPATIN</span>
                            </div>
                            <span class="badge badge-light border text-muted">Panduan Terverifikasi</span>
                        </div>
                    </article>

                    <!-- Article 2: Transaksi Aman -->
                    <article class="p-4 mb-4 article-item" data-category="transaksi" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: border-color 0.2s ease;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-light border text-primary font-weight-bold px-2 py-1 mr-2" style="font-size: 11px; letter-spacing: 0.04em;">TRANSAKSI AMAN</span>
                                <span class="text-muted small"><i class="fa fa-calendar-alt mr-1"></i> 02 Agustus 2026</span>
                            </div>
                            <span class="text-muted small"><i class="fa fa-clock mr-1"></i> 3 Menit Baca</span>
                        </div>

                        <h2 style="font-size: 1.45rem; font-weight: 700; color: var(--color-ink-black); margin-bottom: 14px; line-height: 1.35; letter-spacing: -0.02em;">
                            5 Hal Wajib Diperiksa Sebelum Membayar Uang Muka Booking Kos
                        </h2>

                        <div class="mb-4 overflow-hidden rounded" style="border: var(--border-hairline); max-height: 300px;">
                            <img src="{{ asset('assets/img/artikel-2.jpg') }}" alt="5 hal yang wajib diperhatikan sebelum booking kos" class="img-fluid w-100" style="object-fit: cover; width: 100%; height: 280px;">
                        </div>

                        <p style="font-size: 15px; color: var(--color-graphite); line-height: 1.65; margin-bottom: 16px;">
                            Sebelum mentransfer dana muka (DP) atau biaya sewa bulanan, pastikan kamu telah memahami seluruh klausul tagihan. Mulai dari kepastian token listrik (apakah mandiri atau patungan), biaya air, iuran kebersihan, serta keabsahan identitas pemilik kos.
                        </p>

                        <!-- Callout box -->
                        <div class="p-3 mb-4 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13.5px;">
                            <div class="font-weight-bold mb-2 text-dark"><i class="fa fa-shield-alt text-primary mr-2"></i> Proteksi Pembayaran Resmi:</div>
                            <ul class="mb-0 pl-3" style="color: var(--color-graphite); line-height: 1.65;">
                                <li><strong>Gunakan Rekening Resmi:</strong> Jangan pernah mengirim transfer ke rekening pribadi tanpa surat invoice atau tanda terima resmi.</li>
                                <li><strong>Status Deposit Jaminan:</strong> Minta kesepakatan tertulis tentang syarat pengembalian deposit (contoh: kondisi kamar bersih saat checkout).</li>
                                <li><strong>Fitur Escrow TEMPATIN:</strong> Manfaatkan penampungan pembayaran digital di mana uang sewa baru diteruskan setelah kamu sukses serah terima kunci.</li>
                            </ul>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: var(--border-hairline);">
                            <div class="d-flex align-items-center">
                                <span class="notion-character-mark mr-2" style="width: 28px; height: 28px; font-size: 11px;"><i class="fa fa-shield-alt"></i></span>
                                <span class="small font-weight-bold text-dark">Legal &amp; Finansial TEMPATIN</span>
                            </div>
                            <span class="badge badge-light border text-muted">Proteksi Escrow</span>
                        </div>
                    </article>

                    <!-- Article 3: Tipe Properti -->
                    <article class="p-4 mb-4 article-item" data-category="tipe" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: border-color 0.2s ease;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-light border text-primary font-weight-bold px-2 py-1 mr-2" style="font-size: 11px; letter-spacing: 0.04em;">TIPE PROPERTI</span>
                                <span class="text-muted small"><i class="fa fa-calendar-alt mr-1"></i> 28 Juli 2026</span>
                            </div>
                            <span class="text-muted small"><i class="fa fa-clock mr-1"></i> 5 Menit Baca</span>
                        </div>

                        <h2 style="font-size: 1.45rem; font-weight: 700; color: var(--color-ink-black); margin-bottom: 14px; line-height: 1.35; letter-spacing: -0.02em;">
                            Perbedaan Mendalam Kos Putra, Putri, Campur &amp; Eksklusif
                        </h2>

                        <div class="mb-4 overflow-hidden rounded" style="border: var(--border-hairline); max-height: 300px;">
                            <img src="{{ asset('assets/img/bg-bedroom.jpg') }}" alt="Perbedaan tipe kos" class="img-fluid w-100" style="object-fit: cover; width: 100%; height: 280px;">
                        </div>

                        <p style="font-size: 15px; color: var(--color-graphite); line-height: 1.65; margin-bottom: 16px;">
                            Setiap tipe kos mengusung peraturan dan dinamika interaksi yang berlainan. Memahami batas privasi, aturan jam malam, serta pembagian fasilitas bersama akan membantumu memilih hunian yang pas dengan ritme kuliah maupun pekerjaan sehari-hari.
                        </p>

                        <!-- Callout box -->
                        <div class="p-3 mb-4 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13.5px;">
                            <div class="font-weight-bold mb-2 text-dark"><i class="fa fa-layer-group text-primary mr-2"></i> Ringkasan Karakteristik:</div>
                            <ul class="mb-0 pl-3" style="color: var(--color-graphite); line-height: 1.65;">
                                <li><strong>Kos Putra &amp; Putri:</strong> Memiliki aturan pengunjung lawan jenis yang ketat, biasanya dibatasi di ruang tamu utama atau teras luar.</li>
                                <li><strong>Kos Campur:</strong> Biasanya dihuni oleh mahasiswa senior dan pekerja kantoran, dengan privasi lantai terpisah dan aturan tata tertib mandiri.</li>
                                <li><strong>Kos Eksklusif:</strong> Fasilitas setara apartemen (kamar mandi dalam, water heater, smart lock, cleaning rutin, dan parkir mobil luas).</li>
                            </ul>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: var(--border-hairline);">
                            <div class="d-flex align-items-center">
                                <span class="notion-character-mark mr-2" style="width: 28px; height: 28px; font-size: 11px;"><i class="fa fa-home"></i></span>
                                <span class="small font-weight-bold text-dark">Riset Komunitas Hunian</span>
                            </div>
                            <span class="badge badge-light border text-muted">Panduan Komprehensif</span>
                        </div>
                    </article>

                    <!-- Article 4: Budget & Finansial -->
                    <article class="p-4 mb-4 article-item" data-category="finansial" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); box-shadow: 0 1px 3px rgba(0,0,0,0.02); transition: border-color 0.2s ease;">
                        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-light border text-primary font-weight-bold px-2 py-1 mr-2" style="font-size: 11px; letter-spacing: 0.04em;">BUDGET &amp; FINANSIAL</span>
                                <span class="text-muted small"><i class="fa fa-calendar-alt mr-1"></i> 20 Juli 2026</span>
                            </div>
                            <span class="text-muted small"><i class="fa fa-clock mr-1"></i> 4 Menit Baca</span>
                        </div>

                        <h2 style="font-size: 1.45rem; font-weight: 700; color: var(--color-ink-black); margin-bottom: 14px; line-height: 1.35; letter-spacing: -0.02em;">
                            Simulasi Budget Sewa Kos: Biaya Pokok vs Biaya Tersembunyi
                        </h2>

                        <div class="mb-4 overflow-hidden rounded" style="border: var(--border-hairline); max-height: 300px;">
                            <img src="{{ asset('assets/img/bg-apartment-table.jpg') }}" alt="Simulasi budget sewa kos" class="img-fluid w-100" style="object-fit: cover; width: 100%; height: 280px;">
                        </div>

                        <p style="font-size: 15px; color: var(--color-graphite); line-height: 1.65; margin-bottom: 16px;">
                            Pengeluaran riil tempat tinggal anak rantau seringkali melebihi angka sewa pokok yang tertera di iklan. Pastikan kamu menghitung biaya variabel seperti token listrik AC, air galon minum, laundry, dan biaya parkir kendaraan bermotor.
                        </p>

                        <!-- Callout box -->
                        <div class="p-3 mb-4 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13.5px;">
                            <div class="font-weight-bold mb-2 text-dark"><i class="fa fa-calculator text-primary mr-2"></i> Rumus Alokasi Ideal:</div>
                            <ul class="mb-0 pl-3" style="color: var(--color-graphite); line-height: 1.65;">
                                <li><strong>Rasio Sewa Maksimal:</strong> Alokasikan tidak lebih dari 30% hingga 35% pendapatan bulanan untuk total sewa tempat tinggal.</li>
                                <li><strong>Dana Darurat Kos:</strong> Siapkan cadangan biaya deposit (setara 1 bulan sewa) di awal kedatangan untuk antisipasi pindah mendadak.</li>
                                <li><strong>Opsi Sewa Tahunan:</strong> Jika yakin betah minimal 1 tahun, negosiasikan diskon bayar tahunan yang biasanya hemat 1 hingga 2 bulan sewa.</li>
                            </ul>
                        </div>

                        <div class="d-flex align-items-center justify-content-between pt-3" style="border-top: var(--border-hairline);">
                            <div class="d-flex align-items-center">
                                <span class="notion-character-mark mr-2" style="width: 28px; height: 28px; font-size: 11px;"><i class="fa fa-chart-line"></i></span>
                                <span class="small font-weight-bold text-dark">Konsultan Finansial Muda</span>
                            </div>
                            <span class="badge badge-light border text-muted">Manajemen Finansial</span>
                        </div>
                    </article>

                </div>

                <!-- SIDEBAR -->
                <div class="col-lg-4">
                    <div style="position: sticky; top: 84px;">

                        <!-- Search Articles Widget -->
                        <div class="p-4 mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <h3 style="font-size: 13px; font-weight: 700; color: var(--color-ink-black); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px;">
                                <i class="fa fa-search text-muted mr-1"></i> Cari Artikel
                            </h3>
                            <div class="input-group">
                                <input type="text" id="articleSearchInput" class="form-control" placeholder="Ketik kata kunci..." style="border-radius: 8px 0 0 8px; font-size: 14px; height: 42px;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" style="border-radius: 0 8px 8px 0; padding: 0 16px;">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block" id="searchMatchCount">Menampilkan semua 4 artikel</small>
                        </div>

                        <!-- Categories Navigation -->
                        <div class="p-4 mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <h3 style="font-size: 13px; font-weight: 700; color: var(--color-ink-black); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 14px;">
                                <i class="fa fa-folder-open text-muted mr-1"></i> Topik &amp; Kategori Kos
                            </h3>
                            <div class="d-flex flex-column gap-2">
                                <a href="{{ route('kos.index', ['gender' => 'putra']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded text-decoration-none" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); font-size: 13px; font-weight: 500; transition: background 0.15s ease;">
                                    <span><i class="fa fa-male mr-2 text-primary"></i> Kos Putra</span>
                                    <span class="badge badge-light border">Filter &rarr;</span>
                                </a>
                                <a href="{{ route('kos.index', ['gender' => 'putri']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded text-decoration-none" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); font-size: 13px; font-weight: 500; transition: background 0.15s ease;">
                                    <span><i class="fa fa-female mr-2 text-primary"></i> Kos Putri</span>
                                    <span class="badge badge-light border">Filter &rarr;</span>
                                </a>
                                <a href="{{ route('kos.index', ['gender' => 'campur']) }}" class="d-flex align-items-center justify-content-between p-2 mb-2 rounded text-decoration-none" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); font-size: 13px; font-weight: 500; transition: background 0.15s ease;">
                                    <span><i class="fa fa-users mr-2 text-primary"></i> Kos Campur</span>
                                    <span class="badge badge-light border">Filter &rarr;</span>
                                </a>
                                <a href="{{ route('kos.index') }}" class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); font-size: 13px; font-weight: 500; transition: background 0.15s ease;">
                                    <span><i class="fa fa-gem mr-2 text-primary"></i> Kos Eksklusif</span>
                                    <span class="badge badge-light border">Filter &rarr;</span>
                                </a>
                            </div>
                        </div>

                        <!-- Help / Concierge Box -->
                        <div class="p-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 42px; height: 42px; border-radius: 10px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px;">
                                <i class="fa fa-comments"></i>
                            </div>
                            <h3 style="font-size: 16px; font-weight: 700; color: var(--color-ink-black); margin-bottom: 8px;">
                                Butuh Rekomendasi Kos?
                            </h3>
                            <p style="font-size: 13px; color: var(--color-graphite); line-height: 1.55; margin-bottom: 16px;">
                                Konsultasikan lokasi kampus atau kantor tujuan serta estimasi budget kamu dengan tim konsultan TEMPATIN.
                            </p>
                            <a href="{{ route('contact') }}" class="btn btn-primary btn-block font-weight-bold" style="font-size: 13px; padding: 10px 16px;">
                                <i class="fa fa-headset mr-1"></i> Buka Layanan Konsultasi
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
});
</script>
@endpush
@endsection
