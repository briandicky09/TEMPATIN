@extends('layouts.app')

@section('title', 'Tentang TEMPATIN - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')

    @include('partials.alert')

    <main id="ts-main">

        <section id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tentang</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section id="page-title" class="py-4">
            <div class="container">
                <div class="ts-title">
                    <h1>Tentang TEMPATIN</h1>
                    <p class="ts-opacity__70">Temukan cara cepat dan aman mencari kos di Indonesia bersama TEMPATIN.</p>
                </div>
            </div>
        </section>

        <section id="about-us-description" class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <p class="h3 mb-4">
                            TEMPATIN hadir untuk membantu pencari kos and pemilik kos terhubung lebih mudah.
                        </p>
                        <p class="mb-4">
                            Dengan ribuan pilihan kos putra, putri, campur, dan eksklusif, kami menyediakan informasi lengkap yang mempermudah proses pencarian dan booking.
                        </p>
                        <p class="mb-4">
                            Mulai dari filter kota, kampus, dan lokasi, hingga dukungan customer service yang siap membantu, TEMPATIN bertujuan menjadi platform terbaik untuk hunian kos di Indonesia.
                        </p>
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar Jadi Mitra Pemilik Kos</a>
                    </div>
                    <div class="col-lg-4"></div>
                </div>
            </div>
        </section>

        <section id="about-us-team" class="pb-5 bg-white" style="background-color: #f8f9fa;">
            <div class="container">
                <div class="ts-title text-center mb-4">
                    <h2>Tim TEMPATIN</h2>
                    <p class="ts-text-color-light">Kami bekerja untuk mendukung pengalaman kos yang aman dan nyaman.</p>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card ts-person ts-card h-100">
                            <a href="#" class="card-img" data-bg-image="{{ asset('assets/img/img-person-01.jpg') }}"></a>
                            <div class="card-body">
                                <h4>Rina Salsabila</h4>
                                <p class="mb-2"><i class="fa fa-briefcase mr-2"></i>Founder & CEO</p>
                                <p>Memimpin TEMPATIN agar pengguna dapat menemukan kos impian mereka dengan mudah.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card ts-person ts-card h-100">
                            <a href="#" class="card-img" data-bg-image="{{ asset('assets/img/img-person-02.jpg') }}"></a>
                            <div class="card-body">
                                <h4>Andi Prasetyo</h4>
                                <p class="mb-2"><i class="fa fa-users mr-2"></i>Head of Partnership</p>
                                <p>Menghubungkan pemilik kos dengan calon penghuni agar hunian cepat terisi.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card ts-person ts-card h-100">
                            <a href="#" class="card-img" data-bg-image="{{ asset('assets/img/img-person-03.jpg') }}"></a>
                            <div class="card-body">
                                <h4>Fitri Anindya</h4>
                                <p class="mb-2"><i class="fa fa-headset mr-2"></i>Customer Support</p>
                                <p>Siap membantu setiap pertanyaan selama proses pencarian dan pemesanan kos.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about-us-testimonials-carousel" class="py-5">
            <div class="bg-white text-center py-5" data-bg-color="#f6f6f6">
                <div class="container">
                    <div class="offset-lg-2 col-lg-8 mx-auto">
                        <div class="owl-carousel" data-owl-items="1" data-owl-dots="1">
                            <div class="ts-slide">
                                <div class="ts-circle__sm mx-auto" data-bg-image="{{ asset('assets/img/img-person-04.jpg') }}"></div>
                                <h5 class="my-3">Aditya</h5>
                                <p class="h5 font-weight-normal ts-text-color-light">
                                    Cari kos dekat kampus jadi gampang lewat TEMPATIN. Info lengkap dan prosesnya cepat.
                                </p>
                            </div>
                            <div class="ts-slide">
                                <div class="ts-circle__sm mx-auto" data-bg-image="{{ asset('assets/img/img-person-05.jpg') }}"></div>
                                <h5 class="my-3">Nina</h5>
                                <p class="h5 font-weight-normal ts-text-color-light">
                                    Sebagai pemilik kos, saya terbantu sekali dengan tampilan listing yang menarik.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about-us-numbers" class="py-5 text-white text-center ts-separate-bg-element" data-bg-color="#000037" data-bg-image="{{ asset('assets/img/bg-apartment-table.jpg') }}" data-bg-image-opacity=".3">
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
                                <h4 class="mb-0 ts-opacity__50">Kota & Kabupaten</h4>
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

        <section id="partners" class="ts-block py-4">
            <div class="container">
                <div class="d-block d-md-flex justify-content-between align-items-center text-center ts-partners py-3">
                    <a href="#"><img src="{{ asset('assets/img/logo-01.png') }}" alt=""></a>
                    <a href="#"><img src="{{ asset('assets/img/logo-02.png') }}" alt=""></a>
                    <a href="#"><img src="{{ asset('assets/img/logo-03.png') }}" alt=""></a>
                    <a href="#"><img src="{{ asset('assets/img/logo-04.png') }}" alt=""></a>
                    <a href="#"><img src="{{ asset('assets/img/logo-05.png') }}" alt=""></a>
                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
