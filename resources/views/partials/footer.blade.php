{{-- Footer TEMPATIN - Notion Design System --}}
<footer id="ts-footer">

    <div class="container py-5">
        <div class="row">

            <!-- Brand and description -->
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center mb-3 text-decoration-none" aria-label="TEMPATIN Beranda">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="TEMPATIN" style="height: 30px; width: auto; object-fit: contain;">
                </a>
                <p class="text-muted mb-4" style="max-width: 320px; font-size: 14px; line-height: 1.6;">
                    Ruang kerja dan platform terpercaya untuk menemukan serta menyewa kos impian di seluruh kota di Indonesia dengan kurasi transparan dan proses instan.
                </p>
                <div>
                    <a href="{{ route('contact') }}" class="btn btn-outline-dark btn-sm">
                        <i class="fa fa-envelope mr-1"></i> Hubungi Kami
                    </a>
                </div>
            </div>

            <!-- Navigasi Utama -->
            <div class="col-lg-2 col-md-6 col-6 mb-4 mb-lg-0">
                <h4>Navigasi</h4>
                <nav class="d-flex flex-column" style="gap: 8px;">
                    <a href="{{ route('home') }}" class="nav-link p-0 text-muted">Home</a>
                    <a href="{{ route('search.kos') }}" class="nav-link p-0 text-muted">Cari Kos</a>
                    <a href="{{ route('promo') }}" class="nav-link p-0 text-muted">Promo &amp; Diskon</a>
                    <a href="{{ route('artikel') }}" class="nav-link p-0 text-muted">Artikel &amp; Tips</a>
                </nav>
            </div>

            <!-- Akun & Mitra -->
            <div class="col-lg-3 col-md-6 col-6 mb-4 mb-lg-0">
                <h4>Akun &amp; Mitra</h4>
                <nav class="d-flex flex-column" style="gap: 8px;">
                    @guest
                        <a href="{{ route('login') }}" class="nav-link p-0 text-muted">Masuk ke Akun</a>
                        <a href="{{ route('register') }}" class="nav-link p-0 text-muted">Daftar Akun Baru</a>
                    @else
                        @if(Auth::user()->role === 'owner')
                            <a href="{{ route('owner.dashboard') }}" class="nav-link p-0 text-muted">Dashboard Pemilik</a>
                        @else
                            <a href="{{ route('member.home') }}" class="nav-link p-0 text-muted">Area Member</a>
                        @endif
                    @endguest
                    <a href="{{ route('owner.kos.create') }}" class="nav-link p-0 text-muted">Daftarkan Kos Kamu</a>
                    <a href="{{ route('about') }}" class="nav-link p-0 text-muted">Tentang TEMPATIN</a>
                </nav>
            </div>

            <!-- Kontak & Kantor -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" id="kontak">
                <h4>Kontak &amp; Bantuan</h4>
                <address class="text-muted mb-0" style="font-size: 14px; line-height: 1.7; font-style: normal;">
                    Jl. Raya Sidoarjo No. 17<br>
                    Jawa Timur, Indonesia<br>
                    <span class="d-block mt-2">
                        <strong class="text-dark">Email:</strong>
                        <a href="mailto:hello@tempatin.id" class="text-decoration-none" style="color: var(--color-notion-blue); font-weight: 500;">hello@tempatin.id</a>
                    </span>
                    <span>
                        <strong class="text-dark">Hotline:</strong> 0800-1-TEMPATIN
                    </span>
                </address>
            </div>

        </div>
    </div>

    <!-- Secondary Footer / Copyright -->
    <div id="ts-footer-secondary">
        <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <div class="ts-copyright mb-2 mb-sm-0">
                &copy; {{ date('Y') }} <strong>TEMPATIN</strong>. Seluruh hak cipta dilindungi.
            </div>
            <div class="d-flex align-items-center" style="gap: 16px;">
                <a href="#" class="nav-link p-0" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="nav-link p-0" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="nav-link p-0" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="nav-link p-0" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

</footer>
