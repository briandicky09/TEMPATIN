{{-- Notion Workspace Sidebar: Area Penyewa (Customer) --}}
<div class="p-3 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

    <!-- User Mini Profile -->
    <div class="d-flex align-items-center p-2 mb-3 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-3" style="width: 40px; height: 40px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 700; font-size: 14px;">
            {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
        </div>
        <div class="overflow-hidden">
            <div style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink); white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                {{ Auth::user()->name ?? 'Penyewa' }}
            </div>
            <div style="font-size: 11px; color: var(--color-stone);">Akun Penyewa</div>
        </div>
    </div>

    <!-- Navigation Header -->
    <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.06em; color: var(--color-stone); padding: 6px 10px; margin-bottom: 4px;">
        WORKSPACE MENU
    </div>

    <!-- Nav Links -->
    <div class="d-flex flex-column gap-1">
        <a href="{{ route('customer.kos.index') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('customer.kos.index') ? 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-bed mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('customer.kos.index') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Kos Saya
        </a>

        <a href="{{ route('member.invoice.index') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('member.invoice.*') ? 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-file-invoice mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('member.invoice.*') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Tagihan / Invoice
        </a>

        <a href="{{ route('member.notifikasi') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('member.notifikasi') ? 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-bell mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('member.notifikasi') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Notifikasi
        </a>

        <a href="{{ route('member.profile') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('member.profile') ? 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-user-circle mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('member.profile') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Profil Saya
        </a>

        <a href="{{ route('search.kos') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('search.kos') ? 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-search mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('search.kos') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Cari Kos Lain
        </a>

        <div class="my-2 border-top" style="border-color: rgba(0,0,0,0.06) !important;"></div>

        <a href="{{ route('home') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13px; color: var(--color-stone); transition: all 0.15s ease;">
            <i class="fa fa-home mr-2" style="width: 18px; text-align: center;"></i> Beranda Publik
        </a>
    </div>

</div>
