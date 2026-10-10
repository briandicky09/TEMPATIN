@extends('layouts.app')

@section('title', 'Pusat Bantuan & Layanan Pengguna - TEMPATIN')

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
                        Pusat Bantuan
                    </li>
                </ol>
            </nav>
        </div>

        <!-- HERO HEADER WITH CONCIERGE IMAGE -->
        <section class="container mb-5">
            <div class="p-4 p-md-5 rounded overflow-hidden" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); border: 1px solid rgba(0, 117, 222, 0.2); font-size: 12px; font-weight: 700; color: var(--color-notion-blue); letter-spacing: 0.04em;">
                            <i class="fa fa-headset mr-2"></i> PUSAT BANTUAN &amp; LAYANAN PENGGUNA
                        </div>
                        <h1 style="font-family: var(--font-serif); font-size: clamp(2rem, 3.6vw, 2.75rem); font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.025em; line-height: 1.25;" class="mb-3">
                            Kami Siap Membantu Kenyamanan Tinggalmu.
                        </h1>
                        <p style="font-size: 15.5px; color: var(--color-stone); line-height: 1.65; margin-bottom: 24px; max-width: 620px;">
                            Temukan panduan cepat seputar reservasi kamar, perlindungan pembayaran escrow, voucher promo, pendaftaran pemilik kos, atau sampaikan pertanyaan langsung ke tim support kami.
                        </p>

                        <!-- SEARCH BAR -->
                        <div style="max-width: 540px;">
                            <div class="input-group">
                                <input type="text" id="helpSearchInput" class="form-control" placeholder="Cari bantuan, misal: escrow, refund, voucher, survei..." style="border-radius: 6px 0 0 6px; font-size: 14px; height: 46px; border: var(--border-hairline);">
                                <div class="input-group-append">
                                    <button class="btn" type="button" style="border-radius: 0 6px 6px 0; padding: 0 20px; background-color: var(--color-notion-blue); color: #ffffff; border: none; font-weight: 600;">
                                        <i class="fa fa-search mr-1"></i> Cari
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block" id="faqSearchFeedback" style="font-size: 12px;">Ketik kata kunci untuk menyaring pertanyaan yang sering diajukan.</small>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="position-relative rounded overflow-hidden shadow-sm" style="border: var(--border-hairline); max-height: 330px;">
                            <img src="{{ asset('assets/img/bantuan-support.jpg') }}" alt="Tim Layanan Konsumen TEMPATIN" class="img-fluid w-100" style="object-fit: cover; height: 310px; display: block;">
                            <div class="position-absolute" style="bottom: 12px; left: 12px; right: 12px; background: rgba(2, 9, 58, 0.88); backdrop-filter: blur(8px); padding: 10px 14px; border-radius: 8px; color: #ffffff; font-size: 12px; border: 1px solid rgba(255,255,255,0.15);">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span><i class="fa fa-clock text-primary mr-1"></i> Respon Cepat</span>
                                    <span class="font-weight-bold" style="color: #ffffff;">Senin – Minggu</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- HELP CATEGORIES (5 BENTO TILES) -->
        <section class="container mb-5">
            <div class="row">
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="p-4 rounded h-100 faq-category-tile" data-cat="survei" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); cursor: pointer; transition: all 0.2s ease;">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 10px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px;">
                            <i class="fa fa-search-location"></i>
                        </div>
                        <h4 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Pencarian &amp; Survei</h4>
                        <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.5;">Verifikasi foto, jadwal kunjungan lokasi, dan fasilitas kamar.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="p-4 rounded h-100 faq-category-tile" data-cat="booking" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); cursor: pointer; transition: all 0.2s ease;">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 10px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px;">
                            <i class="fa fa-calendar-check"></i>
                        </div>
                        <h4 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Booking &amp; Reservasi</h4>
                        <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.5;">Pemilihan kamar, durasi sewa, dan konfirmasi pemilik.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-3">
                    <div class="p-4 rounded h-100 faq-category-tile" data-cat="pembayaran" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); cursor: pointer; transition: all 0.2s ease;">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 10px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px;">
                            <i class="fa fa-credit-card"></i>
                        </div>
                        <h4 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Pembayaran &amp; Invoice</h4>
                        <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.5;">Proteksi escrow, metode pembayaran, dan bukti invoice resmi.</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 mb-3">
                    <div class="p-4 rounded h-100 faq-category-tile" data-cat="akun" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); cursor: pointer; transition: all 0.2s ease;">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 10px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px;">
                            <i class="fa fa-user-shield"></i>
                        </div>
                        <h4 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Akun &amp; Keamanan Data</h4>
                        <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.5;">Pengaturan profil, reset kata sandi, dan privasi penghuni.</p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                    <div class="p-4 rounded h-100 faq-category-tile" data-cat="mitra" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards); cursor: pointer; transition: all 0.2s ease;">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 44px; height: 44px; border-radius: 10px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 18px;">
                            <i class="fa fa-building"></i>
                        </div>
                        <h4 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Mitra Pemilik Kos</h4>
                        <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0; line-height: 1.5;">Pendaftaran properti, verifikasi listing, dan pencairan dana sewa.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ACCORDION FAQ SECTION -->
        <section class="container mb-5">
            <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 pb-3" style="border-bottom: var(--border-hairline);">
                    <div>
                        <div class="d-inline-flex align-items-center mb-1 px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 700; letter-spacing: 0.05em;">
                            PERTANYAAN UMUM
                        </div>
                        <h2 style="font-family: var(--font-serif); font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.02em; margin-bottom: 0;">
                            Jawaban Seputar Layanan TEMPATIN
                        </h2>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-sm btn-filter-faq active font-weight-bold px-3 py-1 mr-1" data-target-cat="all" style="border-radius: 9999px; font-size: 12.5px; background-color: var(--color-notion-blue); color: #ffffff; border: 1px solid rgba(0,0,0,0.1);">
                            Semua FAQ
                        </button>
                    </div>
                </div>

                <div id="faqAccordionList">

                    <!-- FAQ 1 -->
                    <div class="faq-item p-3 mb-3 rounded" data-category="survei" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                        <div class="faq-header d-flex justify-content-between align-items-center" style="cursor: pointer;">
                            <h3 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
                                <i class="fa fa-question-circle text-primary mr-2"></i> Apakah foto dan fasilitas kos di TEMPATIN dijamin akurat?
                            </h3>
                            <i class="fa fa-chevron-down text-muted faq-icon" style="transition: transform 0.2s ease;"></i>
                        </div>
                        <div class="faq-body mt-3 pt-3" style="display: none; border-top: 1px solid rgba(0,0,0,0.06); font-size: 14px; color: var(--color-stone); line-height: 1.65;">
                            Ya, 100% akurat. Seluruh kos berlabel <strong class="text-dark">Verified</strong> telah melalui proses kurasi fisik langsung oleh tim surveior TEMPATIN. Kami memeriksa langsung kondisi kamar mandi, ventilasi jendela, furnitur, hingga kestabilan jaringan WiFi sebelum listing diterbitkan.
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="faq-item p-3 mb-3 rounded" data-category="pembayaran" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                        <div class="faq-header d-flex justify-content-between align-items-center" style="cursor: pointer;">
                            <h3 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
                                <i class="fa fa-shield-alt text-primary mr-2"></i> Bagaimana jaminan keamanan uang sewa dengan sistem Escrow?
                            </h3>
                            <i class="fa fa-chevron-down text-muted faq-icon" style="transition: transform 0.2s ease;"></i>
                        </div>
                        <div class="faq-body mt-3 pt-3" style="display: none; border-top: 1px solid rgba(0,0,0,0.06); font-size: 14px; color: var(--color-stone); line-height: 1.65;">
                            Uang pembayaran sewa yang kamu bayarkan tidak langsung masuk ke rekening pemilik kos. Dana ditampung secara aman oleh rekening penampungan resmi TEMPATIN. Pemilik kos baru menerima dana setelah kamu resmi tiba di lokasi, memeriksa kamar, dan melakukan konfirmasi check-in di sistem.
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="faq-item p-3 mb-3 rounded" data-category="booking" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                        <div class="faq-header d-flex justify-content-between align-items-center" style="cursor: pointer;">
                            <h3 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
                                <i class="fa fa-door-open text-primary mr-2"></i> Bisakah saya memilih nomor kamar spesifik sebelum memesan?
                            </h3>
                            <i class="fa fa-chevron-down text-muted faq-icon" style="transition: transform 0.2s ease;"></i>
                        </div>
                        <div class="faq-body mt-3 pt-3" style="display: none; border-top: 1px solid rgba(0,0,0,0.06); font-size: 14px; color: var(--color-stone); line-height: 1.65;">
                            Tentu bisa. Di halaman detail setiap properti kos, kamu dapat melihat daftar nomor kamar aktif, posisi lantai, dan tipe kamar (kamar mandi dalam/luar) yang tersedia untuk direservasi secara real-time.
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="faq-item p-3 mb-3 rounded" data-category="pembayaran" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                        <div class="faq-header d-flex justify-content-between align-items-center" style="cursor: pointer;">
                            <h3 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
                                <i class="fa fa-tags text-primary mr-2"></i> Bagaimana cara menggunakan voucher diskon atau cashback?
                            </h3>
                            <i class="fa fa-chevron-down text-muted faq-icon" style="transition: transform 0.2s ease;"></i>
                        </div>
                        <div class="faq-body mt-3 pt-3" style="display: none; border-top: 1px solid rgba(0,0,0,0.06); font-size: 14px; color: var(--color-stone); line-height: 1.65;">
                            Kunjungi menu <a href="{{ route('promo') }}" class="text-primary font-weight-bold">Promo &amp; Voucher</a>, salin kode yang sesuai (seperti <code>KOSBARU20</code> atau <code>FREEADMIN</code>), lalu tempelkan pada formulir konfirmasi tagihan pembayaran saat melakukan booking.
                        </div>
                    </div>

                    <!-- FAQ 5 -->
                    <div class="faq-item p-3 mb-3 rounded" data-category="mitra" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                        <div class="faq-header d-flex justify-content-between align-items-center" style="cursor: pointer;">
                            <h3 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
                                <i class="fa fa-building text-primary mr-2"></i> Bagaimana cara mendaftarkan bangunan kos saya sebagai mitra?
                            </h3>
                            <i class="fa fa-chevron-down text-muted faq-icon" style="transition: transform 0.2s ease;"></i>
                        </div>
                        <div class="faq-body mt-3 pt-3" style="display: none; border-top: 1px solid rgba(0,0,0,0.06); font-size: 14px; color: var(--color-stone); line-height: 1.65;">
                            Daftarkan akun Anda melalui halaman registrasi mitra pemilik di <a href="{{ route('register') }}" class="text-primary font-weight-bold">Daftar Pemilik</a>. Setelah akun aktif, masuk ke dashboard pemilik dan isi formulir "Tambah Kos Baru" beserta foto dan tarif sewa. Tim kami akan melakukan kurasi verifikasi maksimal 1x24 jam kerja.
                        </div>
                    </div>

                    <!-- FAQ 6 -->
                    <div class="faq-item p-3 mb-0 rounded" data-category="akun" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                        <div class="faq-header d-flex justify-content-between align-items-center" style="cursor: pointer;">
                            <h3 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
                                <i class="fa fa-lock text-primary mr-2"></i> Lupa kata sandi atau ingin memperbarui nomor kontak akun?
                            </h3>
                            <i class="fa fa-chevron-down text-muted faq-icon" style="transition: transform 0.2s ease;"></i>
                        </div>
                        <div class="faq-body mt-3 pt-3" style="display: none; border-top: 1px solid rgba(0,0,0,0.06); font-size: 14px; color: var(--color-stone); line-height: 1.65;">
                            Anda dapat mengatur ulang kata sandi melalui tautan <a href="{{ route('password.request') }}" class="text-primary font-weight-bold">Lupa Kata Sandi</a>. Setelah login, informasi nomor telepon dan profil dapat diperbarui pada menu profil akun pengguna.
                        </div>
                    </div>

                </div>

                <!-- EMPTY STATE -->
                <div id="faqEmptyState" class="p-4 text-center rounded d-none" style="background-color: var(--surface-page-canvas); border: 1px dashed rgba(0,0,0,0.12);">
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 10px;">
                        Tidak ada pertanyaan yang sesuai dengan kata kunci pencarian.
                    </p>
                    <button type="button" id="btnResetFaq" class="btn btn-sm" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; padding: 6px 14px; border-radius: var(--radius-buttons);">
                        Reset Pencarian
                    </button>
                </div>
            </div>
        </section>

        <!-- CONTACT CHANNELS & FORM GRID -->
        <section class="container mb-5">
            <div class="row">

                <!-- LEFT COLUMN: SUPPORT CHANNELS -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="d-flex flex-column gap-3">

                        <!-- WhatsApp Support Card -->
                        <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div class="d-flex align-items-center mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center mr-3 rounded" style="width: 44px; height: 44px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 1.25rem;">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div>
                                    <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--color-stone); letter-spacing: 0.05em;">CHAT CEPAT</div>
                                    <div style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink);">WhatsApp Support</div>
                                </div>
                            </div>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 14px; line-height: 1.55;">Konsultasi rekomendasi kos, konfirmasi check-in, dan respon cepat kendala reservasi.</p>
                            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-sm d-inline-flex align-items-center" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 12.5px; border-radius: var(--radius-buttons); padding: 8px 16px; text-decoration: none;">
                                <i class="fab fa-whatsapp mr-2"></i> +62 812-3456-7890
                            </a>
                        </div>

                        <!-- Email Support Card -->
                        <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div class="d-flex align-items-center mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center mr-3 rounded" style="width: 44px; height: 44px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.15); font-size: 1.25rem;">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div>
                                    <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--color-stone); letter-spacing: 0.05em;">EMAIL RESMI</div>
                                    <div style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink);">Dukungan Tiket</div>
                                </div>
                            </div>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 14px; line-height: 1.55;">Kirimkan bukti transfer bank, permohonan kemitraan, atau pertanyaan legalitas.</p>
                            <a href="mailto:hello@tempatin.id" class="btn btn-sm d-inline-flex align-items-center" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); font-weight: 600; font-size: 12.5px; border: var(--border-hairline); border-radius: var(--radius-buttons); padding: 8px 16px; text-decoration: none;">
                                hello@tempatin.id
                            </a>
                        </div>

                        <!-- Working Hours -->
                        <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-clock mr-2 text-primary"></i>
                                <span style="font-size: 13.5px; font-weight: 700; color: var(--color-midnight-ink);">Jam Operasional Konsultan</span>
                            </div>
                            <div style="font-size: 13px; color: var(--color-stone); line-height: 1.6;">
                                <div>Senin – Jumat: 08.00 – 20.00 WIB</div>
                                <div>Sabtu – Minggu: 09.00 – 17.00 WIB</div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT COLUMN: CONTACT FORM -->
                <div class="col-lg-8">
                    <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div class="d-inline-flex align-items-center mb-2 px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 700; letter-spacing: 0.05em;">
                            HUBUNGI KAMI
                        </div>
                        <h2 style="font-family: var(--font-serif); font-size: 1.65rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">
                            Kirim Tiket Pertanyaan atau Kendala
                        </h2>
                        <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 24px;">
                            Isi formulir di bawah ini dengan lengkap. Tim customer care TEMPATIN akan merespons pesan kamu melalui email dalam waktu maksimal 1x24 jam kerja.
                        </p>

                        <form action="#" method="POST" id="supportInquiryForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="name" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="cth. Brian Dicky" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="email" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Alamat Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@email.com" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="subject" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Kategori Pertanyaan</label>
                                <select class="form-control" id="subject" name="subject" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; height: 44px; padding: 0 14px;">
                                    <option value="">Pilih kategori bantuan...</option>
                                    <option value="pencarian-kos">Pencarian &amp; Survei Lokasi Kos</option>
                                    <option value="booking">Reservasi &amp; Ketersediaan Kamar</option>
                                    <option value="pembayaran">Pembayaran &amp; Invoice Escrow</option>
                                    <option value="voucher">Klaim Voucher Promo</option>
                                    <option value="mitra">Daftar Menjadi Pemilik Properti</option>
                                    <option value="lainnya">Pertanyaan Lainnya</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label for="message" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Detail Pertanyaan</label>
                                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Tuliskan kendala atau pertanyaan kamu secara rinci..." required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 12px 14px; line-height: 1.5;"></textarea>
                            </div>

                            <button type="submit" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 14px; padding: 12px 28px; border-radius: var(--radius-buttons); border: none;">
                                <i class="fa fa-paper-plane mr-2"></i> Kirim Tiket Dukungan
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </section>

        <!-- OFFICE LOCATION SECTION -->
        <section class="container">
            <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                <div class="row align-items-center">
                    <div class="col-lg-8 mb-3 mb-lg-0">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-map-marker-alt mr-2 text-primary"></i>
                            <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Kantor Pusat TEMPATIN</h3>
                        </div>
                        <p style="font-size: 14px; color: var(--color-stone); line-height: 1.6; margin-bottom: 0;">
                            Gedung TEMPATIN Hub, Jl. Raya Sidoarjo No. 17, Sidoarjo, Jawa Timur 61212.<br>
                            Melayani verifikasi pemilik hunian, kerja sama kampus, dan konsultasi tatap muka dengan reservasi jadwal sebelumnya.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-right">
                        <a href="https://maps.google.com/?q=Jl.+Raya+Sidoarjo+No.+17" target="_blank" class="btn d-inline-flex align-items-center" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 10px 18px; text-decoration: none;">
                            <i class="fa fa-external-link-alt mr-2"></i> Petunjuk Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>

<!-- TOAST NOTIFICATION -->
<div id="contactToast" style="position: fixed; bottom: 24px; right: 24px; z-index: 9999; background: var(--color-midnight-ink); color: #ffffff; padding: 14px 22px; border-radius: 8px; box-shadow: 0 4px 14px rgba(0,0,0,0.18); font-size: 13.5px; font-weight: 600; display: none; align-items: center; gap: 8px;">
    <i class="fa fa-check-circle text-primary"></i> <span>Terima kasih! Pesan kamu berhasil dikirim ke tim support TEMPATIN.</span>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Accordion Toggle
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const header = item.querySelector('.faq-header');
        const body = item.querySelector('.faq-body');
        const icon = item.querySelector('.faq-icon');

        header.addEventListener('click', function () {
            const isOpen = body.style.display === 'block';
            if (isOpen) {
                body.style.display = 'none';
                icon.style.transform = 'rotate(0deg)';
                item.style.backgroundColor = 'var(--surface-page-canvas)';
            } else {
                body.style.display = 'block';
                icon.style.transform = 'rotate(180deg)';
                item.style.backgroundColor = '#ffffff';
                item.style.border = '1px solid rgba(0, 117, 222, 0.3)';
            }
        });
    });

    // Category Tile Clicks
    const categoryTiles = document.querySelectorAll('.faq-category-tile');
    categoryTiles.forEach(tile => {
        tile.addEventListener('click', function () {
            const cat = this.getAttribute('data-cat');
            filterFaqs(cat, '');
            // Scroll to accordion
            const accList = document.getElementById('faqAccordionList');
            if (accList) {
                accList.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // FAQ Search & Filter
    const searchInput = document.getElementById('helpSearchInput');
    const emptyState = document.getElementById('faqEmptyState');
    const btnResetFaq = document.getElementById('btnResetFaq');
    const feedbackText = document.getElementById('faqSearchFeedback');

    function filterFaqs(cat, query) {
        let visibleCount = 0;
        faqItems.forEach(item => {
            const itemCat = item.getAttribute('data-category');
            const title = item.querySelector('h3').textContent.toLowerCase();
            const body = item.querySelector('.faq-body').textContent.toLowerCase();

            const matchCat = (cat === 'all' || itemCat === cat);
            const matchQuery = (query === '' || title.includes(query) || body.includes(query));

            if (matchCat && matchQuery) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (emptyState) {
            if (visibleCount === 0) {
                emptyState.classList.remove('d-none');
            } else {
                emptyState.classList.add('d-none');
            }
        }

        if (feedbackText && query !== '') {
            feedbackText.textContent = `Ditemukan ${visibleCount} topik FAQ untuk "${query}"`;
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            filterFaqs('all', query);
        });
    }

    if (btnResetFaq) {
        btnResetFaq.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            filterFaqs('all', '');
            if (feedbackText) feedbackText.textContent = 'Ketik kata kunci untuk menyaring pertanyaan yang sering diajukan.';
        });
    }

    // Support Form submit
    const inquiryForm = document.getElementById('supportInquiryForm');
    const contactToast = document.getElementById('contactToast');
    if (inquiryForm) {
        inquiryForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (contactToast) {
                contactToast.style.display = 'flex';
                setTimeout(() => {
                    contactToast.style.display = 'none';
                }, 3500);
            }
            inquiryForm.reset();
        });
    }
});
</script>
@endpush
@endsection
