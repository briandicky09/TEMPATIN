@extends('layouts.app')

@section('title', 'Kontak & Bantuan - TEMPATIN')

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
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Kontak</li>
                </ol>
            </nav>
        </div>

        <!-- HERO HEADER -->
        <section class="container mb-5">
            <div style="max-width: 760px;">
                <div class="d-inline-flex align-items-center mb-3 px-3 py-1 rounded-pill" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0, 0, 0, 0.1); font-size: 13px; font-weight: 600; color: var(--color-charcoal);">
                    <i class="fa fa-headset mr-2"></i> Bantuan & Layanan Pelanggan
                </div>
                <h1 style="font-family: var(--font-serif); font-size: clamp(2rem, 3.5vw, 2.75rem); font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.02em; line-height: 1.25;" class="mb-3">
                    Kami Siap Membantu Kapan Saja.
                </h1>
                <p style="font-size: 16px; color: var(--color-stone); line-height: 1.6; margin-bottom: 0;">
                    Punya pertanyaan seputar sewa kos, kendala pembayaran, atau ingin bermitra sebagai pemilik kos? Hubungi tim support TEMPATIN.
                </p>
            </div>
        </section>

        <!-- CONTACT GRID -->
        <section class="container mb-5">
            <div class="row">

                <!-- LEFT COLUMN: SUPPORT CHANNELS -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="d-flex flex-column gap-3">

                        <!-- WhatsApp Support Card -->
                        <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div class="d-flex align-items-center mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center mr-3 rounded" style="width: 44px; height: 44px; background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-size: 1.25rem;">
                                    <i class="fab fa-whatsapp"></i>
                                </div>
                                <div>
                                    <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--color-stone); letter-spacing: 0.05em;">CHAT CEPAT</div>
                                    <div style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink);">WhatsApp Support</div>
                                </div>
                            </div>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 12px; line-height: 1.5;">Respon cepat dalam hitungan menit untuk konsultasi kos & kendala reservasi.</p>
                            <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-sm d-inline-flex align-items-center" style="background-color: #191919; color: #ffffff; font-weight: 600; font-size: 12px; border-radius: var(--radius-buttons); padding: 8px 14px;">
                                <i class="fab fa-whatsapp mr-2"></i> +62 812-3456-7890
                            </a>
                        </div>

                        <!-- Email Support Card -->
                        <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div class="d-flex align-items-center mb-3">
                                <div class="d-inline-flex align-items-center justify-content-center mr-3 rounded" style="width: 44px; height: 44px; background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-size: 1.25rem;">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div>
                                    <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--color-stone); letter-spacing: 0.05em;">EMAIL RESMI</div>
                                    <div style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink);">Dukungan Tiket</div>
                                </div>
                            </div>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 12px; line-height: 1.5;">Kirim detail kendala akun, bukti transfer, atau tawaran kerjasama bisnis.</p>
                            <a href="mailto:hello@tempatin.id" class="btn btn-sm d-inline-flex align-items-center" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); font-weight: 600; font-size: 12px; border: var(--border-hairline); border-radius: var(--radius-buttons); padding: 8px 14px;">
                                hello@tempatin.id
                            </a>
                        </div>

                        <!-- Working Hours -->
                        <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fa fa-clock mr-2 text-muted"></i>
                                <span style="font-size: 13px; font-weight: 700; color: var(--color-midnight-ink);">Jam Operasional CS</span>
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
                        <h2 style="font-family: var(--font-serif); font-size: 1.5rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">
                            Kirim Pesan atau Pertanyaan
                        </h2>
                        <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 24px;">
                            Isi formulir di bawah ini. Tim kami akan membalas pesan kamu melalui email dalam waktu maksimal 1x24 jam kerja.
                        </p>

                        <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Terima kasih! Pesan Anda telah terkirim ke tim support TEMPATIN.');">
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
                                <label for="subject" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Kategori Kendala</label>
                                <select class="form-control" id="subject" name="subject" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; height: 44px; padding: 0 14px;">
                                    <option value="">Pilih kategori bantuan...</option>
                                    <option value="pencarian-kos">Pencarian & Survei Kos</option>
                                    <option value="pembayaran">Pembayaran & Invoice Tagihan</option>
                                    <option value="akun">Kendala Akun & Autentikasi</option>
                                    <option value="mitra">Daftar Jadi Mitra Pemilik Kos</option>
                                    <option value="lainnya">Pertanyaan Lainnya</option>
                                </select>
                            </div>

                            <div class="form-group mb-4">
                                <label for="message" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Detail Pesan</label>
                                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Tuliskan pesan atau kendala yang kamu hadapi secara lengkap..." required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 12px 14px; line-height: 1.5;"></textarea>
                            </div>

                            <button type="submit" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 14px; padding: 12px 28px; border-radius: var(--radius-buttons); border: none;">
                                <i class="fa fa-paper-plane mr-2"></i> Kirim Pesan Sekarang
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
                            <i class="fa fa-map-marker-alt mr-2" style="color: var(--color-charcoal);"></i>
                            <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">Kantor Operasional TEMPATIN</h3>
                        </div>
                        <p style="font-size: 14px; color: var(--color-stone); line-height: 1.6; margin-bottom: 0;">
                            Gedung TEMPATIN Hub, Jl. Raya Sidoarjo No. 17, Sidoarjo, Jawa Timur 61212.<br>
                            Melayani verifikasi pemilik hunian, kerja sama kampus, dan konsultasi kos secara langsung dengan janji temu.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-right">
                        <a href="https://maps.google.com/?q=Jl.+Raya+Sidoarjo+No.+17" target="_blank" class="btn d-inline-flex align-items-center" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 10px 18px;">
                            <i class="fa fa-external-link-alt mr-2"></i> Buka di Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
