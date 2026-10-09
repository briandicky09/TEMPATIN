@extends('layouts.app')

@section('title', 'Promo TEMPATIN - Penawaran Kos Terbaik')

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')

    @include('partials.alert')

    <main id="ts-main">

        <section id="breadcrumb" class="py-4">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Promo</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section id="promo-hero" class="ts-block pt-5 pb-5" style="background-image: url('{{ asset('assets/img/bg-bedroom.jpg') }}'); background-size: cover; background-position: center;">
            <div class="container">
                <div class="row justify-content-center text-center text-white">
                    <div class="col-lg-8">
                        <div class="ts-box ts-shadow__lg py-5 px-4" data-bg-color="rgba(0,0,0,.55)">
                            <span class="badge badge-primary mb-3">Promo Eksklusif</span>
                            <h1 class="mb-3">Diskon Spesial untuk Kos Impianmu</h1>
                            <p class="lead ts-opacity__70 mb-4">Temukan pilihan kos putra, putri, campur, dan eksklusif dengan penawaran harga terbaik khusus dari TEMPATIN.</p>
                            <a href="{{ route('kos.index') }}" class="btn btn-light btn-lg">Cari Kos Promo</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="promo-benefits" class="ts-block py-5">
            <div class="container">
                <div class="ts-title text-center mb-5">
                    <h2>Kenapa Promo TEMPATIN?</h2>
                    <p class="ts-text-color-light">Penawaran khusus dengan layanan terpercaya, cocok untuk mahasiswa dan penghuni baru yang ingin sewa kos cepat.</p>
                </div>

                <div class="row text-center">
                    <div class="col-sm-6 col-lg-3 mb-4">
                        <div class="ts-card ts-card-body h-100">
                            <i class="fa fa-tags fa-3x text-primary mb-3"></i>
                            <h5>Harga Terjangkau</h5>
                            <p>Pilih kos dengan potongan harga khusus setiap minggu.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 mb-4">
                        <div class="ts-card ts-card-body h-100">
                            <i class="fa fa-map-marker-alt fa-3x text-primary mb-3"></i>
                            <h5>Lokasi Strategis</h5>
                            <p>Promo tersedia di kos dekat kampus, stasiun, dan pusat kota.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 mb-4">
                        <div class="ts-card ts-card-body h-100">
                            <i class="fa fa-check-circle fa-3x text-primary mb-3"></i>
                            <h5>Kos Terverifikasi</h5>
                            <p>Setiap kamar promo sudah diverifikasi oleh tim TEMPATIN.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 mb-4">
                        <div class="ts-card ts-card-body h-100">
                            <i class="fa fa-clock fa-3x text-primary mb-3"></i>
                            <h5>Booking Cepat</h5>
                            <p>Proses pemesanan mudah, tanpa survey panjang.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="promo-offers" class="ts-block py-5 bg-white" style="background-color: #f8f9fa;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <img src="{{ asset('assets/img/img-promo-01.jpg') }}" alt="Promo Kos" class="img-fluid rounded shadow-sm">
                    </div>
                    <div class="col-lg-6">
                        <div class="ts-title mb-4">
                            <h2>Penawaran Terbaru</h2>
                            <p class="ts-text-color-light">Promo ini dirancang untuk membantu kamu mendapatkan kos terbaik dengan nilai lebih.</p>
                        </div>
                        <ul class="list-unstyled ts-list-icon">
                            <li><i class="fa fa-check text-primary mr-2"></i>Diskon sambutan hingga 20% untuk kos pilihan.</li>
                            <li><i class="fa fa-check text-primary mr-2"></i>Gratis biaya administrasi untuk pemesanan dalam 7 hari.</li>
                            <li><i class="fa fa-check text-primary mr-2"></i>Promo sewa bulanan dan musiman di kota besar.</li>
                            <li><i class="fa fa-check text-primary mr-2"></i>Dukungan pelanggan 24 jam selama proses booking.</li>
                        </ul>
                        <a href="{{ route('kos.index') }}" class="btn btn-primary mt-3">Lihat Semua Promo</a>
                    </div>
                </div>
            </div>
        </section>

        <section id="promo-stats" class="py-5 text-white ts-separate-bg-element" data-bg-color="#000037" data-bg-image="{{ asset('assets/img/bg-apartment-table.jpg') }}" data-bg-image-opacity=".3">
            <div class="container py-5">
                <div class="ts-promo-numbers">
                    <div class="row">
                        <div class="col-sm-3 mb-4">
                            <div class="ts-promo-number">
                                <h2>5.200+</h2>
                                <h4 class="mb-0 ts-opacity__50">Kos Terdaftar</h4>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="ts-promo-number">
                                <h2>120</h2>
                                <h4 class="mb-0 ts-opacity__50">Kota &amp; Kabupaten</h4>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="ts-promo-number">
                                <h2>38.000+</h2>
                                <h4 class="mb-0 ts-opacity__50">Penghuni Puas</h4>
                            </div>
                        </div>
                        <div class="col-sm-3 mb-4">
                            <div class="ts-promo-number">
                                <h2>750+</h2>
                                <h4 class="mb-0 ts-opacity__50">Mitra Pemilik Kos</h4>
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
