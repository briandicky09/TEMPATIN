@extends('layouts.app')

@section('title', 'Kontak - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')

    @include('partials.alert')

    <main id="ts-main">

        <section id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kontak</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section id="page-title" class="py-4">
            <div class="container">
                <div class="ts-title">
                    <h1>Hubungi TEMPATIN</h1>
                    <p class="ts-opacity__70">Butuh bantuan atau ingin berbagi pertanyaan seputar kos? Tim kami siap membantu Anda dengan cepat.</p>
                </div>
            </div>
        </section>

        <section id="contact-info" class="pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body">
                                <h3 class="h5">Informasi Kontak</h3>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-3">
                                        <i class="fa fa-phone-alt mr-2 text-primary"></i>
                                        <strong>WhatsApp / Telepon:</strong><br>
                                        <a href="https://wa.me/6281234567890" target="_blank">+62 812-3456-7890</a>
                                    </li>
                                    <li class="mb-3">
                                        <i class="fa fa-envelope mr-2 text-primary"></i>
                                        <strong>Email Dukungan:</strong><br>
                                        <a href="mailto:hello@tempatin.id">hello@tempatin.id</a>
                                    </li>
                                    <li>
                                        <i class="fa fa-clock mr-2 text-primary"></i>
                                        <strong>Jam Operasional:</strong><br>
                                        Senin - Jumat, 08.00 - 20.00 WIB
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h3 class="h5">Kirim Pesan Bantuan</h3>
                                <form action="#" method="POST" class="mt-4">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Anda" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Anda" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subject">Subjek / Kategori Kendala</label>
                                        <select class="form-control" id="subject" name="subject">
                                            <option value="">Pilih kategori</option>
                                            <option value="pencarian-kos">Pencarian Kos</option>
                                            <option value="pembayaran">Pembayaran / Tagihan</option>
                                            <option value="akun">Akun / Login</option>
                                            <option value="mitra">Jadi Mitra Pemilik Kos</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Pesan</label>
                                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Tuliskan kendala atau pertanyaan Anda" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="office-address" class="pb-5">
            <div class="container">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="h5 mb-2">Alamat Kantor / Operational TEMPATIN</h3>
                                <p class="mb-0">
                                    Jl. Raya Sidoarjo No. 17, Sidoarjo, Jawa Timur.<br>
                                    Kantor kami melayani konsultasi seputar pencarian kos, kerja sama mitra, dan bantuan akun.
                                </p>
                            </div>
                            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                <a href="https://maps.google.com/?q=Jl.+Raya+Sidoarjo+No.+17" target="_blank" class="btn btn-outline-dark">Lihat di Google Maps</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
