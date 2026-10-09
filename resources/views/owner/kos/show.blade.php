@extends('layouts.owner')

@section('title', $kos['title'] . ' - TEMPATIN')

@section('owner-content')
<main id="ts-main">

            <!--BREADCRUMB
            =========================================================================================================-->
            <section id="breadcrumb">
                <div class="container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('owner.kos.index') }}">Cari Kos</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $kos['title'] }}</li>
                        </ol>
                    </nav>
                </div>
            </section>

            <!--PAGE TITLE
            =========================================================================================================-->
            <section id="page-title">
                <div class="container">

                    <div class="d-block d-sm-flex justify-content-between">

                        <!--Title-->
                        <div class="ts-title mb-0">
                            <h1>{{ $kos['title'] }}</h1>
                            <h5 class="ts-opacity__90">
                                <i class="fa fa-map-marker text-primary"></i>
                                {{ $kos['city'] }}
                            </h5>
                        </div>

                        <!--Price-->
                        <h3>
                            <span class="badge badge-primary p-3 font-weight-normal ts-shadow__sm">Rp {{ number_format($kos['price'], 0, ',', '.') }}</span>
                        </h3>

                    </div>

                </div>
            </section>

            <!--GALLERY CAROUSEL
            =========================================================================================================-->
            <section id="gallery-carousel">

                <div class="owl-carousel ts-gallery-carousel ts-gallery-carousel__multi" data-owl-dots="1"
                    data-owl-items="3" data-owl-center="1" data-owl-loop="1">

                    <!--Slide-->
                    <div class="slide">
                        <div class="ts-image"
                            data-bg-image="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWkIKAq4UAjE5dTl43T_Uztwv9HoBhgGA1VzD8Nv01_4toGOYvPX7Edv7I3ug5c3PoOo7UmEP8YEw9xSj34tpJGmjffDRbPe9lKDtZbwZlxZo2GXTyF-bPfupi_XRRkJIGlRdeCUjyAtI5Zl=s1360-w1360-h1020-rw">
                            <a href="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWkIKAq4UAjE5dTl43T_Uztwv9HoBhgGA1VzD8Nv01_4toGOYvPX7Edv7I3ug5c3PoOo7UmEP8YEw9xSj34tpJGmjffDRbPe9lKDtZbwZlxZo2GXTyF-bPfupi_XRRkJIGlRdeCUjyAtI5Zl=s1360-w1360-h1020-rw"
                                class="ts-zoom popup-image"><i class="fa fa-search-plus"></i>Zoom</a>
                        </div>
                    </div>

                    <!--Slide-->
                    <div class="slide">
                        <div class="ts-image"
                            data-bg-image="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWlGJXI2bOoyQZRPVzRrEffzhOM6lw6AR3l8J0fd5pkBFkielBAdrmHXAsGkwwen2lR2ydPVVhDuMYQNM1K6gfY2Ot-G5qv0_5IZdV1hckWwtqNQxQ8sUnY3rC5HxDhXvfIAu-3bcYoySu9u=s1360-w1360-h1020-rw">
                            <a href="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWlGJXI2bOoyQZRPVzRrEffzhOM6lw6AR3l8J0fd5pkBFkielBAdrmHXAsGkwwen2lR2ydPVVhDuMYQNM1K6gfY2Ot-G5qv0_5IZdV1hckWwtqNQxQ8sUnY3rC5HxDhXvfIAu-3bcYoySu9u=s1360-w1360-h1020-rw"
                                class="ts-zoom popup-image"><i class="fa fa-search-plus"></i>Zoom</a>
                        </div>
                    </div>

                    <!--Slide-->
                    <div class="slide">
                        <div class="ts-image"
                            data-bg-image="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWkusyWvJ3wcC7_Ai4l4wXS6GBo2kdWPxy7pGZqShs_NFmnUbQCLrwzeQ_2i565f0FEabv1h7TMaJpDItdXUQsQYFn62RAP3C-rG9lo4T7I9W1LxwHTDhpNHU_nsfZyn4kU9F5frpUw1_1s=s1360-w1360-h1020-rw">
                            <a href="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWkusyWvJ3wcC7_Ai4l4wXS6GBo2kdWPxy7pGZqShs_NFmnUbQCLrwzeQ_2i565f0FEabv1h7TMaJpDItdXUQsQYFn62RAP3C-rG9lo4T7I9W1LxwHTDhpNHU_nsfZyn4kU9F5frpUw1_1s=s1360-w1360-h1020-rw"
                                class="ts-zoom popup-image"><i class="fa fa-search-plus"></i>Zoom</a>
                        </div>
                    </div>

                    <!--Slide-->
                    <div class="slide">
                        <div class="ts-image"
                            data-bg-image="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWmCszAaNXUzj9Hfnx4qIN6cczgJ3XahnEf1UppwTMclbW8vuHSWeUAGmpLJJlfFn6M7xUfSH-NMlt3yVqNJoW-npmrAMncIz-VgSoBbVFCD_hI5XIRA4sc83azFjNR-30GmBnSeah0YphA=s1360-w1360-h1020-rw">
                            <a href="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWmCszAaNXUzj9Hfnx4qIN6cczgJ3XahnEf1UppwTMclbW8vuHSWeUAGmpLJJlfFn6M7xUfSH-NMlt3yVqNJoW-npmrAMncIz-VgSoBbVFCD_hI5XIRA4sc83azFjNR-30GmBnSeah0YphA=s1360-w1360-h1020-rw"
                                class="ts-zoom popup-image"><i class="fa fa-search-plus"></i>Zoom</a>
                        </div>
                    </div>

                    <!--Slide-->
                    <div class="slide">
                        <div class="ts-image"
                            data-bg-image="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWljwiBUfTqvsQqWd3rjwyXKiFY7A8kSFPaDo7uIcArvcunn9gGSa5_IpYZyx5guzFC2Wq_YBkXV8-UNyo9_h4eUHv-uJ-A7L69VylSTVIio5c24zyTkSnTeXo29PZYx0S1uS6eQx9MGU3C6=s1360-w1360-h1020-rw">
                            <a href="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWljwiBUfTqvsQqWd3rjwyXKiFY7A8kSFPaDo7uIcArvcunn9gGSa5_IpYZyx5guzFC2Wq_YBkXV8-UNyo9_h4eUHv-uJ-A7L69VylSTVIio5c24zyTkSnTeXo29PZYx0S1uS6eQx9MGU3C6=s1360-w1360-h1020-rw"
                                class="ts-zoom popup-image"><i class="fa fa-search-plus"></i>Zoom</a>
                        </div>
                    </div>

                </div>

            </section>

            <!--CONTENT
            =========================================================================================================-->
            <section id="content">
                <div class="container">
                    <div class="row flex-wrap-reverse">

                        <!--LEFT SIDE
                        =============================================================================================-->
                        <div class="col-md-5 col-lg-4">

                            <!--DETAILS
                            =========================================================================================-->
                            <section>
                                <h3>Details</h3>
                                <div class="ts-box">

                                    <dl class="ts-description-list__line mb-0">

                                        <dt>ID:</dt>
                                        <dd>#KOS-KLR-001</dd>

                                        <dt>Category:</dt>
                                        <dd>Boarding House / Kost</dd>

                                        <dt>Status:</dt>
                                        <dd>Rent (Sewa)</dd>

                                        <dt>Area:</dt>
                                        <dd>12 m<sup>2</sup></dd>

                                        <dt>Rooms:</dt>
                                        <dd>4 Kamar</dd>

                                        <dt>Bathrooms:</dt>
                                        <dd>1 Kamar Mandi Dalam</dd>

                                        <dt>Bedrooms:</dt>
                                        <dd>1 (1 Kasur)</dd>

                                        <dt>Garages:</dt>
                                        <dd>Motor (Gratis) / Mobil (Rp50.000)</dd>

                                    </dl>

                                </div>
                            </section>

                            <!--CONTACT THE AGENT
                            =========================================================================================-->
                            <section class="contact-the-agent">
                                <h3>Contact the Agent</h3>

                                <div class="ts-box">

                                    <!--Agent Image & Phone-->
                                    <div class="ts-center__vertical mb-4">

                                        <!--Image-->
                                        <a href="#" class="ts-circle p-5 mr-4 ts-shadow__sm"
                                            data-bg-image="{{ asset('assets/img/img-person-05.jpg') }}"></a>

                                        <!--Phone contact-->
                                        <figure class="mb-0">
                                            <h5 class="mb-0">Rokhim Wicaksono</h5>
                                            <p class="mb-0">
                                                <i class="fa fa-phone-square ts-opacity__50 mr-2"></i>
                                                +62 802-862-1673
                                            </p>
                                        </figure>
                                    </div>

                                    <!--Agent contact form-->
                                    <form id="form-agent" class="ts-form">

                                        <!--Name-->
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="name" name="name"
                                                placeholder="Your Name">
                                        </div>

                                        <!--Email-->
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Your Email">
                                        </div>

                                        <!--Message-->
                                        <div class="form-group">
                                            <textarea class="form-control" id="form-contact-message" rows="3"
                                                name="message"
                                                placeholder="Hi, I want to have more information about property #KOS-KLR-001"></textarea>
                                        </div>

                                        <!--Submit button-->
                                        <div class="form-group clearfix mb-0">
                                            <button type="submit" class="btn btn-primary float-right"
                                                id="form-contact-submit">Send a Message
                                            </button>
                                        </div>

                                    </form>

                                    <!-- ===== TOMBOL BOOKING DITARUH DI SINI ===== -->
                                    <hr class="my-4">
                                    <div class="text-center">
                                        <a href="payment.html?property=KOS-KLR-001&price=1000000&name=Cozy%20Kost%20Rungkut"
                                            class="btn btn-success btn-lg btn-block">
                                            <i class="fa fa-calendar-check mr-2"></i>
                                            Booking Sekarang
                                        </a>
                                        <small class="text-muted"></small>
                                    </div>
                                    <!-- ===== AKHIR TOMBOL BOOKING ===== -->

                                </div>
                            </section>

                            <!--LOCATION
                        =============================================================================================-->
                            <section id="location">
                                <h3>Location</h3>

                                <div class="ts-box">

                                    <dl class="ts-description-list__line mb-0">

                                        <dt><i class="fa fa-map-marker ts-opacity__30 mr-2"></i>Address:</dt>
                                        <dd class="border-bottom pb-2">Jl. Kalirungkut No. 88, Ruko Rungkut Makmur Blok
                                            C, Surabaya, Jawa Timur 60293</dd>

                                        <dt><i class="fa fa-phone-square ts-opacity__30 mr-2"></i>Phone:</dt>
                                        <dd class="border-bottom pb-2">+62 802-862-1673</dd>

                                        <dt><i class="fa fa-envelope ts-opacity__30 mr-2"></i>Email:</dt>
                                        <dd class="border-bottom pb-2"><a href="#">hello@property.com</a></dd>

                                        <dt><i class="fa fa-globe ts-opacity__30 mr-2"></i>Website:</dt>
                                        <dd><a href="#">www.property.com</a></dd>

                                    </dl>

                                </div>

                            </section>

                            <!--ACTIONS
                        =============================================================================================-->
                            <section id="actions">

                                <div class="d-flex justify-content-between">

                                    <a href="#" class="btn btn-light mr-2 w-100" data-toggle="tooltip"
                                        data-placement="top" title="Add to favorites">
                                        <i class="far fa-star"></i>
                                    </a>

                                    <a href="#" class="btn btn-light mr-2 w-100" data-toggle="tooltip"
                                        data-placement="top" title="Print">
                                        <i class="fa fa-print"></i>
                                    </a>

                                    <a href="#" class="btn btn-light mr-2 w-100" data-toggle="tooltip"
                                        data-placement="top" title="Add to compare">
                                        <i class="fa fa-exchange-alt"></i>
                                    </a>

                                    <a href="#" class="btn btn-light w-100" data-toggle="tooltip" data-placement="top"
                                        title="Share property">
                                        <i class="fa fa-share-alt"></i>
                                    </a>

                                </div>

                            </section>

                        </div>
                        <!--end col-md-4-->

                        <!--RIGHT SIDE
                        =============================================================================================-->
                        <div class="col-md-7 col-lg-8">

                            <!--QUICK INFO
                            =========================================================================================-->
                            <section id="quick-info">
                                <h3>Quick Info</h3>

                                <!--Quick Info-->
                                <div class="ts-quick-info ts-box">

                                    <!--Row-->
                                    <div class="row no-gutters">

                                        <!--Bathrooms-->
                                        <div class="col-sm-3">
                                            <div class="ts-quick-info__item"
                                                data-bg-image="{{ asset('assets/img/icon-quick-info-shower.png') }}">
                                                <h6>Bathrooms</h6>
                                                <figure>1</figure>
                                            </div>
                                        </div>

                                        <!--Bedrooms-->
                                        <div class="col-sm-3">
                                            <div class="ts-quick-info__item"
                                                data-bg-image="{{ asset('assets/img/icon-quick-info-bed.png') }}">
                                                <h6>Bedrooms</h6>
                                                <figure>1</figure>
                                            </div>
                                        </div>

                                        <!--Area-->
                                        <div class="col-sm-3">
                                            <div class="ts-quick-info__item"
                                                data-bg-image="{{ asset('assets/img/icon-quick-info-area.png') }}">
                                                <h6>Area</h6>
                                                <figure>12m<sup>2</sup></figure>
                                            </div>
                                        </div>

                                        <!--Garages-->
                                        <div class="col-sm-3">
                                            <div class="ts-quick-info__item"
                                                data-bg-image="{{ asset('assets/img/icon-quick-info-garages.png') }}">
                                                <h6>Garages</h6>
                                                <figure>1</figure>
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

                                <h3>Description</h3>

                                <p>
                                    Menikmati hunian eksklusif di kawasan Kalirungkut kini semakin mudah. Kost ini
                                    menyuguhkan panorama ala hotel berbintang lima dengan nuansa asri dan tenang, meski
                                    berada di jantung kota yang dekat dengan berbagai pusat perbelanekan serta deretan
                                    kuliner favorit. Keamanan terjamin berkat sistem one way gate yang memantau setiap
                                    akses keluar masuk. Fasilitas unggulan meliputi ruang santai dengan TV bersama,
                                    akses WiFi cepat tanpa batas, pendingin ruangan di setiap sudut kamar, serta
                                    perabotan interior yang lengkap dan modern. Tersedia pula area parkir khusus untuk
                                    satu motor secara cuma-cuma, atau mobil dengan biaya tambahan terjangkau. Kamar
                                    mandi luar tersebar di tiap lantai, total empat unit, ditambah dapur bersama yang
                                    bersih dan fungsional. Lokasi super strategis: hanya sepelemparan batu dari
                                    Transmart, Fave Hotel, pasar tradisional, dan kampus Ubaya. Segera kunjungi alamat
                                    di Ruko Rungkut Makmur Blok C, Jl. Kalirungkut, Surabaya untuk informasi lebih
                                    lanjut.
                                </p>

                            </section>

                            <!--FEATURES
                            =========================================================================================-->
                            <section id="features">

                                <h3>Features</h3>

                                <ul
                                    class="list-unstyled ts-list-icons ts-column-count-4 ts-column-count-sm-2 ts-column-count-md-2">
                                    <li>
                                        <i class="fa fa-bell"></i>
                                        Door Bell
                                    </li>
                                    <li>
                                        <i class="fa fa-wifi"></i>
                                        Wi-Fi
                                    </li>
                                    <li>
                                        <i class="fa fa-utensils"></i>
                                        Restaurant Nearby
                                    </li>
                                    <li>
                                        <i class="fa fa-plug"></i>
                                        230V Plugs
                                    </li>
                                    <li>
                                        <i class="fa fa-wheelchair"></i>
                                        Accessible
                                    </li>
                                    <li>
                                        <i class="fa fa-phone"></i>
                                        Phone
                                    </li>
                                    <li>
                                        <i class="fa fa-bus"></i>
                                        Bus Station
                                    </li>
                                    <li>
                                        <i class="fa fa-key"></i>
                                        Secured Key
                                    </li>
                                </ul>

                            </section>

                            <!--MAP
                            =========================================================================================-->
                            <section id="map-location">

                                <h3>Map</h3>

                                <div class="ts-map ts-map__detail ts-border-radius__sm ts-shadow__sm" id="ts-map-simple"
                                    data-ts-map-leaflet-provider="https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png"
                                    data-ts-map-zoom="12" data-ts-map-center-latitude="40.702411"
                                    data-ts-map-center-longitude="-73.556842" data-ts-map-scroll-wheel="0"
                                    data-ts-map-controls="0"></div>

                            </section>


                            <!--FLOOR PLANS
                            =========================================================================================-->
                            <section id="floor-plans">

                                <h3>Floor Plans</h3>

                                <!--1st Floor-->
                                <a href="#collapse-floor-1" class="ts-box d-block mb-2 py-3" data-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="collapse-floor-1">
                                    1st Floor
                                    <div class="collapse" id="collapse-floor-1">
                                        <img src="{{ asset('assets/img/img-floor-plan-01.jpg') }}" alt="" class="w-100">
                                    </div>
                                </a>

                                <!--2nd Floor-->
                                <a href="#collapse-floor-2" class="ts-box d-block py-3" data-toggle="collapse"
                                    role="button" aria-expanded="false" aria-controls="collapse-floor-2">
                                    2nd Floor
                                    <div class="collapse" id="collapse-floor-2">
                                        <img src="{{ asset('assets/img/img-floor-plan-02.jpg') }}" alt="" class="w-100">
                                    </div>
                                </a>

                            </section>

                            <!--VIDEO
                        =============================================================================================-->

                            <section id="video">

                                <h3>Video</h3>

                                <div class="embed-responsive embed-responsive-16by9 rounded ts-shadow__md">
                                    <iframe
                                        src="https://player.vimeo.com/video/9799783?color=ffffff&title=0&byline=0&portrait=0"
                                        width="640" height="360" frameborder="0" webkitallowfullscreen
                                        mozallowfullscreen allowfullscreen></iframe>
                                </div>

                            </section>

                            <!--AMENITIES
                            =========================================================================================-->
                            <section id="amenities">

                                <h3>Amenities</h3>

                                <ul
                                    class="ts-list-colored-bullets ts-text-color-light ts-column-count-3 ts-column-count-md-2">
                                    <li>Air Conditioning</li>
                                    <li>Upper Balcony</li>
                                    <li>Laundry Room</li>
                                    <li>Alarm</li>
                                    <li>Window Covering</li>
                                    <li>Internet</li>
                                </ul>

                            </section>

                        </div>
                        <!--end col-md-8-->

                    </div>
                    <!--end row-->
                </div>
                <!--end container-->
            </section>

            <!--SIMILAR PROPERTIES
        =============================================================================================================-->
            <section id="similar-properties">
                <div class="container">
                    <div class="row">

                        <div class="offset-lg-4 col-sm-12 col-lg-8">

                            <hr class="mb-5">

                            <h3>Similar Properties</h3>

                            <!--Item-->
                            <div class="card ts-item ts-item__list ts-card">

                                <!--Ribbon-->
                                <div class="ts-ribbon">
                                    <i class="fa fa-thumbs-up"></i>
                                </div>

                                <!--Card Image-->
                                <a href="{{ route('owner.kos.show', $kos['slug'] ?? 'kos-putri-melati') }}" class="card-img"
                                    data-bg-image="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWkr0Rz1Dy4XtpuLgR_HNuvHII7Vr49DvRNI2ge3XZ4qk5dqsC4aoHlLh4mqIeZ2t3tKfNvK5Sa-krtd8Gexlpku_JoNxgowbIoQEjjfqUFT5MxmBTWnKC0v61tTIoO2pm1dGrqUjQ=w426-h240-k-no"></a>

                                <!--Card Body-->
                                <div class="card-body">

                                    <figure class="ts-item__info">
                                        <h4>Kost ITA Gunung Anyar</h4>
                                        <aside>
                                            <i class="fa fa-map-marker mr-2"></i>
                                            1350 Arbutus Drive
                                        </aside>
                                    </figure>

                                    <div class="ts-item__info-badge">
                                        Rp.1,350,000
                                    </div>

                                    <div class="ts-description-lists">
                                        <dl>
                                            <dt>Area</dt>
                                            <dd>12m<sup>2</sup></dd>
                                        </dl>
                                        <dl>
                                            <dt>Bedrooms</dt>
                                            <dd>2</dd>
                                        </dl>
                                        <dl>
                                            <dt>Bathrooms</dt>
                                            <dd>1</dd>
                                        </dl>
                                    </div>
                                </div>

                                <!--Card Footer-->
                                <a href="{{ route('owner.kos.show', $kos['slug'] ?? 'kos-putri-melati') }}" class="card-footer">
                                    <span class="ts-btn-arrow">Detail</span>
                                </a>

                            </div>

                            <!--Item-->
                            <div class="card ts-item ts-item__list ts-card">

                                <!--Ribbon-->
                                <div class="ts-ribbon-corner">
                                    <span>Updated</span>
                                </div>

                                <!--Card Image-->
                                <a href="{{ route('owner.kos.show', $kos['slug'] ?? 'kos-putri-melati') }}" class="card-img ts-item__image"
                                    data-bg-image="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWmVCh5KMnP2CUvofWPr9yK28uYLcgJe7_IAnIWNblKZib66RXioKXFjnc6uWYxiOBTLXsHSGJrrg3Xd19f_ZC4Rn0BYrGRq2Q2Hu-W_UIWlh9zJbXTuH-9I-r7MvP0DcIS1AbzXmdR-r3o=w408-h306-k-no"></a>

                                <!--Card Body-->
                                <div class="card-body ts-item__body">

                                    <figure class="ts-item__info">
                                        <h4>Cozy Kost Keputih</h4>
                                        <aside>
                                            <i class="fa fa-map-marker mr-2"></i>
                                            4831 Worthington Drive
                                        </aside>
                                    </figure>

                                    <div class="ts-item__info-badge">Rp1,125,000</div>

                                    <div class="ts-description-lists">
                                        <dl>
                                            <dt>Area</dt>
                                            <dd>12m<sup>2</sup></dd>
                                        </dl>
                                        <dl>
                                            <dt>Bedrooms</dt>
                                            <dd>2</dd>
                                        </dl>
                                        <dl>
                                            <dt>Bathrooms</dt>
                                            <dd>1</dd>
                                        </dl>
                                    </div>
                                </div>

                                <!--Card Footer-->
                                <a href="{{ route('owner.kos.show', $kos['slug'] ?? 'kos-putri-melati') }}" class="card-footer ts-item__footer">
                                    <span class="ts-btn-arrow">Detail</span>
                                </a>

                            </div>

                            <!--Item-->
                            <div class="card ts-item ts-item__list ts-card">

                                <!--Card Image-->
                                <a href="{{ route('owner.kos.show', $kos['slug'] ?? 'kos-putri-melati') }}" class="card-img ts-item__image"
                                    data-bg-image="https://lh3.googleusercontent.com/gps-cs-s/AHRPTWngd6Wr1n4o_ruOoXusb0NY3QwHAjoDydaXRV2UFdBfzQQBhCOgp-126kaNAIttL6eqYtwdj9Hc2OPky4NQMBhRixoGdlfBlQY39Fliz0q-WQIQU27d5LuP4kkwOihRnJHkDU7Wvy4MCJc=w533-h240-k-no"></a>

                                <!--Card Body-->
                                <div class="card-body ts-item__body">

                                    <figure class="ts-item__info">
                                        <h4>Family Kost Gubeng</h4>
                                        <aside>
                                            <i class="fa fa-map-marker mr-2"></i>
                                            4127 Winding Way
                                        </aside>
                                    </figure>

                                    <div class="ts-item__info-badge">Rp1.045,900</div>

                                    <div class="ts-description-lists">
                                        <dl>
                                            <dt>Area</dt>
                                            <dd>10m<sup>2</sup></dd>
                                        </dl>
                                        <dl>
                                            <dt>Bedrooms</dt>
                                            <dd>2</dd>
                                        </dl>
                                        <dl>
                                            <dt>Bathrooms</dt>
                                            <dd>1</dd>
                                        </dl>
                                    </div>
                                </div>

                                <!--Card Footer-->
                                <a href="{{ route('owner.kos.show', $kos['slug'] ?? 'kos-putri-melati') }}" class="card-footer ts-item__footer">
                                    <span class="ts-btn-arrow">Detail</span>
                                </a>

                            </div>

                        </div>

                    </div>
                </div>
            </section>

        </main>
        <!--end #ts-main-->
@endsection
