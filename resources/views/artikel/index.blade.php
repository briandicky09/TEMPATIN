@extends('layouts.app')

@section('title', 'Artikel - TEMPATIN')

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
                        <li class="breadcrumb-item active" aria-current="page">Artikel</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section id="page-title" class="py-4">
            <div class="container">
                <div class="ts-title">
                    <h1>Artikel & Tips TEMPATIN</h1>
                    <p class="ts-opacity__70">Panduan praktis untuk mencari kos yang nyaman, aman, dan sesuai kebutuhanmu.</p>
                </div>
            </div>
        </section>

        <section id="articles" class="pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <h3 class="h5">Cara memilih kos yang aman dan nyaman</h3>
                                <img src="{{ asset('assets/img/artikel-1.png') }}" alt="Artikel: Cara memilih kos yang aman dan nyaman" class="img-fluid rounded mb-3" style="max-width: 360px; width: 100%; height: auto;">
                                <p class="text-muted">05 Agustus 2026</p>
                                <p>
                                    Memilih kos bukan sekadar mencari tempat tidur dan kamar mandi. Faktor keamanan, lokasi, fasilitas, dan kenyamanan lingkungan sangat memengaruhi kualitas hidup selama tinggal.
                                </p>
                                <ul>
                                    <li>Periksa akses keamanan 24 jam dan sistem pengawasan.</li>
                                    <li>Cek jarak ke kampus, pasar, dan transportasi umum.</li>
                                    <li>Pastikan fasilitas seperti Wi-Fi, parkir, dan kamar mandi dalam sesuai kebutuhan.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <h3 class="h5">5 hal yang wajib diperhatikan sebelum booking kos</h3>
                                <img src="{{ asset('assets/img/artikel-2.jpg') }}" alt="Artikel: 5 hal yang wajib diperhatikan sebelum booking kos" class="img-fluid rounded mb-3" style="max-width: 360px; width: 100%; height: auto;">
                                <p class="text-muted">02 Agustus 2026</p>
                                <p>
                                    Sebelum memesan kos, pastikan kamu sudah mengonfirmasi detail seperti harga sewa, aturan hunian, dan fasilitas yang termasuk dalam biaya. Hal ini membantu menghindari kejutan di kemudian hari.
                                </p>
                                <ul>
                                    <li>Konfirmasi total biaya bulanan dan deposit.</li>
                                    <li>Periksa aturan penghuni, jam malam, dan kebersihan.</li>
                                    <li>Bandingkan beberapa pilihan sebelum memutuskan.</li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <h3 class="h5">Kategori Populer</h3>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2"><a href="{{ route('search.kos') }}">Kos Putra</a></li>
                                    <li class="mb-2"><a href="{{ route('search.kos') }}">Kos Putri</a></li>
                                    <li class="mb-2"><a href="{{ route('search.kos') }}">Kos Campur</a></li>
                                    <li><a href="{{ route('search.kos') }}">Kos Eksklusif</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h3 class="h5">Butuh Bantuan?</h3>
                                <p>
                                    Tim TEMPATIN siap membantu Anda menemukan kos yang sesuai dengan kebutuhan dan budget.
                                </p>
                                <a href="{{ route('contact') }}" class="btn btn-primary">Hubungi Kami</a>
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
