{{-- Header / Notion Navbar TEMPATIN --}}
@php
    $isMemberArea = request()->is('member*');
    $homeUrl = $isMemberArea ? url('/member' . route('home', [], false)) : route('home');
    $kosUrl = $isMemberArea ? url('/member' . route('kos.index', [], false)) : route('kos.index');
    $promoUrl = $isMemberArea ? url('/member' . route('promo', [], false)) : route('promo');
    $artikelUrl = $isMemberArea ? url('/member' . route('artikel', [], false)) : route('artikel');
    $aboutUrl = $isMemberArea ? url('/member' . route('about', [], false)) : route('about');
    $contactUrl = $isMemberArea ? url('/member' . route('contact', [], false)) : route('contact');
@endphp

<header id="ts-header" class="notion-navbar-wrapper card-nav-wrapper fixed-top">
    <div class="notion-navbar-container card-nav-container">
        <nav class="notion-navbar card-nav" id="mainNotionNav" aria-label="Navigasi Utama">
            
            <!-- Left: Logo TEMPATIN -->
            <div class="notion-nav-left">
                <a href="{{ $homeUrl }}" class="notion-nav-brand card-nav-brand" aria-label="TEMPATIN Beranda">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="TEMPATIN" class="notion-nav-logo-img card-nav-logo-img">
                </a>
            </div>

            <!-- Middle: Navigation Links ("tulisan-tulisan") -->
            <div class="notion-nav-center">
                @if(Auth::check() && Auth::user()->role !== 'owner')
                    {{-- Member Navigation Items --}}
                    <div class="member-nav-items d-none d-lg-flex align-items-center">
                        <a href="{{ $kosUrl }}" class="notion-nav-link member-nav-link {{ request()->routeIs('member.kos.*') || request()->routeIs('kos.*') ? 'active' : '' }}">
                            Cari Kos
                        </a>
                        <a href="{{ route('member.favorit') }}" class="notion-nav-link member-nav-link {{ request()->routeIs('member.favorit') ? 'active' : '' }}">
                            Favorit
                        </a>
                        <a href="{{ route('member.pesan') }}" class="notion-nav-link member-nav-link {{ request()->routeIs('member.pesan') || request()->routeIs('member.chat') ? 'active' : '' }}">
                            Chat
                        </a>

                        {{-- Notifikasi Popover --}}
                        <div class="member-nav-dropdown dropdown notification-dropdown position-relative">
                            <a href="javascript:void(0)" class="notion-nav-link member-nav-link d-inline-flex align-items-center" id="memberNotificationToggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>Notifikasi</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow notification-popover-card" id="memberNotificationPopover" aria-labelledby="memberNotificationToggle" style="width: 340px; max-width: 90vw; border-radius: 12px; border: 1px solid rgba(0,0,0,0.08); box-shadow: 0 12px 32px rgba(0,0,0,0.08), 0 2px 6px rgba(0,0,0,0.04) !important; padding: 0; margin-top: 10px; overflow: hidden; background: #ffffff;">
                                <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                                    <h5 class="mb-0 font-weight-bold text-dark" style="font-size: 15px; font-family: var(--font-notioninter, 'Inter', sans-serif);">
                                        Notifikasi
                                    </h5>
                                    <button type="button" class="close p-0 text-muted" id="btnCloseNotification" style="font-size: 18px; line-height: 1; opacity: 0.6;" aria-label="Tutup notifikasi">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="px-4 pt-3 pb-2">
                                    <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill" style="border: 1px solid rgba(0,0,0,0.12); font-size: 11.5px; font-weight: 600; color: #111111; background: #ffffff;">
                                        <i class="fa fa-info-circle mr-1" style="font-size: 11px;"></i> Utama
                                    </span>
                                </div>
                                <div class="px-4 py-4 text-center">
                                    <div class="mb-3 d-flex justify-content-center">
                                        <svg width="150" height="100" viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <ellipse cx="100" cy="85" rx="85" ry="50" fill="#f6f5f4"/>
                                            <circle cx="110" cy="25" r="2.5" fill="#0075de" opacity="0.6"/>
                                            <circle cx="95" cy="28" r="1.5" fill="#0075de" opacity="0.6"/>
                                            <circle cx="145" cy="35" r="2" fill="#0075de" opacity="0.6"/>
                                            <rect x="35" y="70" width="8" height="35" rx="2" fill="#e6f3fe" opacity="0.7"/>
                                            <rect x="50" y="65" width="8" height="40" rx="2" fill="#e6f3fe" opacity="0.7"/>
                                            <rect x="65" y="70" width="8" height="35" rx="2" fill="#e6f3fe" opacity="0.7"/>
                                            <rect x="125" y="70" width="8" height="35" rx="2" fill="#e6f3fe" opacity="0.7"/>
                                            <rect x="140" y="65" width="8" height="40" rx="2" fill="#e6f3fe" opacity="0.7"/>
                                            <rect x="155" y="70" width="8" height="35" rx="2" fill="#e6f3fe" opacity="0.7"/>
                                            <rect x="30" y="80" width="140" height="4" rx="2" fill="#bae0fd" opacity="0.6"/>
                                            <rect x="114" y="75" width="12" height="45" rx="2" fill="#615d59"/>
                                            <path d="M100 65 L128 65 Q135 65 135 73 L135 88 Q135 94 128 94 L100 94 Q93 94 93 88 L93 73 Q93 65 100 65 Z" fill="#ffb110" stroke="#d97706" stroke-width="1.5"/>
                                            <ellipse cx="98" cy="80" rx="9" ry="14" fill="#f59e0b"/>
                                            <rect x="118" y="55" width="3" height="15" fill="#64748b"/>
                                            <polygon points="121,55 133,59 121,63" fill="#ffb110"/>
                                            <circle cx="75" cy="55" r="14" fill="#fed7aa"/>
                                            <circle cx="72" cy="54" r="1.5" fill="#1e293b"/>
                                            <circle cx="80" cy="54" r="1.5" fill="#1e293b"/>
                                            <ellipse cx="100" cy="118" rx="65" ry="4" fill="#e2e8f0"/>
                                        </svg>
                                    </div>
                                    <h4 class="font-weight-bold mb-2 text-dark" style="font-size: 14.5px; font-family: var(--font-notioninter, 'Inter', sans-serif);">
                                        Belum ada notifikasi...
                                    </h4>
                                    <p class="text-muted mb-0 mx-auto" style="font-size: 12px; line-height: 1.5; max-width: 260px;">
                                        Belum ada notifikasi. Ketika ada notifikasi baru, akan muncul di halaman ini.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Lainnya Dropdown --}}
                        <div class="member-nav-dropdown dropdown">
                            <a href="javascript:void(0)" class="notion-nav-link member-nav-link dropdown-toggle d-inline-flex align-items-center" id="memberNavLainnyaToggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>Lainnya</span>
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 4px;">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right member-custom-dropdown shadow" id="memberNavLainnyaMenu" aria-labelledby="memberNavLainnyaToggle">
                                <a class="dropdown-item py-2" href="{{ $promoUrl }}">
                                    <i class="fa fa-tag mr-2 text-muted" style="width: 16px;"></i> Voucher &amp; Promo
                                </a>
                                <a class="dropdown-item py-2" href="{{ $artikelUrl }}">
                                    <i class="fa fa-newspaper mr-2 text-muted" style="width: 16px;"></i> Artikel &amp; Tips
                                </a>
                                <a class="dropdown-item py-2" href="{{ $contactUrl }}">
                                    <i class="fa fa-life-ring mr-2 text-muted" style="width: 16px;"></i> Pusat Bantuan
                                </a>
                                <div class="dropdown-divider my-1"></div>
                                <a class="dropdown-item py-2" href="{{ $aboutUrl }}">
                                    <i class="fa fa-info-circle mr-2 text-muted" style="width: 16px;"></i> Tentang TEMPATIN
                                </a>
                            </div>
                        </div>
                    </div>
                @elseif(Auth::check() && Auth::user()->role === 'owner')
                    {{-- Owner Navigation Items in Center --}}
                    <div class="d-none d-lg-flex align-items-center notion-nav-links">
                        <a href="{{ route('owner.dashboard') }}" class="notion-nav-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('owner.kos.index') }}" class="notion-nav-link {{ request()->routeIs('owner.kos.*') ? 'active' : '' }}">
                            Kelola Kos
                        </a>
                        <a href="{{ route('owner.statistik') }}" class="notion-nav-link {{ request()->routeIs('owner.statistik') ? 'active' : '' }}">
                            Statistik
                        </a>
                        <a href="{{ $aboutUrl }}" class="notion-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                            Tentang Platform
                        </a>
                    </div>
                @else
                    {{-- Guest Navigation Items in Center ("tulisan-tulisan" sesuai DESIGN.md) --}}
                    <div class="d-none d-lg-flex align-items-center notion-nav-links">
                        <a href="{{ $homeUrl }}" class="notion-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            Beranda
                        </a>
                        <a href="{{ $promoUrl }}" class="notion-nav-link {{ request()->routeIs('promo') ? 'active' : '' }}">
                            Promo &amp; Voucher
                        </a>
                        <a href="{{ $artikelUrl }}" class="notion-nav-link {{ request()->routeIs('artikel') ? 'active' : '' }}">
                            Artikel &amp; Tips
                        </a>
                        <a href="{{ $aboutUrl }}" class="notion-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                            Tentang Kami
                        </a>
                        <a href="{{ $contactUrl }}" class="notion-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                            Pusat Bantuan
                        </a>
                    </div>
                @endif
            </div>

            <!-- Right: Cari Kos dan Masuk/Login (atau Profil Akun) -->
            <div class="notion-nav-right card-nav-actions">
                @guest
                    <a href="{{ route('login') }}" class="notion-btn-ghost card-nav-cta-secondary" data-toggle="modal" data-target="#authRoleModal" data-auth-mode="login">
                        Masuk
                    </a>
                    <a href="{{ $kosUrl }}" class="notion-btn-primary card-nav-cta-btn">
                        <span>Cari Kos</span>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </a>

                    {{-- Mobile Hamburger Toggle (only on mobile d-lg-none) --}}
                    <button type="button" class="notion-mobile-toggle card-nav-toggle d-lg-none" id="notionMobileToggle" aria-label="Buka navigasi menu" aria-expanded="false" title="Menu Navigasi">
                        <span class="card-nav-toggle-icon" id="cardNavToggleIcon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="4" y1="7" x2="20" y2="7"></line>
                                <line x1="4" y1="12" x2="20" y2="12"></line>
                                <line x1="4" y1="17" x2="20" y2="17"></line>
                            </svg>
                        </span>
                    </button>
                @else
                    @if(Auth::user()->role === 'owner')
                        <a href="{{ route('owner.dashboard') }}" class="notion-btn-primary card-nav-cta-btn">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px;">
                                <rect x="3" y="3" width="7" height="9"></rect>
                                <rect x="14" y="3" width="7" height="5"></rect>
                                <rect x="14" y="12" width="7" height="9"></rect>
                                <rect x="3" y="16" width="7" height="5"></rect>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                        <form action="{{ route('owner.logout') }}" method="POST" class="d-inline m-0 p-0">
                            @csrf
                            <button type="submit" class="notion-btn-ghost text-danger" title="Keluar" style="padding: 7px 10px;">
                                <i class="fa fa-sign-out-alt"></i>
                            </button>
                        </form>
                    @else
                        {{-- Member Profile Dropdown --}}
                        <div class="member-profile-dropdown dropdown">
                            <a href="javascript:void(0)" class="member-avatar-btn d-inline-flex align-items-center justify-content-center" id="memberProfileToggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Profil Akun">
                                <span class="member-avatar-circle">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ \Illuminate\Support\Str::startsWith(Auth::user()->avatar, ['http://', 'https://']) ? Auth::user()->avatar : asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="member-avatar-img" id="navAvatarImg" referrerpolicy="no-referrer" crossorigin="anonymous" onerror="this.style.display='none'; document.getElementById('navAvatarFallbackSvg')?.classList.remove('d-none');">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#525252" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" id="navAvatarFallbackSvg" class="d-none">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    @else
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#525252" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" id="navAvatarSvg">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                    @endif
                                </span>
                                <span class="member-avatar-dot" aria-hidden="true"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right member-custom-dropdown member-profile-menu shadow" id="memberProfileMenu" aria-labelledby="memberProfileToggle">
                                <div class="px-3 py-2 border-bottom bg-light mb-1">
                                    <div class="font-weight-bold text-dark text-truncate" style="font-size: 13.5px;">{{ Auth::user()->name ?? 'Member TEMPATIN' }}</div>
                                    <div class="text-muted text-truncate" style="font-size: 11.5px;">{{ Auth::user()->email ?? '' }}</div>
                                </div>
                                <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('member.profile') }}">
                                    <i class="fa fa-user-edit mr-2 text-muted" style="width: 16px;"></i>
                                    <span>Edit Profil</span>
                                </a>
                                <a class="dropdown-item py-2 d-flex align-items-center" href="{{ route('member.invoice.index') }}">
                                    <i class="fa fa-file-invoice mr-2 text-muted" style="width: 16px;"></i>
                                    <span>Tagihan &amp; Invoice</span>
                                </a>
                                <div class="dropdown-divider my-1"></div>
                                <form action="{{ route('member.logout') }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 d-flex align-items-center text-danger border-0 bg-transparent w-100 text-left" style="cursor: pointer;">
                                        <i class="fa fa-sign-out-alt mr-2" style="width: 16px;"></i>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Mobile Toggle for Member --}}
                        <button type="button" class="notion-mobile-toggle card-nav-toggle d-lg-none ml-2" id="notionMobileToggle" aria-label="Buka navigasi menu" aria-expanded="false" title="Menu Navigasi">
                            <span class="card-nav-toggle-icon" id="cardNavToggleIcon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="4" y1="7" x2="20" y2="7"></line>
                                    <line x1="4" y1="12" x2="20" y2="12"></line>
                                    <line x1="4" y1="17" x2="20" y2="17"></line>
                                </svg>
                            </span>
                        </button>
                    @endif
                @endguest
            </div>

        </nav>
    </div>

    <!-- Mobile Slide Drawer (only on < 992px) -->
    <div class="notion-mobile-drawer" id="notionMobileDrawer" aria-hidden="true">
        <div class="notion-mobile-drawer-content">
            @if(Auth::check() && Auth::user()->role !== 'owner')
                <div class="notion-mobile-nav-group">
                    <div class="notion-mobile-group-title">Menu Utama</div>
                    <a href="{{ $kosUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-search mr-2 text-muted" style="width: 18px;"></i> Cari Kos
                    </a>
                    <a href="{{ route('member.favorit') }}" class="notion-mobile-nav-link">
                        <i class="fa fa-heart mr-2 text-muted" style="width: 18px;"></i> Favorit Saya
                    </a>
                    <a href="{{ route('member.pesan') }}" class="notion-mobile-nav-link">
                        <i class="fa fa-comment-dots mr-2 text-muted" style="width: 18px;"></i> Chat &amp; Pesan
                    </a>
                    <a href="{{ route('member.notifikasi') }}" class="notion-mobile-nav-link">
                        <i class="fa fa-bell mr-2 text-muted" style="width: 18px;"></i> Notifikasi
                    </a>
                </div>
                <div class="notion-mobile-nav-group">
                    <div class="notion-mobile-group-title">Eksplorasi &amp; Info</div>
                    <a href="{{ $promoUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-tag mr-2 text-muted" style="width: 18px;"></i> Voucher &amp; Promo
                    </a>
                    <a href="{{ $artikelUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-newspaper mr-2 text-muted" style="width: 18px;"></i> Artikel &amp; Tips
                    </a>
                    <a href="{{ $aboutUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-info-circle mr-2 text-muted" style="width: 18px;"></i> Tentang TEMPATIN
                    </a>
                    <a href="{{ $contactUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-life-ring mr-2 text-muted" style="width: 18px;"></i> Pusat Bantuan
                    </a>
                </div>
            @elseif(Auth::check() && Auth::user()->role === 'owner')
                <div class="notion-mobile-nav-group">
                    <div class="notion-mobile-group-title">Menu Pemilik Kos</div>
                    <a href="{{ route('owner.dashboard') }}" class="notion-mobile-nav-link">
                        <i class="fa fa-tachometer-alt mr-2 text-muted" style="width: 18px;"></i> Dashboard Owner
                    </a>
                    <a href="{{ route('owner.kos.index') }}" class="notion-mobile-nav-link">
                        <i class="fa fa-home mr-2 text-muted" style="width: 18px;"></i> Kelola Kos
                    </a>
                    <a href="{{ route('owner.statistik') }}" class="notion-mobile-nav-link">
                        <i class="fa fa-chart-line mr-2 text-muted" style="width: 18px;"></i> Statistik
                    </a>
                    <a href="{{ $aboutUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-info-circle mr-2 text-muted" style="width: 18px;"></i> Tentang Platform
                    </a>
                </div>
            @else
                <div class="notion-mobile-nav-group">
                    <div class="notion-mobile-group-title">Navigasi</div>
                    <a href="{{ $homeUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-home mr-2 text-muted" style="width: 18px;"></i> Beranda
                    </a>
                    <a href="{{ $kosUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-search mr-2 text-muted" style="width: 18px;"></i> Cari Kos
                    </a>
                    <a href="{{ $promoUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-tag mr-2 text-muted" style="width: 18px;"></i> Promo &amp; Voucher
                    </a>
                    <a href="{{ $artikelUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-newspaper mr-2 text-muted" style="width: 18px;"></i> Artikel &amp; Tips
                    </a>
                    <a href="{{ $aboutUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-info-circle mr-2 text-muted" style="width: 18px;"></i> Tentang Kami
                    </a>
                    <a href="{{ $contactUrl }}" class="notion-mobile-nav-link">
                        <i class="fa fa-life-ring mr-2 text-muted" style="width: 18px;"></i> Pusat Bantuan
                    </a>
                </div>
                <div class="notion-mobile-drawer-actions pt-3 border-top mt-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-dark btn-block mb-2 font-weight-medium" data-toggle="modal" data-target="#authRoleModal" data-auth-mode="login" style="border-radius: 8px; font-size: 14px; padding: 9px;">
                        Masuk ke Akun
                    </a>
                    <a href="{{ $kosUrl }}" class="btn btn-primary btn-block font-weight-medium" style="background-color: var(--color-notion-blue, #0075de); border-color: var(--color-notion-blue, #0075de); border-radius: 8px; font-size: 14px; padding: 9px;">
                        Cari Kos Sekarang
                    </a>
                </div>
            @endif
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Mobile Drawer Toggle
    const mobileToggle = document.getElementById('notionMobileToggle');
    const mobileDrawer = document.getElementById('notionMobileDrawer');
    const toggleIcon = document.getElementById('cardNavToggleIcon');

    function updateMobileIcon(isOpen) {
        if (!toggleIcon) return;
        if (isOpen) {
            toggleIcon.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
        } else {
            toggleIcon.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="7" x2="20" y2="7"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="17" x2="20" y2="17"></line></svg>';
        }
    }

    if (mobileToggle && mobileDrawer) {
        mobileToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = mobileDrawer.classList.contains('show');
            if (isOpen) {
                mobileDrawer.classList.remove('show');
                mobileToggle.setAttribute('aria-expanded', 'false');
                updateMobileIcon(false);
            } else {
                mobileDrawer.classList.add('show');
                mobileToggle.setAttribute('aria-expanded', 'true');
                updateMobileIcon(true);
            }
        });

        // Close mobile drawer on outside click
        document.addEventListener('click', function (e) {
            if (mobileDrawer.classList.contains('show') && !mobileDrawer.contains(e.target) && !mobileToggle.contains(e.target)) {
                mobileDrawer.classList.remove('show');
                mobileToggle.setAttribute('aria-expanded', 'false');
                updateMobileIcon(false);
            }
        });
    }

    // 2. Member Custom Dropdowns (Notifikasi, Lainnya, & Profil)
    const profileToggle = document.getElementById('memberProfileToggle');
    const profileMenu = document.getElementById('memberProfileMenu');
    const lainnyaToggle = document.getElementById('memberNavLainnyaToggle');
    const lainnyaMenu = document.getElementById('memberNavLainnyaMenu');
    const notificationToggle = document.getElementById('memberNotificationToggle');
    const notificationPopover = document.getElementById('memberNotificationPopover');
    const closeNotificationBtn = document.getElementById('btnCloseNotification');

    function closeAllMemberDropdowns() {
        if (profileMenu) {
            profileMenu.classList.remove('show');
            if (profileToggle) profileToggle.setAttribute('aria-expanded', 'false');
            if (profileToggle && profileToggle.parentElement) profileToggle.parentElement.classList.remove('show');
        }
        if (lainnyaMenu) {
            lainnyaMenu.classList.remove('show');
            if (lainnyaToggle) lainnyaToggle.setAttribute('aria-expanded', 'false');
            if (lainnyaToggle && lainnyaToggle.parentElement) lainnyaToggle.parentElement.classList.remove('show');
        }
        if (notificationPopover) {
            notificationPopover.classList.remove('show');
            if (notificationToggle) notificationToggle.setAttribute('aria-expanded', 'false');
            if (notificationToggle && notificationToggle.parentElement) notificationToggle.parentElement.classList.remove('show');
        }
    }

    if (profileToggle && profileMenu) {
        profileToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = profileMenu.classList.contains('show');
            closeAllMemberDropdowns();
            if (!isOpen) {
                profileMenu.classList.add('show');
                profileToggle.setAttribute('aria-expanded', 'true');
                if (profileToggle.parentElement) profileToggle.parentElement.classList.add('show');
            }
        });
    }

    if (lainnyaToggle && lainnyaMenu) {
        lainnyaToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = lainnyaMenu.classList.contains('show');
            closeAllMemberDropdowns();
            if (!isOpen) {
                lainnyaMenu.classList.add('show');
                lainnyaToggle.setAttribute('aria-expanded', 'true');
                if (lainnyaToggle.parentElement) lainnyaToggle.parentElement.classList.add('show');
            }
        });
    }

    if (notificationToggle && notificationPopover) {
        notificationToggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = notificationPopover.classList.contains('show');
            closeAllMemberDropdowns();
            if (!isOpen) {
                notificationPopover.classList.add('show');
                notificationToggle.setAttribute('aria-expanded', 'true');
                if (notificationToggle.parentElement) notificationToggle.parentElement.classList.add('show');
            }
        });
    }

    if (closeNotificationBtn) {
        closeNotificationBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            closeAllMemberDropdowns();
        });
    }

    document.addEventListener('click', function (e) {
        if (!e.target.closest('.member-profile-dropdown') && !e.target.closest('.member-nav-dropdown') && !e.target.closest('.notification-dropdown')) {
            closeAllMemberDropdowns();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAllMemberDropdowns();
            if (mobileDrawer && mobileDrawer.classList.contains('show')) {
                mobileDrawer.classList.remove('show');
                if (mobileToggle) mobileToggle.setAttribute('aria-expanded', 'false');
                updateMobileIcon(false);
            }
        }
    });

    // 3. Header Shrink on Scroll (Notion sticky top bar)
    const headerEl = document.getElementById('ts-header');
    if (headerEl) {
        function checkScrollHeader() {
            if (window.scrollY >= 100) {
                headerEl.classList.add('is-shrunk');
            } else {
                headerEl.classList.remove('is-shrunk');
            }
        }
        window.addEventListener('scroll', checkScrollHeader, { passive: true });
        checkScrollHeader();
    }
});
</script>

@guest
    @include('partials.auth-role-modal')
@endguest
