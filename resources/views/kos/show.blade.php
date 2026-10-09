@extends('layouts.app')

@section('title', $kos['title'] . ' - TEMPATIN')

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')

    @include('partials.alert')

    <main id="ts-main">

        <!--BREADCRUMB
        =========================================================================================================-->
        <section id="breadcrumb" class="pb-2">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('kos.index') }}">Cari Kos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $kos['title'] }}</li>
                    </ol>
                </nav>
            </div>
        </section>

        <!--GALLERY CAROUSEL (Pertahankan layout gambar)
        =========================================================================================================-->
        <section id="gallery-carousel">

            <div class="owl-carousel ts-gallery-carousel ts-gallery-carousel__multi" data-owl-dots="1"
                data-owl-items="3" data-owl-center="1" data-owl-loop="1">

                @php
                    $galleryImages = [];
                    if (isset($kos->photos) && $kos->photos->isNotEmpty()) {
                        foreach ($kos->photos as $photo) {
                            $galleryImages[] = $photo->url;
                        }
                    } elseif (!empty($kos['gallery'])) {
                        foreach ($kos['gallery'] as $img) {
                            $galleryImages[] = asset($img);
                        }
                    } else {
                        $galleryImages = [
                            asset($kos['thumbnail'] ?? 'assets/img/img-detail-01.jpg'),
                            asset('assets/img/img-detail-02.jpg'),
                            asset('assets/img/img-detail-05.jpg'),
                            asset('assets/img/img-detail-04.jpg'),
                            asset('assets/img/img-detail-03.jpg'),
                        ];
                    }
                @endphp

                @foreach($galleryImages as $image)
                <!--Slide-->
                <div class="slide">
                    <div class="ts-image" data-bg-image="{{ $image }}">
                        <a href="{{ $image }}" class="ts-zoom popup-image"><i class="fa fa-search-plus"></i>Zoom</a>
                    </div>
                </div>
                @endforeach

            </div>

        </section>

        <!--CONTENT (Nama kos berada di bawah gambar album - Layout referensi)
        =========================================================================================================-->
        <section id="content" class="pt-4">
            <div class="container">
                <div class="row">

                    <!--LEFT SIDE: MAIN CONTENT (Title, Badges, Quick Info, Description, Amenities, Map, Reviews)
                    =============================================================================================-->
                    <div class="col-md-7 col-lg-8">

                        <!--NAMA KOS & BADGES-->
                        <div id="page-title" class="mb-4">
                            <div class="mb-2">
                                <span class="badge badge-success px-3 py-1 font-weight-normal" style="border-radius: 9999px; background-color: #edf7ee; color: #2e7d32; border: 1px solid #c8e6c9;">
                                    <i class="fa fa-check-circle mr-1"></i>TEMPATIN Verified
                                </span>
                            </div>

                            <h1 class="font-weight-bold text-dark mb-2" style="font-size: 2.2rem; line-height: 1.25; letter-spacing: -0.03em;">
                                {{ $kos['title'] }}
                            </h1>

                            <div class="d-flex flex-wrap align-items-center text-muted" style="gap: 10px; font-size: 0.95rem;">
                                <span class="badge badge-light border text-dark px-3 py-1 font-weight-normal" style="border-radius: 9999px;">
                                    Kos {{ $kos['type'] ?? 'Campur' }}
                                </span>
                                <span>&bull;</span>
                                <span>
                                    <i class="fa fa-map-marker-alt text-primary mr-1"></i>
                                    {{ $kos['address'] ?? $kos['city'] }}
                                </span>
                                @if(!empty($kos['rating']))
                                    <span>&bull;</span>
                                    <span>
                                        <i class="fa fa-star text-warning mr-1"></i>
                                        <strong class="text-dark">{{ number_format($kos['rating'], 1) }}</strong> ({{ $kos['review_count'] ?? 0 }} ulasan)
                                    </span>
                                @endif
                                <span class="badge badge-{{ ($kos['status'] ?? 'active') === 'active' ? 'success' : 'secondary' }} ml-auto py-1 px-3" style="border-radius: 9999px;">
                                    {{ ($kos['status'] ?? 'active') === 'active' ? 'Tersedia' : 'Penuh' }}
                                </span>
                            </div>
                        </div>

                        <hr class="mb-4" style="border-top: var(--border-hairline);">

                        <!--QUICK INFO
                        =========================================================================================-->
                        <section id="quick-info">
                            <h3>Info Singkat</h3>

                            <!--Quick Info-->
                            <div class="ts-quick-info ts-box">

                                <!--Row-->
                                <div class="row no-gutters">

                                    <!--Bathrooms-->
                                    <div class="col-sm-3">
                                        <div class="ts-quick-info__item"
                                            data-bg-image="{{ asset('assets/img/icon-quick-info-shower.png') }}">
                                            <h6>K. Mandi</h6>
                                            <figure>{{ $kos['bathrooms'] ?? '1' }}</figure>
                                        </div>
                                    </div>

                                    <!--Bedrooms-->
                                    <div class="col-sm-3">
                                        <div class="ts-quick-info__item"
                                            data-bg-image="{{ asset('assets/img/icon-quick-info-bed.png') }}">
                                            <h6>Kamar Tidur</h6>
                                            <figure>{{ $kos['bedrooms'] ?? '1' }}</figure>
                                        </div>
                                    </div>

                                    <!--Area-->
                                    <div class="col-sm-3">
                                        <div class="ts-quick-info__item"
                                            data-bg-image="{{ asset('assets/img/icon-quick-info-area.png') }}">
                                            <h6>Luas</h6>
                                            <figure>{{ $kos['area'] ?? '-' }}m<sup>2</sup></figure>
                                        </div>
                                    </div>

                                    <!--Garages-->
                                    <div class="col-sm-3">
                                        <div class="ts-quick-info__item"
                                            data-bg-image="{{ asset('assets/img/icon-quick-info-garages.png') }}">
                                            <h6>Parkir</h6>
                                            <figure>{{ $kos['garages'] ?? '-' }}</figure>
                                        </div>
                                    </div>

                                </div>
                                <!--end row-->

                            </div>
                            <!--end ts-quick-info-->

                        </section>

                        <!--DESCRIPTION
                        =========================================================================================-->
                        <section id="description">

                            <h3>Deskripsi</h3>

                            <p>{{ $kos['description'] ?? 'Deskripsi belum tersedia.' }}</p>

                        </section>

                        @if(!empty($kos['features']))
                        <!--FEATURES
                        =========================================================================================-->
                        <section id="features">

                            <h3>Fasilitas Utama</h3>

                            <ul class="list-unstyled ts-list-icons ts-column-count-4 ts-column-count-sm-2 ts-column-count-md-2">
                                @foreach($kos['features'] as $feature)
                                <li>
                                    <i class="fa {{ $feature['icon'] }}"></i>
                                    {{ $feature['name'] }}
                                </li>
                                @endforeach
                            </ul>

                        </section>
                        @endif

                        <!--AMENITIES
                        =========================================================================================-->
                        <section id="amenities">

                            <h3>Fasilitas Kos</h3>

                            @if(isset($kos->facilities) && $kos->facilities->isNotEmpty())
                                <div class="d-flex flex-wrap mb-4">
                                    @foreach($kos->facilities as $facility)
                                        <span class="badge badge-light border text-dark mr-2 mb-2 p-2" style="font-size: 0.9rem; font-weight: 500;">
                                            <i class="fa fa-check-circle text-primary mr-1"></i>{{ $facility->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @elseif(!empty($kos['facilities']))
                                <ul class="ts-list-colored-bullets ts-text-color-light ts-column-count-3 ts-column-count-md-2">
                                    @foreach($kos['facilities'] as $facility)
                                        <li>{{ is_object($facility) ? $facility->name : $facility }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Belum ada fasilitas yang ditambahkan.</p>
                            @endif

                        </section>

                        <!--MAP PLACEHOLDER
                        =========================================================================================-->
                        <section id="map-location">

                            <h3>Peta Lokasi</h3>

                            <div class="ts-box text-center py-5" style="background-color: #f5f7f9;">
                                <i class="fa fa-map-marked-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Peta lokasi akan segera tersedia.</p>
                                <p class="text-muted mb-0"><small>{{ $kos['address'] ?? $kos['city'] }}</small></p>
                            </div>

                        </section>

                        <!--REVIEWS
                        =============================================================================================-->
                        <section id="reviews" class="pk-reviews mt-4">
                            <hr class="mb-4">

                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
                                <div>
                                    <h3 class="mb-1">Ulasan Penghuni</h3>
                                    <p class="text-muted mb-0">Pengalaman penghuni di {{ $kos['title'] }}</p>
                                </div>
                                <div class="pk-reviews__summary">
                                    <i class="fa fa-star"></i>
                                    <strong>{{ number_format($kos['rating'] ?? 0, 1) }}</strong>
                                    <span>({{ $kos['review_count'] ?? 0 }} ulasan)</span>
                                </div>
                            </div>

                            <div class="ts-box pk-reviews__breakdown mb-4">
                                <div class="row">
                                    @foreach($kos['rating_breakdown'] ?? [] as $rating)
                                    <div class="col-md-6 mb-3 mb-md-2">
                                        <div class="pk-review-score">
                                            <span>{{ $rating['label'] }}</span>
                                            <span class="pk-review-score__stars" aria-label="Rating {{ $rating['score'] }} dari 5">
                                                @for($star = 1; $star <= 5; $star++)
                                                    <i class="fa fa-star{{ $star <= round($rating['score']) ? '' : '-o' }}"></i>
                                                @endfor
                                            </span>
                                            <strong>{{ number_format($rating['score'], 1) }}</strong>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            @foreach($kos['reviews'] ?? [] as $review)
                            <article class="pk-review-item mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex align-items-center">
                                        <div class="pk-review-item__avatar"><i class="fa fa-user"></i></div>
                                        <div>
                                            <h5 class="mb-1">{{ $review['name'] }}</h5>
                                            <small class="text-muted">{{ $review['date'] }}</small>
                                        </div>
                                    </div>
                                    <span class="pk-review-item__score"><i class="fa fa-star"></i> {{ number_format($review['score'], 1) }}</span>
                                </div>
                                <p class="mb-0 mt-3">{{ $review['comment'] }}</p>

                                @if(!empty($review['reply']))
                                <div class="pk-review-item__reply mt-2">
                                    <strong>Balasan dari Pemilik Kos</strong>
                                    <p class="mb-0 mt-1">{{ $review['reply'] }}</p>
                                </div>
                                @endif
                            </article>
                            @endforeach
                        </section>

                    </div>
                    <!--end col-md-7 col-lg-8-->

                    <!--RIGHT SIDE: SIDEBAR (Card Sewa/Booking, Details, Hubungi Pemilik, Lokasi, Actions)
                    =============================================================================================-->
                    <div class="col-md-5 col-lg-4">

                        <!--STICKY BOOKING CARD (Notion Pure White Card)-->
                        <div class="card p-4 mb-4" style="position: sticky; top: 110px; z-index: 10; border-radius: 12px; border: var(--border-hairline);">
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted small font-weight-bold">
                                        <i class="fa fa-tag text-primary mr-1"></i>Harga Sewa Resmi
                                    </span>
                                    <span class="badge badge-light border text-muted small">Per Bulan</span>
                                </div>

                                <div class="d-flex align-items-baseline mb-3">
                                    <h2 class="text-primary font-weight-bold mb-0" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                                        Rp {{ number_format($kos['price'], 0, ',', '.') }}
                                    </h2>
                                    <span class="text-muted ml-2">/bln</span>
                                </div>

                                <hr class="my-3" style="border-top: var(--border-hairline);">

                                <div class="d-flex flex-column" style="gap: 10px;">
                                    <a href="{{ route('member.booking.create', $kos['slug']) }}"
                                        class="btn btn-primary btn-block btn-lg font-weight-bold py-3">
                                        <i class="fa fa-calendar-check mr-2"></i>Ajukan Sewa Sekarang
                                    </a>

                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kos['owner_phone'] ?? '6280286216730') }}?text=Halo, saya tertarik dengan {{ urlencode($kos['title']) }}"
                                        target="_blank" class="btn btn-outline-dark btn-block py-2 font-weight-bold">
                                        <i class="fab fa-whatsapp text-success mr-2"></i>Tanya Pemilik Langsung
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!--DETAILS
                        =========================================================================================-->
                        <section>
                            <h3>Details</h3>
                            <div class="ts-box">

                                <dl class="ts-description-list__line mb-0">

                                    <dt>Kategori:</dt>
                                    <dd>Kos {{ $kos['type'] ?? '-' }}</dd>

                                    <dt>Status:</dt>
                                    <dd>{{ $kos['status'] ?? 'Tersedia' }}</dd>

                                    <dt>Luas:</dt>
                                    <dd>{{ $kos['area'] ?? '-' }} m<sup>2</sup></dd>

                                    <dt>Kamar:</dt>
                                    <dd>{{ $kos['rooms'] ?? '-' }}</dd>

                                    <dt>K. Mandi:</dt>
                                    <dd>{{ $kos['bathrooms'] ?? '-' }}</dd>

                                    <dt>Tempat Tidur:</dt>
                                    <dd>{{ $kos['bedrooms'] ?? '-' }}</dd>

                                    <dt>Parkir:</dt>
                                    <dd>{{ $kos['garages'] ?? '-' }}</dd>

                                </dl>

                            </div>
                        </section>

                        <!--CONTACT THE AGENT
                        =========================================================================================-->
                        <section class="contact-the-agent">
                            <h3>Hubungi Pemilik</h3>

                            <div class="ts-box">

                                <!--Agent Image & Phone-->
                                <div class="ts-center__vertical mb-4">

                                    <!--Image-->
                                    <a href="#" class="ts-circle p-5 mr-4 ts-shadow__sm"
                                        data-bg-image="{{ asset($kos['owner_photo'] ?? 'assets/img/img-person-05.jpg') }}"></a>

                                    <!--Phone contact-->
                                    <figure class="mb-0">
                                        <h5 class="mb-0">{{ $kos['owner_name'] ?? 'Pemilik Kos' }}</h5>
                                        <p class="mb-0">
                                            <i class="fa fa-phone-square ts-opacity__50 mr-2"></i>
                                            {{ $kos['owner_phone'] ?? '-' }}
                                        </p>
                                    </figure>
                                </div>

                                <!--Agent contact form-->
                                <form id="form-agent" class="ts-form">

                                    <!--Name-->
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name"
                                            placeholder="Nama Anda">
                                    </div>

                                    <!--Email-->
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email Anda">
                                    </div>

                                    <!--Message-->
                                    <div class="form-group">
                                        <textarea class="form-control" id="form-contact-message" rows="3" name="message"
                                            placeholder="Halo, saya ingin bertanya tentang {{ $kos['title'] }}"></textarea>
                                    </div>

                                    <!--Submit button-->
                                    <div class="form-group clearfix mb-0">
                                        <button type="button" class="btn btn-primary float-right"
                                            id="form-contact-submit" onclick="alert('Fitur hubungi pemilik akan segera tersedia.')">
                                            <i class="fa fa-envelope mr-2"></i>Kirim Pesan
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </section>

                        <!--LOCATION
                        =============================================================================================-->
                        <section id="location">
                            <h3>Lokasi</h3>

                            <div class="ts-box">

                                <dl class="ts-description-list__line mb-0">

                                    <dt><i class="fa fa-map-marker ts-opacity__30 mr-2"></i>Alamat:</dt>
                                    <dd class="border-bottom pb-2">{{ $kos['address'] ?? $kos['city'] }}</dd>

                                    <dt><i class="fa fa-phone-square ts-opacity__30 mr-2"></i>Telepon:</dt>
                                    <dd class="border-bottom pb-2">{{ $kos['owner_phone'] ?? '-' }}</dd>

                                    <dt><i class="fa fa-envelope ts-opacity__30 mr-2"></i>Email:</dt>
                                    <dd class="border-bottom pb-2"><a href="mailto:{{ $kos['owner_email'] ?? 'hello@tempatin.id' }}">{{ $kos['owner_email'] ?? 'hello@tempatin.id' }}</a></dd>

                                    <dt><i class="fa fa-globe ts-opacity__30 mr-2"></i>Website:</dt>
                                    <dd><a href="{{ route('home') }}">tempatin.id</a></dd>

                                </dl>

                            </div>

                        </section>

                        <!--ACTIONS
                        =============================================================================================-->
                        <section id="actions">

                            <div class="d-flex justify-content-between">

                                <a href="#" class="btn btn-light mr-2 w-100" data-toggle="tooltip"
                                    data-placement="top" title="Tambah ke favorit">
                                    <i class="far fa-star"></i>
                                </a>

                                <a href="#" class="btn btn-light mr-2 w-100" data-toggle="tooltip"
                                    data-placement="top" title="Cetak">
                                    <i class="fa fa-print"></i>
                                </a>

                                <a href="#" class="btn btn-light mr-2 w-100" data-toggle="tooltip"
                                    data-placement="top" title="Bandingkan">
                                    <i class="fa fa-exchange-alt"></i>
                                </a>

                                <a href="#" class="btn btn-light w-100" data-toggle="tooltip" data-placement="top"
                                    title="Bagikan">
                                    <i class="fa fa-share-alt"></i>
                                </a>

                            </div>

                        </section>

                    </div>
                    <!--end col-md-5 col-lg-4-->

                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </section>

        <!--SIMILAR PROPERTIES
        =============================================================================================================-->
        @if(!empty($similarKos) && count($similarKos) > 0)
        <section id="similar-properties" class="py-5 bg-white border-top">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Kos Serupa</h3>
                    <span class="text-muted pk-similar-count">{{ count($similarKos) }} pilihan</span>
                </div>

                <div class="row">
                    @foreach($similarKos as $similar)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card ts-item ts-card pk-similar-card h-100">
                            @if($loop->first)
                            <div class="ts-ribbon"><i class="fa fa-thumbs-up"></i></div>
                            @endif

                            <!--Card Image-->
                            <a href="{{ route('kos.show', $similar['slug']) }}" class="card-img ts-item__image"
                                data-bg-image="{{ asset($similar['thumbnail']) }}" style="height: 180px; background-size: cover; background-position: center;"></a>

                            <!--Card Body-->
                            <div class="card-body ts-item__body p-3">
                                <figure class="ts-item__info mb-2">
                                    <h5 class="mb-1"><a href="{{ route('kos.show', $similar['slug']) }}">{{ $similar['title'] }}</a></h5>
                                    <aside class="text-muted small">
                                        <i class="fa fa-map-marker-alt mr-1 text-primary"></i>
                                        {{ $similar['city'] }}
                                    </aside>
                                </figure>

                                <div class="text-primary font-weight-bold mb-2">Rp {{ number_format($similar['price'], 0, ',', '.') }} <small class="text-muted">/bln</small></div>

                                <div class="d-flex justify-content-between text-muted small border-top pt-2">
                                    <span><i class="fa fa-ruler-combined mr-1"></i>{{ $similar['area'] ?? '12' }}m²</span>
                                    <span><i class="fa fa-bed mr-1"></i>{{ $similar['bedrooms'] ?? '1' }} Kamar</span>
                                    <span><i class="fa fa-bath mr-1"></i>{{ $similar['bathrooms'] ?? '1' }} KM</span>
                                </div>
                            </div>

                            <!--Card Footer-->
                            <a href="{{ route('kos.show', $similar['slug']) }}" class="card-footer ts-item__footer text-center py-2 bg-light">
                                <span class="ts-btn-arrow font-weight-bold">Lihat Detail</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

    </main>
    <!--end #ts-main-->

    @include('partials.footer')

</div>
<!--end page-->
@endsection
