{{-- Header / CardNav TEMPATIN --}}
@php
    $isMemberArea = request()->is('member*');
    $homeUrl = $isMemberArea ? url('/member' . route('home', [], false)) : route('home');
    $kosUrl = $isMemberArea ? url('/member' . route('kos.index', [], false)) : route('kos.index');
    $promoUrl = $isMemberArea ? url('/member' . route('promo', [], false)) : route('promo');
    $artikelUrl = $isMemberArea ? url('/member' . route('artikel', [], false)) : route('artikel');
    $aboutUrl = $isMemberArea ? url('/member' . route('about', [], false)) : route('about');
    $contactUrl = $isMemberArea ? url('/member' . route('contact', [], false)) : route('contact');
    
    $navCards = [
        [
            'label' => 'Eksplorasi Kos',
            'bgColor' => '#111111',
            'textColor' => '#ffffff',
            'links' => [
                ['label' => 'Semua Pilihan Kos', 'href' => $kosUrl, 'ariaLabel' => 'Lihat semua pilihan kos'],
                ['label' => 'Kos Putra', 'href' => $kosUrl . '?gender=putra', 'ariaLabel' => 'Cari kos khusus putra'],
                ['label' => 'Kos Putri', 'href' => $kosUrl . '?gender=putri', 'ariaLabel' => 'Cari kos khusus putri'],
                ['label' => 'Kos Campur', 'href' => $kosUrl . '?gender=campur', 'ariaLabel' => 'Cari kos campur'],
            ]
        ],
        [
            'label' => 'Promo & Artikel',
            'bgColor' => '#172332',
            'textColor' => '#ffffff',
            'links' => [
                ['label' => 'Voucher & Promo', 'href' => $promoUrl, 'ariaLabel' => 'Lihat voucher dan promo sewa kos'],
                ['label' => 'Artikel & Tips Kos', 'href' => $artikelUrl, 'ariaLabel' => 'Panduan dan artikel seputar kos'],
                ['label' => 'Tentang TEMPATIN', 'href' => $aboutUrl, 'ariaLabel' => 'Tentang platform TEMPATIN'],
                ['label' => 'Pusat Bantuan Kontak', 'href' => $contactUrl, 'ariaLabel' => 'Hubungi kontak bantuan'],
            ]
        ],
        [
            'label' => 'Akun & Layanan',
            'bgColor' => '#0075de',
            'textColor' => '#ffffff',
            'links' => Auth::check() 
                ? (Auth::user()->role === 'owner' 
                    ? [
                        ['label' => 'Dashboard Owner', 'href' => route('owner.dashboard'), 'ariaLabel' => 'Buka dashboard owner'],
                        ['label' => 'Kelola Kos Saya', 'href' => route('owner.kos.index'), 'ariaLabel' => 'Kelola properti kos'],
                        ['label' => 'Tambah Kos Baru', 'href' => route('owner.kos.create'), 'ariaLabel' => 'Daftarkan properti kos baru'],
                        ['label' => 'Tentang Platform', 'href' => $aboutUrl, 'ariaLabel' => 'Tentang platform kami'],
                      ]
                    : [
                        ['label' => 'Area Member', 'href' => route('member.home'), 'ariaLabel' => 'Buka beranda member'],
                        ['label' => 'Kos Favorit', 'href' => route('member.favorit'), 'ariaLabel' => 'Lihat kos favorit tersimpan'],
                        ['label' => 'Pesan & Chat', 'href' => route('member.pesan'), 'ariaLabel' => 'Buka pesan dan chat'],
                        ['label' => 'Notifikasi Akun', 'href' => route('member.notifikasi'), 'ariaLabel' => 'Lihat notifikasi akun'],
                        ['label' => 'Tagihan / Invoice', 'href' => route('member.invoice.index'), 'ariaLabel' => 'Lihat tagihan dan invoice'],
                        ['label' => 'Profil Saya', 'href' => route('member.profile'), 'ariaLabel' => 'Pengaturan profil saya'],
                      ]
                  )
                : [
                    ['label' => 'Masuk ke Akun', 'href' => route('login'), 'ariaLabel' => 'Masuk ke akun', 'modalMode' => 'login'],
                    ['label' => 'Daftar Akun Baru', 'href' => route('register'), 'ariaLabel' => 'Daftar akun baru', 'modalMode' => 'register'],
                    ['label' => 'Gabung Mitra Owner', 'href' => route('owner.kos.create'), 'ariaLabel' => 'Daftarkan properti kos'],
                    ['label' => 'Pusat Kontak & FAQ', 'href' => $contactUrl, 'ariaLabel' => 'Kontak dan tanya jawab'],
                  ]
        ]
    ];
@endphp

<header id="ts-header" class="card-nav-wrapper fixed-top">
    <div class="card-nav-container">
        <nav class="card-nav" id="mainCardNav" aria-label="Navigasi Utama">
            
            <!-- Top Bar (Collapsed 60px) -->
            <div class="card-nav-top">
                <!-- Brand Logo (Left) -->
                <a href="{{ $homeUrl }}" class="card-nav-brand" aria-label="TEMPATIN Beranda">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="TEMPATIN" class="card-nav-logo-img">
                </a>

                <!-- Right Controls: Toggle Menu + Actions -->
                <div class="card-nav-right-group">
                    @if(Auth::check() && Auth::user()->role !== 'owner')
                        {{-- Member Navigation Items (Image 2 Reference) --}}
                        <div class="member-nav-items d-none d-md-flex align-items-center">
                            {{-- 1. Cari Kos (diubah dari Cari Apa?) --}}
                            <a href="{{ $kosUrl }}" class="member-nav-link {{ request()->routeIs('member.kos.*') || request()->routeIs('kos.*') ? 'active' : '' }}">
                                Cari Kos
                            </a>

                            {{-- 2. Favorit --}}
                            <a href="{{ route('member.favorit') }}" class="member-nav-link {{ request()->routeIs('member.favorit') ? 'active' : '' }}">
                                Favorit
                            </a>

                            {{-- 3. Chat --}}
                            <a href="{{ route('member.pesan') }}" class="member-nav-link {{ request()->routeIs('member.pesan') || request()->routeIs('member.chat') ? 'active' : '' }}">
                                Chat
                            </a>

                            {{-- 4. Notifikasi (Floating Popover - Reference Image 2) --}}
                            <div class="member-nav-dropdown dropdown notification-dropdown position-relative">
                                <a href="javascript:void(0)" class="member-nav-link d-inline-flex align-items-center" id="memberNotificationToggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>Notifikasi</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow notification-popover-card" id="memberNotificationPopover" aria-labelledby="memberNotificationToggle" style="width: 340px; max-width: 90vw; border-radius: 16px; border: 1px solid rgba(0,0,0,0.08); box-shadow: 0 16px 40px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.04) !important; padding: 0; margin-top: 10px; overflow: hidden; background: #ffffff;">
                                    <!-- Header -->
                                    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                                        <h5 class="mb-0 font-weight-bold text-dark" style="font-size: 16px; font-family: var(--font-notioninter);">
                                            Notifikasi
                                        </h5>
                                        <button type="button" class="close p-0 text-muted" id="btnCloseNotification" style="font-size: 20px; line-height: 1; opacity: 0.6;" aria-label="Tutup notifikasi">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Filter Pill -->
                                    <div class="px-4 pt-3 pb-2">
                                        <span class="d-inline-flex align-items-center px-3 py-1 rounded-pill" style="border: 1.5px solid #111827; font-size: 12px; font-weight: 600; color: #111827; background: #ffffff;">
                                            <i class="fa fa-info-circle mr-1" style="font-size: 11px;"></i> Utama
                                        </span>
                                    </div>

                                    <!-- Body: Empty State with Illustration -->
                                    <div class="px-4 py-4 text-center">
                                        <div class="mb-3 d-flex justify-content-center">
                                            <svg width="170" height="120" viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <ellipse cx="100" cy="85" rx="85" ry="50" fill="#f0fdf4"/>
                                                <circle cx="110" cy="25" r="2.5" fill="#22c55e" opacity="0.6"/>
                                                <circle cx="95" cy="28" r="1.5" fill="#22c55e" opacity="0.6"/>
                                                <circle cx="145" cy="35" r="2" fill="#22c55e" opacity="0.6"/>
                                                <rect x="35" y="70" width="8" height="35" rx="2" fill="#bbf7d0" opacity="0.7"/>
                                                <rect x="50" y="65" width="8" height="40" rx="2" fill="#bbf7d0" opacity="0.7"/>
                                                <rect x="65" y="70" width="8" height="35" rx="2" fill="#bbf7d0" opacity="0.7"/>
                                                <rect x="125" y="70" width="8" height="35" rx="2" fill="#bbf7d0" opacity="0.7"/>
                                                <rect x="140" y="65" width="8" height="40" rx="2" fill="#bbf7d0" opacity="0.7"/>
                                                <rect x="155" y="70" width="8" height="35" rx="2" fill="#bbf7d0" opacity="0.7"/>
                                                <rect x="30" y="80" width="140" height="4" rx="2" fill="#86efac" opacity="0.6"/>
                                                <rect x="114" y="75" width="12" height="45" rx="2" fill="#78350f"/>
                                                <path d="M100 65 L128 65 Q135 65 135 73 L135 88 Q135 94 128 94 L100 94 Q93 94 93 88 L93 73 Q93 65 100 65 Z" fill="#facc15" stroke="#ca8a04" stroke-width="1.5"/>
                                                <ellipse cx="98" cy="80" rx="9" ry="14" fill="#eab308"/>
                                                <rect x="118" y="55" width="3" height="15" fill="#64748b"/>
                                                <polygon points="121,55 133,59 121,63" fill="#facc15"/>
                                                <path d="M58 80 C58 68, 72 68, 72 80 L76 102 C76 104, 60 106, 56 102 Z" fill="#16a34a"/>
                                                <path d="M68 76 C76 74, 88 78, 104 82" stroke="#fed7aa" stroke-width="7" stroke-linecap="round"/>
                                                <circle cx="104" cy="82" r="3.5" fill="#fbcfe8"/>
                                                <circle cx="75" cy="55" r="14" fill="#fed7aa"/>
                                                <ellipse cx="71" cy="59" rx="2.5" ry="1.5" fill="#f87171" opacity="0.6"/>
                                                <ellipse cx="81" cy="59" rx="2.5" ry="1.5" fill="#f87171" opacity="0.6"/>
                                                <circle cx="72" cy="54" r="1.5" fill="#1e293b"/>
                                                <circle cx="80" cy="54" r="1.5" fill="#1e293b"/>
                                                <path d="M74 61 Q77 59 80 61" stroke="#475569" stroke-width="1" stroke-linecap="round" fill="none"/>
                                                <ellipse cx="75" cy="45" rx="14" ry="10" fill="#1e293b"/>
                                                <circle cx="63" cy="50" r="6" fill="#1e293b"/>
                                                <circle cx="87" cy="50" r="6" fill="#1e293b"/>
                                                <circle cx="67" cy="40" r="5" fill="#1e293b"/>
                                                <circle cx="83" cy="40" r="5" fill="#1e293b"/>
                                                <ellipse cx="100" cy="118" rx="65" ry="4" fill="#e2e8f0"/>
                                            </svg>
                                        </div>
                                        <h4 class="font-weight-bold mb-2 text-dark" style="font-size: 15px; font-family: var(--font-notioninter);">
                                            Belum ada notifikasi...
                                        </h4>
                                        <p class="text-muted mb-0 mx-auto" style="font-size: 12.5px; line-height: 1.55; max-width: 270px;">
                                            Belum ada notifikasi. Ketika ada notifikasi baru, akan muncul di halaman ini.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- 5. Lainnya Dropdown (Menu Tagihan & Invoice Dipindahkan ke Profil) --}}
                            <div class="member-nav-dropdown dropdown">
                                <a href="javascript:void(0)" class="member-nav-link dropdown-toggle d-inline-flex align-items-center" id="memberNavLainnyaToggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span>Lainnya</span>
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 4px;">
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

                        {{-- 6. Profile Avatar Icon (Avatar Foto / Kosong + Dot) + Dropdown (Edit Profil, Tagihan & Invoice, Keluar) --}}
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

                        {{-- Toggle Menu Button for Mobile Only --}}
                        <button type="button" class="card-nav-toggle d-md-none ml-1" id="cardNavToggle" aria-label="Buka navigasi menu" aria-expanded="false" title="Menu Navigasi">
                            <span class="card-nav-toggle-icon" id="cardNavToggleIcon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="4" y1="7" x2="20" y2="7"></line>
                                    <line x1="4" y1="12" x2="20" y2="12"></line>
                                    <line x1="4" y1="17" x2="20" y2="17"></line>
                                </svg>
                            </span>
                        </button>
                    @else
                        {{-- Non-member (Guest or Owner) Toggle Menu Button --}}
                        <button type="button" class="card-nav-toggle" id="cardNavToggle" aria-label="Buka navigasi menu" aria-expanded="false" title="Menu Navigasi">
                            <span class="card-nav-toggle-icon" id="cardNavToggleIcon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="4" y1="7" x2="20" y2="7"></line>
                                    <line x1="4" y1="12" x2="20" y2="12"></line>
                                    <line x1="4" y1="17" x2="20" y2="17"></line>
                                </svg>
                            </span>
                        </button>

                        <!-- Right Action CTA for Guest or Owner -->
                        <div class="card-nav-actions">
                            @guest
                                <a href="{{ route('login') }}" class="card-nav-cta-secondary d-none d-sm-inline-flex" data-toggle="modal" data-target="#authRoleModal" data-auth-mode="login">
                                    Masuk
                                </a>
                                <a href="{{ $kosUrl }}" class="card-nav-cta-btn">
                                    <span>Cari Kos</span>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left: 6px;">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('owner.dashboard') }}" class="card-nav-cta-btn">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
                                        <rect x="3" y="3" width="7" height="9"></rect>
                                        <rect x="14" y="3" width="7" height="5"></rect>
                                        <rect x="14" y="12" width="7" height="9"></rect>
                                        <rect x="3" y="16" width="7" height="5"></rect>
                                    </svg>
                                    <span class="d-none d-sm-inline">Dashboard Owner</span>
                                    <span class="d-sm-none">Dashboard</span>
                                </a>
                            @endguest
                        </div>
                    @endif
                </div>
            </div>

            <!-- Content / Reveal Cards (Expanded) -->
            <div class="card-nav-content" id="cardNavContent" aria-hidden="true">
                @foreach($navCards as $idx => $card)
                    <div class="nav-card" style="background-color: {{ $card['bgColor'] }}; color: {{ $card['textColor'] }};">
                        <div class="nav-card-label">
                            {{ $card['label'] }}
                        </div>
                        <div class="nav-card-links">
                            @foreach($card['links'] as $link)
                                <a href="{{ $link['href'] }}" class="nav-card-link" aria-label="{{ $link['ariaLabel'] }}" @if(!empty($link['modalMode'])) data-toggle="modal" data-target="#authRoleModal" data-auth-mode="{{ $link['modalMode'] }}" @endif>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                        <line x1="7" y1="17" x2="17" y2="7"></line>
                                        <polyline points="7 7 17 7 17 17"></polyline>
                                    </svg>
                                    <span>{{ $link['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </nav>
    </div>
</header>

{{-- GSAP CardNav Animation Engine --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const navEl = document.getElementById('mainCardNav');
    const toggleBtn = document.getElementById('cardNavToggle');
    const contentEl = document.getElementById('cardNavContent');
    if (!navEl || !toggleBtn || !contentEl || typeof gsap === 'undefined') return;

    const cards = navEl.querySelectorAll('.nav-card');
    let isExpanded = false;
    let isAnimating = false;
    const headerWrapper = document.getElementById('ts-header');

    function getCollapsedHeight() {
        const isShrunk = headerWrapper && headerWrapper.classList.contains('is-shrunk');
        return isShrunk ? 54 : 68;
    }

    function calculateHeight() {
        const isMobile = window.matchMedia('(max-width: 767.98px)').matches;
        if (isMobile) {
            const wasVis = contentEl.style.visibility;
            const wasPos = contentEl.style.position;
            const wasH = contentEl.style.height;

            contentEl.style.visibility = 'visible';
            contentEl.style.position = 'static';
            contentEl.style.height = 'auto';

            const topBar = getCollapsedHeight();
            const padding = 20;
            const contentHeight = contentEl.scrollHeight;

            contentEl.style.visibility = wasVis;
            contentEl.style.position = wasPos;
            contentEl.style.height = wasH;

            return topBar + contentHeight + padding;
        }
        return 290;
    }

    gsap.set(navEl, { height: getCollapsedHeight(), overflow: 'visible' });
    gsap.set(cards, { y: 24, opacity: 0 });

    function updateToggleIcon(open) {
        const iconSpan = toggleBtn.querySelector('.card-nav-toggle-icon');
        if (!iconSpan) return;
        if (open) {
            iconSpan.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
        } else {
            iconSpan.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="7" x2="20" y2="7"></line><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="17" x2="20" y2="17"></line></svg>';
        }
    }

    function openMenu() {
        if (isAnimating) return;
        isAnimating = true;
        isExpanded = true;

        toggleBtn.setAttribute('aria-expanded', 'true');
        updateToggleIcon(true);

        navEl.classList.add('open');
        if (headerWrapper) headerWrapper.classList.add('open');

        contentEl.style.visibility = 'visible';
        contentEl.style.pointerEvents = 'auto';
        contentEl.setAttribute('aria-hidden', 'false');

        const targetHeight = calculateHeight();

        gsap.killTweensOf([navEl, cards]);

        const openTl = gsap.timeline({
            onStart: function () {
                gsap.set(navEl, { overflow: 'hidden' });
            },
            onComplete: function () {
                isAnimating = false;
            }
        });

        openTl.to(navEl, {
            height: targetHeight,
            duration: 0.45,
            ease: 'power3.out'
        });

        openTl.fromTo(cards,
            { y: 25, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.35, ease: 'power3.out', stagger: 0.06 },
            '-=0.25'
        );
    }

    function closeMenu() {
        if (isAnimating) return;
        isAnimating = true;

        toggleBtn.setAttribute('aria-expanded', 'false');
        updateToggleIcon(false);

        const collapsedHeight = getCollapsedHeight();

        gsap.killTweensOf([navEl, cards]);
        gsap.set(navEl, { overflow: 'hidden' });

        const closeTl = gsap.timeline({
            onComplete: function () {
                isExpanded = false;
                navEl.classList.remove('open');
                if (headerWrapper) headerWrapper.classList.remove('open');

                contentEl.style.visibility = 'hidden';
                contentEl.style.pointerEvents = 'none';
                contentEl.setAttribute('aria-hidden', 'true');

                gsap.set(cards, { y: 24, opacity: 0 });
                gsap.set(navEl, { height: getCollapsedHeight(), overflow: 'visible' });
                isAnimating = false;
            }
        });

        closeTl.to(cards, {
            y: 16,
            opacity: 0,
            duration: 0.22,
            ease: 'power2.in',
            stagger: 0.03
        });

        closeTl.to(navEl, {
            height: collapsedHeight,
            duration: 0.38,
            ease: 'power2.inOut'
        }, '-=0.12');
    }

    function toggleMenu() {
        if (!isExpanded) {
            openMenu();
        } else {
            closeMenu();
        }
    }

    toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        toggleMenu();
    });

    // Close when clicking outside of nav
    document.addEventListener('click', function (e) {
        if (isExpanded && !navEl.contains(e.target)) {
            toggleMenu();
        }
    });

    // Close on escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && isExpanded) {
            toggleMenu();
        }
    });

    // Handle resize
    window.addEventListener('resize', function () {
        if (!isExpanded) return;
        const newHeight = calculateHeight();
        gsap.to(navEl, { height: newHeight, duration: 0.3, ease: 'power3.out' });
    });

    // Member Custom Dropdowns (Lainnya, Notifikasi & Profile Dropdown)
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
        }
    });

    // Shrinking Sticky Header Controller:
    // As soon as user scrolls >= 100px down, shrink header height by 20% and apply glassmorphism
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
