{{-- Notion Workspace Sidebar: Area Pemilik Kos (Owner) --}}
<div class="p-3 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

    <!-- Owner Mini Profile -->
    <div class="d-flex align-items-center p-2 mb-3 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-3" style="width: 40px; height: 40px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 700; font-size: 14px;">
            <i class="fa fa-user-tie"></i>
        </div>
        <div class="overflow-hidden">
            <div style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink); white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                {{ Auth::user()->name ?? 'Pemilik Properti' }}
            </div>
            <div style="font-size: 11px; color: var(--color-stone);">Mitra Pemilik Kos</div>
        </div>
    </div>

    <!-- Navigation Header -->
    <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.06em; color: var(--color-stone); padding: 6px 10px; margin-bottom: 4px;">
        WORKSPACE PEMILIK
    </div>

    <!-- Nav Links -->
    <div class="d-flex flex-column gap-1">
        <a href="{{ route('owner.dashboard') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('owner.dashboard') ? 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-tachometer-alt mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('owner.dashboard') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Dashboard Ringkasan
        </a>

        <a href="{{ route('owner.kos.index') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ (request()->routeIs('owner.kos.index') || request()->routeIs('owner.kos.my') || request()->routeIs('owner.kos.manage')) ? 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-building mr-2" style="width: 18px; text-align: center; color: {{ (request()->routeIs('owner.kos.index') || request()->routeIs('owner.kos.my') || request()->routeIs('owner.kos.manage')) ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Kos Saya
        </a>

        <a href="{{ route('owner.kos.create') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('owner.kos.create') ? 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-plus-circle mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('owner.kos.create') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Tambah Kos Baru
        </a>

        <a href="{{ route('owner.kos.penilaian') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('owner.kos.penilaian') ? 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-star mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('owner.kos.penilaian') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Penilaian & Ulasan
        </a>

        <a href="{{ route('owner.statistik') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('owner.statistik') ? 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-chart-line mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('owner.statistik') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Laporan & Statistik
        </a>

        <a href="{{ route('owner.notifikasi') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('owner.notifikasi') ? 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-bell mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('owner.notifikasi') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Notifikasi Properti
        </a>

        <div class="my-2 border-top" style="border-color: rgba(0,0,0,0.06) !important;"></div>

        <a href="{{ route('home') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13px; color: var(--color-stone); transition: all 0.15s ease;">
            <i class="fa fa-home mr-2" style="width: 18px; text-align: center;"></i> Beranda Publik
        </a>
    </div>

</div>
