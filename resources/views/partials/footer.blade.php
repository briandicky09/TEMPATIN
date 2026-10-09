{{-- Footer TEMPATIN --}}
<footer id="ts-footer" @if(!($noMarginFooter ?? false)) id="tentang" @else style="margin-top: 0 !important;" @endif>

    <!--MAIN FOOTER CONTENT
    =============================================================================================================-->
    <section id="ts-footer-main">
        <div class="container">
            <div class="row">

                <!--Brand and description-->
                <div class="col-md-4">
                    <a href="{{ route('home') }}" class="brand">
                        <span class="pk-logo pk-logo--footer"><i class="fa fa-home mr-2"></i>TEMPATIN</span>
                    </a>
                    <p class="mb-4">
                        TEMPATIN membantu kamu menemukan kos impian dengan mudah, cepat, dan aman.
                        Ribuan pilihan kos putra, putri, campur, dan eksklusif tersedia di seluruh Indonesia.
                    </p>
                    <a href="{{ route('home') }}#kontak" class="btn btn-outline-dark mb-4">Hubungi Kami</a>
                </div>

                <!--Navigation-->
                <div class="col-md-2">
                    <h4>Navigasi</h4>
                    <nav class="nav flex-row flex-md-column mb-4">
                        <a href="{{ route('home') }}" class="nav-link">Home</a>
                        <a href="{{ route('search.kos') }}" class="nav-link">Cari Kos</a>
                        <a href="{{ route('promo') }}" class="nav-link">Promo</a>
                        <a href="{{ route('home') }}#artikel" class="nav-link">Artikel</a>
                    </nav>
                </div>

                <!--Akun-->
                <div class="col-md-3">
                    <h4>Akun</h4>
                    <nav class="nav flex-row flex-md-column mb-4">
                        <a href="{{ route('login') }}" class="nav-link">Masuk</a>
                        <a href="{{ route('register') }}" class="nav-link">Daftar</a>
                        <a href="{{ route('owner.kos.create') }}" class="nav-link">Jadi Mitra Pemilik Kos</a>
                    </nav>
                </div>

                <!--Contact Info-->
                <div class="col-md-3" id="kontak">
                    <h4>Kontak</h4>
                    <address class="ts-text-color-light">
                        Jl. Raya Sidoarjo No. 17
                        <br>
                        Sidoarjo, Jawa Timur
                        <br>
                        <strong>Email: </strong>
                        <a href="mailto:hello@tempatin.id" class="btn-link">hello@tempatin.id</a>
                        <br>
                        <strong>Telepon:</strong>
                        0800-1-TEMPATIN
                    </address>
                </div>

            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
    <!--end ts-footer-main-->

    <!--SECONDARY FOOTER CONTENT
    =============================================================================================================-->
    <section id="ts-footer-secondary">
        <div class="container">

            <!--Copyright-->
            <div class="ts-copyright">&copy; {{ date('Y') }} TEMPATIN. Seluruh hak cipta dilindungi.</div>

            <!--Social Icons-->
            <div class="ts-footer-nav">
                <nav class="nav">
                    <a href="#" class="nav-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="nav-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="nav-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="nav-link"><i class="fab fa-youtube"></i></a>
                </nav>
            </div>
            <!--end ts-footer-nav-->

        </div>
        <!--end container-->
    </section>
    <!--end ts-footer-secondary-->

</footer>
<!--end #ts-footer-->
