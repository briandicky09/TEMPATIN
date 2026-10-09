{{-- Navbar khusus area owner --}}
<header id="ts-header" class="fixed-top">

    <nav id="ts-secondary-navigation" class="navbar p-0">
        <div class="container justify-content-end justify-content-sm-between">
            <div class="navbar-nav d-none d-sm-block">
                <span class="mr-4">
                    <i class="fa fa-briefcase mr-1"></i>
                    Owner Center
                </span>
                <a href="mailto:owner@tempatin.id">
                    <i class="fa fa-envelope mr-1"></i>
                    owner@tempatin.id
                </a>
            </div>

            <div class="navbar-nav flex-row align-items-center">
                <span class="nav-link px-3 d-none d-md-inline text-muted">Mode Owner</span>
                <a href="{{ route('home') }}" class="nav-link px-3 border-left">Lihat Halaman Publik</a>
            </div>
        </div>
    </nav>

    <nav id="ts-primary-navigation" class="navbar navbar-expand-md navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('owner.dashboard') }}">
                <span class="pk-logo"><i class="fa fa-building mr-2"></i>TEMPATIN Owner</span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarOwner" aria-controls="navbarOwner" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarOwner">
                <ul class="navbar-nav">
                    <li class="nav-item {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                        <a class="nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}" href="{{ route('owner.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown {{ request()->routeIs('owner.kos.*') ? 'active' : '' }}">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('owner.kos.*') ? 'active' : '' }}" href="#" id="ownerKosDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manajemen Kos
                        </a>
                        <div class="dropdown-menu shadow-sm border-0" aria-labelledby="ownerKosDropdown">
                            <a class="dropdown-item {{ request()->routeIs('owner.kos.my') ? 'active' : '' }}" href="{{ route('owner.kos.my') }}"><i class="fa fa-home fa-fw mr-2"></i>Kos Saya</a>
                            <a class="dropdown-item {{ request()->routeIs('owner.kos.create') ? 'active' : '' }}" href="{{ route('owner.kos.create') }}"><i class="fa fa-plus fa-fw mr-2"></i>Tambah Kos</a>
                            <a class="dropdown-item {{ request()->routeIs('owner.kos.penilaian') ? 'active' : '' }}" href="{{ route('owner.kos.penilaian') }}"><i class="fa fa-star fa-fw mr-2"></i>Penilaian Kos</a>
                        </div>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto d-flex flex-row align-items-center">
                    <!-- Notification Dropdown -->
                    <li class="nav-item dropdown mr-3">
                        <a class="nav-link" href="#" id="notificationOwnerDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell fa-lg text-dark"></i>
                            <span class="badge badge-danger badge-pill position-absolute" style="top: 5px; right: 0; font-size: 0.6rem;">0</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" aria-labelledby="notificationOwnerDropdown" style="width: 320px; padding: 0; border-radius: 8px;">
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
                        <a class="nav-link member-profile-toggle dropdown-toggle p-0" href="#" id="ownerProfileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Menu profil">
                            <img src="{{ asset('assets/svg/logo-profil.png') }}" alt="Profil" class="member-profile__logo" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right member-profile-menu shadow-sm border-0 mt-2" aria-labelledby="ownerProfileDropdown" style="border-radius: 8px;">
                            <a class="dropdown-item py-2" href="{{ route('owner.dashboard') }}">Profil saya</a>
                            <a class="dropdown-item py-2" href="{{ route('owner.statistik') }}">Laporan Statistik</a>
                            <a class="dropdown-item py-2" href="{{ route('contact') }}">Pusat bantuan</a>
                            <div class="dropdown-divider"></div>
                            <form id="owner-form-logout" action="{{ route('owner.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2">Logout</button>
                            </form>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</header>
