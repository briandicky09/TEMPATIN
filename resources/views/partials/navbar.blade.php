{{-- Header / Navbar TEMPATIN --}}
<header id="ts-header" class="fixed-top">

    <!-- SECONDARY NAVIGATION
    =============================================================================================================-->
    <nav id="ts-secondary-navigation" class="navbar p-0">
        <div class="container justify-content-end justify-content-sm-between">

            <!--Left Side-->
            <div class="navbar-nav d-none d-sm-block">
                <span class="mr-4">
                    <i class="fa fa-phone-square mr-1"></i>
                    0800-1-TEMPATIN
                </span>
                <a href="mailto:hello@tempatin.id">
                    <i class="fa fa-envelope mr-1"></i>
                    hello@tempatin.id
                </a>
            </div>

            <!--Right Side-->
            <div class="navbar-nav flex-row">
                @guest
                <a href="{{ route('login') }}" class="nav-link px-3">Masuk</a>
                <a href="{{ route('register') }}" class="nav-link px-3 border-left">Daftar</a>
                @endguest
                @auth
                    @if(Auth::user()->role === 'owner')
                        <a href="{{ route('owner.dashboard') }}" class="nav-link px-3">Area Owner</a>
                    @else
                        <a href="{{ route('member.home') }}" class="nav-link px-3">Area Member</a>
                    @endif
                @endauth
            </div>
            <!--end navbar-nav-->
        </div>
        <!--end container-->
    </nav>

    <!--PRIMARY NAVIGATION
    =============================================================================================================-->
    <nav id="ts-primary-navigation" class="navbar navbar-expand-md navbar-light">
        <div class="container">

            <!--Brand Logo-->
            @php $isMemberArea = request()->is('member*'); @endphp
            <a class="navbar-brand" href="{{ $isMemberArea ? url('/member' . route('home', [], false)) : route('home') }}">
                <span class="pk-logo"><i class="fa fa-home mr-2"></i>TEMPATIN</span>
            </a>

            <!--Responsive Collapse Button-->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarPrimary" aria-controls="navbarPrimary" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!--Collapsing Navigation-->
            <div class="collapse navbar-collapse" id="navbarPrimary">

                <ul class="navbar-nav">
                    <li class="nav-item {{ (request()->routeIs('home') || request()->routeIs('member.home') || request()->is('member')) ? 'active' : '' }}">
                        <a class="nav-link {{ (request()->routeIs('home') || request()->routeIs('member.home') || request()->is('member')) ? 'active' : '' }}" href="{{ $isMemberArea ? url('/member' . route('home', [], false)) : route('home') }}">Home @if(request()->routeIs('home') || request()->routeIs('member.home'))<span class="sr-only">(current)</span>@endif</a>
                    </li>
                    <li class="nav-item {{ (request()->routeIs('kos.index') || request()->routeIs('member.kos.index') || request()->routeIs('search.kos') || request()->routeIs('member.search.kos') || request()->is('kos') || request()->is('member/kos') || request()->is('member/search')) ? 'active' : '' }}">
                        <a class="nav-link {{ (request()->routeIs('kos.index') || request()->routeIs('member.kos.index') || request()->routeIs('search.kos') || request()->routeIs('member.search.kos') || request()->is('kos') || request()->is('member/kos') || request()->is('member/search')) ? 'active' : '' }}" href="{{ $isMemberArea ? url('/member' . route('kos.index', [], false)) : route('kos.index') }}">Cari Kos</a>
                    </li>
                    <li class="nav-item {{ (request()->routeIs('promo') || request()->routeIs('member.promo') || request()->is('member/promo')) ? 'active' : '' }}">
                        <a class="nav-link {{ (request()->routeIs('promo') || request()->routeIs('member.promo') || request()->is('member/promo')) ? 'active' : '' }}" href="{{ $isMemberArea ? url('/member' . route('promo', [], false)) : route('promo') }}">Promo @if(request()->routeIs('promo') || request()->routeIs('member.promo'))<span class="sr-only">(current)</span>@endif</a>
                    </li>
                    @php
                        $isMoreActive = request()->routeIs('artikel', 'member.artikel', 'about', 'member.about', 'contact', 'member.contact') || request()->is('member/artikel', 'member/tentang', 'member/kontak');
                    @endphp
                    <li class="nav-item dropdown {{ $isMoreActive ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle {{ $isMoreActive ? 'active' : '' }}" href="#" id="moreDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Lainnya
                        </a>
                        <div class="dropdown-menu" aria-labelledby="moreDropdown">
                            <a class="dropdown-item" href="{{ $isMemberArea ? url('/member' . route('artikel', [], false)) : route('artikel') }}">Artikel</a>
                            <a class="dropdown-item" href="{{ $isMemberArea ? url('/member' . route('about', [], false)) : route('about') }}">Tentang</a>
                            <a class="dropdown-item" href="{{ $isMemberArea ? url('/member' . route('contact', [], false)) : route('contact') }}">Kontak</a>
                        </div>
                    </li>
                </ul>

                @if(!$isMemberArea)
                    @guest
                    <ul class="navbar-nav ml-auto d-none d-md-flex">
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-dark btn-sm mr-2">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                        </li>
                    </ul>
                    @else
                    <ul class="navbar-nav ml-auto d-none d-md-flex align-items-center">
                        <li class="nav-item">
                            @if(Auth::user()->role === 'owner')
                                <a href="{{ route('owner.dashboard') }}" class="btn btn-primary btn-sm"><i class="fa fa-tachometer-alt mr-1"></i> Dashboard Owner</a>
                            @else
                                <a href="{{ route('member.home') }}" class="btn btn-primary btn-sm"><i class="fa fa-user mr-1"></i> Area Member</a>
                            @endif
                        </li>
                    </ul>
                    @endguest
                @else
                <ul class="navbar-nav ml-auto d-flex flex-row align-items-center">
                    <!-- Notification Dropdown -->
                    <li class="nav-item dropdown mr-3">
                        <a class="nav-link" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell fa-lg text-dark"></i>
                            <span class="badge badge-danger badge-pill position-absolute" style="top: 5px; right: 0; font-size: 0.6rem;">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" aria-labelledby="notificationDropdown" style="width: 320px; padding: 0; border-radius: 8px;">
                            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                                <h6 class="mb-0 font-weight-bold">Notifikasi</h6>
                                <a href="#" class="text-dark" onclick="event.stopPropagation(); $(this).closest('.dropdown-menu').removeClass('show');"><i class="fa fa-times"></i></a>
                            </div>
                            <div class="p-2 border-bottom bg-light">
                                <span class="badge badge-pill border px-3 py-2 bg-white text-dark"><i class="fa fa-info-circle mr-1"></i> Utama</span>
                            </div>
                            <div class="text-center py-5">
                                <i class="fa fa-envelope-open-text fa-4x mb-3" style="color: #dee2e6 !important;"></i>
                                <h6 class="font-weight-bold text-dark mt-2">Belum ada notifikasi...</h6>
                                <p class="text-muted small mb-0 px-4">Belum ada notifikasi. Ketika ada notifikasi baru, akan muncul di halaman ini.</p>
                            </div>
                        </div>
                    </li>
                    
                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link member-profile-toggle dropdown-toggle p-0" href="#" id="memberProfileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Menu profil">
                            <img src="{{ asset('assets/svg/logo-profil.png') }}" alt="Profil" class="member-profile__logo" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right member-profile-menu shadow-sm border-0 mt-2" aria-labelledby="memberProfileDropdown" style="border-radius: 8px;">
                            <a class="dropdown-item py-2" href="{{ route('member.profile') }}">Profil saya</a>
                            <a class="dropdown-item py-2" href="{{ route('member.invoice.index') }}">Riwayat Transaksi</a>
                            <a class="dropdown-item py-2" href="{{ route('member.contact') }}">Pusat bantuan</a>
                            <div class="dropdown-divider"></div>
                            <form id="form-logout" action="{{ route('member.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2">Logout</button>
                            </form>
                        </div>
                    </li>
                </ul>
                @endif

            </div>
            <!--end navbarPrimary-->

        </div>
        <!--end container-->
    </nav>
    <!--end #ts-primary-navigation-->

    @if($isMemberArea)
    <a href="{{ route('member.pesan') }}" class="member-floating-chat" aria-label="Pesan">
        <img src="{{ asset('assets/svg/logo-pesan.png') }}" alt="Logo pesan" class="member-floating-chat__logo">
    </a>
    @endif

</header>
