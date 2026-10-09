@extends('layouts.app')

@section('title', 'TEMPATIN - Temukan Kos Impianmu dengan Mudah')

@section('content')
<div class="ts-page-wrapper ts-homepage" id="page-top">

    <!--*********************************************************************************************************-->
    <!--HEADER **************************************************************************************************-->
    <!--*********************************************************************************************************-->
    @include('partials.navbar')

    @include('partials.alert')
    <!--end Header-->

    <!--*********************************************************************************************************-->
    <!--HERO ****************************************************************************************************-->
    <!--*********************************************************************************************************-->
    <section id="ts-hero" class="ts-separate-bg-element mb-0" data-bg-image="{{ asset('assets/img/bg-bedroom.jpg') }}" data-bg-color="#fff" data-bg-image-opacity=".55">

        <div class="container text-dark py-5">
            <div class="row ts-center__both ts-h__auto ts-min-h__40vh">

                <!-- LEFT SIDE (TITLE)
                =====================================================================================================-->
                <div class="col-md-12 text-center mb-4" style="position: relative;">
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 320px; height: 320px; background-image: url('{{ asset('assets/img/bg-bedroom.jpg') }}'); background-size: cover; background-position: center; opacity: 0.18; filter: blur(1px); pointer-events: none; z-index: 0;"></div>
                    <div style="position: relative; z-index: 1;">
                        <h1 class="mb-2">Temukan Kos Impianmu <br class="d-none d-md-block">dengan Mudah</h1>
                        <h4 class="ts-opacity__50 font-weight-normal">Ribuan pilihan kos putra, putri, campur, dan eksklusif di seluruh Indonesia</h4>
                    </div>
                </div>

                <!-- SEARCH BOX
                =====================================================================================================-->
                <div class="col-lg-11 offset-lg-0" id="cari-kos" style="max-width: 1140px;">
                    <form class="ts-form py-4 px-4 ts-border-radius__md ts-shadow__md" data-bg-color="rgba(255,255,255,.95)">
                        <div class="row">

                            <!--Kota-->
                            <div class="col-md-3 form-group my-2">
                                <label class="ts-text-small ts-text-color-light mb-1">Kota</label>
                                <select class="custom-select" id="kota" name="kota">
                                    <option value="">Pilih Kota</option>
                                    <option value="jakarta">Jakarta</option>
                                    <option value="bandung">Bandung</option>
                                    <option value="yogyakarta">Yogyakarta</option>
                                    <option value="surabaya">Surabaya</option>
                                    <option value="malang">Malang</option>
                                </select>
                            </div>

                            <!--Nama Kos-->
                            <div class="col-md-3 form-group my-2">
                                <label class="ts-text-small ts-text-color-light mb-1">Nama Kos</label>
                                <input type="text" class="form-control" id="nama-kos" name="nama-kos" placeholder="Contoh: Kos Melati">
                            </div>

                            <!--Universitas-->
                            <div class="col-md-3 form-group my-2">
                                <label class="ts-text-small ts-text-color-light mb-1">Universitas</label>
                                <select class="custom-select" id="universitas" name="universitas">
                                    <option value="">Dekat Kampus</option>
                                    <option value="ui">Universitas Indonesia</option>
                                    <option value="itb">ITB</option>
                                    <option value="ugm">UGM</option>
                                    <option value="unair">Universitas Airlangga</option>
                                </select>
                            </div>

                            <!--Lokasi-->
                            <div class="col-md-3 form-group my-2">
                                <label class="ts-text-small ts-text-color-light mb-1">Lokasi</label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Kecamatan / Alamat">
                            </div>

                        </div>
                        <!--end row-->

                        <div class="row">
                            <div class="col-md-8 form-group my-2">
                                <button type="submit" class="btn btn-primary w-100" id="search-btn">
                                    <i class="fa fa-search mr-2"></i>Cari Kos Sekarang
                                </button>
                            </div>
                            <div class="col-md-4 form-group my-2">
                                <a href="{{ route('owner.kos.create') }}" class="btn btn-outline-dark w-100">Jadi Mitra TEMPATIN</a>
                            </div>
                        </div>

                    </form>
                </div>
                <!--end search box-->

            </div>
            <!--end row-->
        </div>
        <!--end container-->

    </section>
    <!--end ts-hero-->

    <!--*********************************************************************************************************-->
    <!-- MAIN ***************************************************************************************************-->
    <!--*********************************************************************************************************-->
    <main id="ts-main">

        <!-- KATEGORI KOS
        =============================================================================================================-->
        <section id="category-select" class="ts-icons-select" data-bg-color="#eeeeee">

            <a href="{{ route('search.kos') }}">
                <aside>128</aside>
                <img src="{{ asset('assets/svg/icon-house.svg') }}" alt="">
                <figure>
                    <h6>Kos Putra</h6>
                    <small>Lihat Pilihan</small>
                </figure>
            </a>

            <a href="{{ route('search.kos') }}">
                <aside>146</aside>
                <img src="{{ asset('assets/svg/icon-apartment.svg') }}" alt="">
                <figure>
                    <h6>Kos Putri</h6>
                    <small>Lihat Pilihan</small>
                </figure>
            </a>

            <a href="{{ route('search.kos') }}">
                <aside>84</aside>
                <img src="{{ asset('assets/svg/icon-cabins.svg') }}" alt="">
                <figure>
                    <h6>Kos Campur</h6>
                    <small>Lihat Pilihan</small>
                </figure>
            </a>

            <a href="{{ route('search.kos') }}">
                <aside>52</aside>
                <img src="{{ asset('assets/svg/icon-offices.svg') }}" alt="">
                <figure>
                    <h6>Kos Eksklusif</h6>
                    <small>Lihat Pilihan</small>
                </figure>
            </a>

            <a href="{{ route('search.kos') }}">
                <aside>210</aside>
                <img src="{{ asset('assets/svg/icon-garages.svg') }}" alt="">
                <figure>
                    <h6>Kos Bulanan</h6>
                    <small>Lihat Pilihan</small>
                </figure>
            </a>

            <a href="{{ route('search.kos') }}">
                <aside>63</aside>
                <img src="{{ asset('assets/svg/icon-land.svg') }}" alt="">
                <figure>
                    <h6>Kos Harian</h6>
                    <small>Lihat Pilihan</small>
                </figure>
            </a>

        </section>
        <!--end category-select-->

        <!-- KOS POPULER
        =============================================================================================================-->
        <section id="featured-properties" class="ts-block pt-5">
            <div class="container">

                <div class="ts-title text-center">
                    <h2>Kos Populer</h2>
                    <p class="ts-text-color-light">Pilihan kos paling banyak dicari minggu ini</p>
                </div>

                <div class="row">

                    @foreach($featuredKos as $kos)
                    <div class="col-sm-6 col-lg-4">
                        <div class="card ts-item ts-card ts-item__lg">
                            <div class="ts-ribbon"><i class="fa fa-thumbs-up"></i></div>
                            <a href="{{ route('kos.show', $kos['slug']) }}" class="card-img ts-item__image" data-bg-image="{{ asset($kos['thumbnail']) }}">
                                <div class="ts-item__info-badge">Rp {{ number_format($kos['price'], 0, ',', '.') }} /bln</div>
                                <figure class="ts-item__info">
                                    <h4>{{ $kos['title'] }}</h4>
                                    <aside><i class="fa fa-map-marker mr-2"></i>{{ $kos['city'] }}</aside>
                                </figure>
                            </a>
                            <div class="card-body">
                                <div class="ts-description-lists">
                                    <dl><dt>Tipe</dt><dd>{{ $kos['type'] }}</dd></dl>
                                    <dl><dt>Kamar</dt><dd>1</dd></dl>
                                    <dl><dt>K. Mandi</dt><dd>Dalam</dd></dl>
                                </div>
                            </div>
                            <a href="{{ route('kos.show', $kos['slug']) }}" class="card-footer"><span class="ts-btn-arrow">Detail</span></a>
                        </div>
                    </div>
                    @endforeach

                </div>
                <!--end row-->

                <div class="text-center mt-3">
                    <a href="{{ route('search.kos') }}" class="btn btn-outline-dark">Lihat Semua Kos Populer</a>
                </div>

            </div>
            <!--end container-->
        </section>
        <!--end featured-properties-->

        <!-- KOS TERBARU
        =============================================================================================================-->
        <section id="latest-listings" class="ts-block pt-5">
            <div class="container">

                <div class="ts-title text-center">
                    <h2>Kos Terbaru</h2>
                    <p class="ts-text-color-light">Baru saja bergabung di TEMPATIN</p>
                </div>

                <div class="row">

                    <!--Item 4-->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card ts-item ts-card">
                            <a href="{{ route('kos.show', 'kos-putra-anggrek') }}" class="card-img ts-item__image" data-bg-image="{{ asset('assets/img/kos/4.png') }}">
                                <div class="ts-item__info-badge">Rp 1.100.000 /bln</div>
                                <figure class="ts-item__info">
                                    <h4>Kos Anggrek</h4>
                                    <aside><i class="fa fa-map-marker mr-2"></i>Sleman, Yogyakarta</aside>
                                </figure>
                            </a>
                            <a href="{{ route('kos.show', 'kos-putra-anggrek') }}" class="card-footer"><span class="ts-btn-arrow">Detail</span></a>
                        </div>
                    </div>

                    <!--Item 5-->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card ts-item ts-card">
                            <a href="{{ route('kos.show', 'kos-eksklusif-mawar') }}" class="card-img ts-item__image" data-bg-image="{{ asset('assets/img/kos/5.png') }}">
                                <div class="ts-item__info-badge">Rp 1.750.000 /bln</div>
                                <figure class="ts-item__info">
                                    <h4>Kos Wijaya Kusuma</h4>
                                    <aside><i class="fa fa-map-marker mr-2"></i>Gubeng, Surabaya</aside>
                                </figure>
                            </a>
                            <a href="{{ route('kos.show', 'kos-eksklusif-mawar') }}" class="card-footer"><span class="ts-btn-arrow">Detail</span></a>
                        </div>
                    </div>

                    <!--Item 6-->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card ts-item ts-card">
                            <a href="{{ route('kos.show', 'kos-putri-melati') }}" class="card-img ts-item__image" data-bg-image="{{ asset('assets/img/kos/6.png') }}">
                                <div class="ts-item__info-badge">Rp 90.000 /hari</div>
                                <figure class="ts-item__info">
                                    <h4>Kos Harian Sudirman</h4>
                                    <aside><i class="fa fa-map-marker mr-2"></i>Sudirman, Jakarta Pusat</aside>
                                </figure>
                            </a>
                            <a href="{{ route('kos.show', 'kos-putri-melati') }}" class="card-footer"><span class="ts-btn-arrow">Detail</span></a>
                        </div>
                    </div>

                    <!--Item 7-->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card ts-item ts-card">
                            <a href="{{ route('kos.show', 'kos-putri-melati') }}" class="card-img ts-item__image" data-bg-image="{{ asset('assets/img/kos/7.png') }}">
                                <div class="ts-item__info-badge">Rp 1.300.000 /bln</div>
                                <figure class="ts-item__info">
                                    <h4>Kos Cendana Putri</h4>
                                    <aside><i class="fa fa-map-marker mr-2"></i>Lowokwaru, Malang</aside>
                                </figure>
                            </a>
                            <a href="{{ route('kos.show', 'kos-putri-melati') }}" class="card-footer"><span class="ts-btn-arrow">Detail</span></a>
                        </div>
                    </div>

                </div>
                <!--end row-->

                <div class="text-center mt-3">
                    <a href="listing-grid-4-columns.html" class="btn btn-outline-dark">Lihat Semua Kos Terbaru</a>
                </div>

            </div>
            <!--end container-->
        </section>
        <!--end latest-listings-->

        <!-- MENGAPA MEMILIH TEMPATIN
        =============================================================================================================-->
        <section id="why-tempatin" class="ts-block pt-5">
            <div class="bg-white py-5" data-bg-color="#f6f6f6">
                <div class="container py-4">

                    <div class="ts-title text-center">
                        <h2>Mengapa Memilih TEMPATIN</h2>
                        <p class="ts-text-color-light">Cari dan booking kos jadi lebih mudah, cepat, dan aman</p>
                    </div>

                    <div class="row text-center">

                        <div class="col-sm-6 col-lg-3 mb-4">
                            <i class="fa fa-search-location fa-3x text-primary mb-3"></i>
                            <h5>Pencarian Mudah</h5>
                            <p class="ts-text-color-light">Filter kos berdasarkan kota, kampus, dan lokasi favoritmu.</p>
                        </div>

                        <div class="col-sm-6 col-lg-3 mb-4">
                            <i class="fa fa-shield-alt fa-3x text-primary mb-3"></i>
                            <h5>Kos Terverifikasi</h5>
                            <p class="ts-text-color-light">Setiap kos sudah dicek langsung oleh tim TEMPATIN.</p>
                        </div>

                        <div class="col-sm-6 col-lg-3 mb-4">
                            <i class="fa fa-bolt fa-3x text-primary mb-3"></i>
                            <h5>Booking Instan</h5>
                            <p class="ts-text-color-light">Pesan kamar dalam hitungan menit tanpa survei rumit.</p>
                        </div>

                        <div class="col-sm-6 col-lg-3 mb-4">
                            <i class="fa fa-headset fa-3x text-primary mb-3"></i>
                            <h5>Layanan 24/7</h5>
                            <p class="ts-text-color-light">Tim support siap membantu kapan pun kamu butuh.</p>
                        </div>

                    </div>
                    <!--end row-->

                </div>
                <!--end container-->
            </div>
        </section>
        <!--end why-tempatin-->

        <!-- NUMBERS / STATISTIK
        =============================================================================================================-->
        <section id="tempatin-numbers">
            <div id="numbers" class="py-5 text-white text-center ts-separate-bg-element" data-bg-color="#000037" data-bg-image="{{ asset('assets/img/bg-apartment-table.jpg') }}" data-bg-image-opacity=".3">
                <div class="container py-5">
                    <div class="ts-promo-numbers">
                        <div class="row">

                            <div class="col-sm-3">
                                <div class="ts-promo-number">
                                    <h2>5.200+</h2>
                                    <h4 class="mb-0 ts-opacity__50">Kos Terdaftar</h4>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="ts-promo-number">
                                    <h2>120</h2>
                                    <h4 class="mb-0 ts-opacity__50">Kota &amp; Kabupaten</h4>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="ts-promo-number">
                                    <h2>38.000+</h2>
                                    <h4 class="mb-0 ts-opacity__50">Penghuni Puas</h4>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="ts-promo-number">
                                    <h2>750+</h2>
                                    <h4 class="mb-0 ts-opacity__50">Mitra Pemilik Kos</h4>
                                </div>
                            </div>

                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </section>
        <!--end tempatin-numbers-->

        <!-- CARA BOOKING
        =============================================================================================================-->
        <section id="cara-booking" class="ts-block pt-5">
            <div class="container">

                <div class="ts-title text-center">
                    <h2>Cara Booking Kos</h2>
                    <p class="ts-text-color-light">Hanya 4 langkah mudah untuk mendapatkan kos impianmu</p>
                </div>

                <div class="row text-center ts-how-it-works">

                    <div class="col-sm-6 col-lg-3 mb-4">
                        <div class="ts-circle ts-bg-primary p-4 mx-auto mb-3">
                            <i class="fa fa-search text-white"></i>
                        </div>
                        <h5>1. Cari Kos</h5>
                        <p class="ts-text-color-light">Gunakan filter kota, kampus, atau lokasi.</p>
                    </div>

                    <div class="col-sm-6 col-lg-3 mb-4">
                        <div class="ts-circle ts-bg-primary p-4 mx-auto mb-3">
                            <i class="fa fa-door-open text-white"></i>
                        </div>
                        <h5>2. Pilih Kamar</h5>
                        <p class="ts-text-color-light">Bandingkan fasilitas dan harga kamar.</p>
                    </div>

                    <div class="col-sm-6 col-lg-3 mb-4">
                        <div class="ts-circle ts-bg-primary p-4 mx-auto mb-3">
                            <i class="fa fa-calendar-check text-white"></i>
                        </div>
                        <h5>3. Booking</h5>
                        <p class="ts-text-color-light">Isi data diri dan konfirmasi pemesanan.</p>
                    </div>

                    <div class="col-sm-6 col-lg-3 mb-4">
                        <div class="ts-circle ts-bg-primary p-4 mx-auto mb-3">
                            <i class="fa fa-check-circle text-white"></i>
                        </div>
                        <h5>4. Selesai</h5>
                        <p class="ts-text-color-light">Kamar siap kamu tempati, mudah bukan?</p>
                    </div>

                </div>
                <!--end row-->

            </div>
            <!--end container-->
        </section>
        <!--end cara-booking-->

        <!-- TESTIMONI
        =============================================================================================================-->
        <section id="testimoni" class="ts-block pt-5">
            <div class="bg-white text-center py-5" data-bg-color="#f6f6f6">
                <div class="container">
                    <div class="ts-title text-center">
                        <h2>Apa Kata Mereka</h2>
                        <p class="ts-text-color-light">Pengalaman nyata dari penghuni TEMPATIN</p>
                    </div>

                    <div class="offset-lg-2 col-lg-8">
                        <div class="owl-carousel" data-owl-items="1" data-owl-dots="1">

                            <div class="ts-slide">
                                <div class="ts-circle__sm mx-auto" data-bg-image="{{ asset('assets/img/img-person-01.jpg') }}"></div>
                                <h5 class="my-3">Anisa Rahmawati</h5>
                                <p class="h5 font-weight-normal ts-text-color-light">
                                    Cari kos dekat kampus jadi gampang banget lewat TEMPATIN. Filter lokasinya
                                    akurat dan prosesnya cepat.
                                </p>
                            </div>

                            <div class="ts-slide">
                                <div class="ts-circle__sm mx-auto" data-bg-image="{{ asset('assets/img/img-person-02.jpg') }}"></div>
                                <h5 class="my-3">Bagus Prasetyo</h5>
                                <p class="h5 font-weight-normal ts-text-color-light">
                                    Sebagai pemilik kos, saya terbantu sekali. Kamar cepat penuh setelah
                                    terdaftar di TEMPATIN.
                                </p>
                            </div>

                            <div class="ts-slide">
                                <div class="ts-circle__sm mx-auto" data-bg-image="{{ asset('assets/img/img-person-03.jpg') }}"></div>
                                <h5 class="my-3">Dewi Lestari</h5>
                                <p class="h5 font-weight-normal ts-text-color-light">
                                    Tampilan website mudah dipahami, informasi kos lengkap, dan tim supportnya
                                    responsif.
                                </p>
                            </div>

                        </div>
                        <!--end owl-carousel-->
                    </div>
                    <!--end offset-lg-2-->
                </div>
                <!--end container-->
            </div>
        </section>
        <!--end testimoni-->

        <!-- ARTIKEL TERBARU
        =============================================================================================================-->
        <section id="artikel" class="ts-block pt-5">
            <div class="container">

                <div class="ts-title text-center">
                    <h2>Artikel Terbaru</h2>
                    <p class="ts-text-color-light">Tips dan panduan seputar dunia kos</p>
                </div>

                <div class="row">

                    <div class="col-sm-6 col-lg-4">
                        <div class="card ts-item ts-card">
                            <a href="#" class="card-img ts-item__image" data-bg-image="{{ asset('assets/img/img-item-thumb-08.jpg') }}">
                                <figure class="ts-item__info">
                                    <h4>5 Tips Memilih Kos Dekat Kampus</h4>
                                    <aside><i class="fa fa-calendar mr-2"></i>2 Agustus 2026</aside>
                                </figure>
                            </a>
                            <div class="card-body">
                                <p class="ts-text-color-light mb-0">Panduan singkat agar kamu tidak salah pilih kos saat merantau untuk kuliah.</p>
                            </div>
                            <a href="#" class="card-footer"><span class="ts-btn-arrow">Baca Selengkapnya</span></a>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <div class="card ts-item ts-card">
                            <a href="#" class="card-img ts-item__image" data-bg-image="{{ asset('assets/img/img-item-thumb-09.jpg') }}">
                                <figure class="ts-item__info">
                                    <h4>Perbedaan Kos Putra, Putri, dan Campur</h4>
                                    <aside><i class="fa fa-calendar mr-2"></i>28 Juli 2026</aside>
                                </figure>
                            </a>
                            <div class="card-body">
                                <p class="ts-text-color-light mb-0">Kenali jenis-jenis kos supaya kamu bisa menyesuaikan dengan kebutuhan.</p>
                            </div>
                            <a href="#" class="card-footer"><span class="ts-btn-arrow">Baca Selengkapnya</span></a>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-4">
                        <div class="card ts-item ts-card">
                            <a href="#" class="card-img ts-item__image" data-bg-image="{{ asset('assets/img/img-item-thumb-10.jpg') }}">
                                <figure class="ts-item__info">
                                    <h4>Cara Aman Booking Kos Secara Online</h4>
                                    <aside><i class="fa fa-calendar mr-2"></i>15 Juli 2026</aside>
                                </figure>
                            </a>
                            <div class="card-body">
                                <p class="ts-text-color-light mb-0">Hindari penipuan dengan mengikuti langkah booking yang aman berikut ini.</p>
                            </div>
                            <a href="#" class="card-footer"><span class="ts-btn-arrow">Baca Selengkapnya</span></a>
                        </div>
                    </div>

                </div>
                <!--end row-->

            </div>
            <!--end container-->
        </section>
        <!--end artikel-->

        <!-- CALL TO ACTION
        =============================================================================================================-->
        <section id="cta-tempatin" class="ts-block pt-5">
            <div class="text-white text-center py-5 ts-separate-bg-element" data-bg-color="#000037" data-bg-image="{{ asset('assets/img/bg-woman-mobile.jpg') }}" data-bg-image-opacity=".35">
                <div class="container py-4">
                    <h2>Siap Menemukan Kos Impianmu?</h2>
                    <h5 class="ts-opacity__50 font-weight-normal mb-4">Ribuan kos berkualitas menunggumu di TEMPATIN</h5>
                    <a href="#cari-kos" class="ts-scroll btn btn-primary btn-lg mr-2">Cari Kos Sekarang</a>
                    <a href="{{ route('owner.kos.create') }}" class="btn btn-outline-light btn-lg">Jadi Mitra</a>
                </div>
            </div>
        </section>
        <!--end cta-tempatin-->

    </main>
    <!--end #ts-main-->

    <!--*********************************************************************************************************-->
    <!--************ FOOTER *************************************************************************************-->
    <!--*********************************************************************************************************-->

    @include('partials.footer')

</div>
<!--end .ts-page-wrapper-->
@endsection
