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
                        ['label' => 'Tagihan / Invoice', 'href' => route('member.invoice.index'), 'ariaLabel' => 'Lihat tagihan dan invoice'],
                        ['label' => 'Profil Saya', 'href' => route('member.profile'), 'ariaLabel' => 'Pengaturan profil saya'],
                        ['label' => 'Pusat Bantuan', 'href' => $contactUrl, 'ariaLabel' => 'Pusat bantuan member'],
                      ]
                  )
                : [
                    ['label' => 'Masuk ke Akun', 'href' => route('login'), 'ariaLabel' => 'Masuk ke akun'],
                    ['label' => 'Daftar Akun Baru', 'href' => route('register'), 'ariaLabel' => 'Daftar akun pencari kos'],
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
                    <!-- Toggle Menu Button -->
                    <button type="button" class="card-nav-toggle" id="cardNavToggle" aria-label="Buka navigasi menu" aria-expanded="false" title="Menu Navigasi">
                        <span class="card-nav-toggle-icon" id="cardNavToggleIcon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="4" y1="7" x2="20" y2="7"></line>
                                <line x1="4" y1="12" x2="20" y2="12"></line>
                                <line x1="4" y1="17" x2="20" y2="17"></line>
                            </svg>
                        </span>
                    </button>

                    <!-- Right Action CTA -->
                    <div class="card-nav-actions">
                        @guest
                            <a href="{{ route('login') }}" class="card-nav-cta-secondary d-none d-sm-inline-flex">
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
                            @if(Auth::user()->role === 'owner')
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
                            @else
                                <a href="{{ route('member.home') }}" class="card-nav-cta-btn">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 22px; height: 22px; background: rgba(255,255,255,0.25); font-size: 11px; font-weight: 700; margin-right: 6px;">
                                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                                    </span>
                                    <span class="d-none d-sm-inline">{{ Str::limit(Auth::user()->name, 12) }}</span>
                                    <span class="d-sm-none">Member</span>
                                </a>
                            @endif
                        @endguest
                    </div>
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
                                <a href="{{ $link['href'] }}" class="nav-card-link" aria-label="{{ $link['ariaLabel'] }}">
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

    gsap.set(navEl, { height: getCollapsedHeight(), overflow: 'hidden' });
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

        const closeTl = gsap.timeline({
            onComplete: function () {
                isExpanded = false;
                navEl.classList.remove('open');
                if (headerWrapper) headerWrapper.classList.remove('open');

                contentEl.style.visibility = 'hidden';
                contentEl.style.pointerEvents = 'none';
                contentEl.setAttribute('aria-hidden', 'true');

                gsap.set(cards, { y: 24, opacity: 0 });
                gsap.set(navEl, { height: getCollapsedHeight() });
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
        if (!tl) return;
        if (isExpanded) {
            const newHeight = calculateHeight();
            gsap.to(navEl, { height: newHeight, duration: 0.3, ease: 'power3.out' });
        } else {
            createTimeline();
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
