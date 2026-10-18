<div class="p-3 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

    <!-- Admin Profile Badge -->
    <div class="d-flex align-items-center p-2 mb-3 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-3" style="width: 38px; height: 38px; background-color: #fee2e2; color: #991b1b; font-weight: 700; font-size: 14px;">
            <i class="fa fa-shield-alt"></i>
        </div>
        <div class="overflow-hidden">
            <div style="font-size: 13.5px; font-weight: 700; color: var(--color-midnight-ink); white-space: nowrap; text-overflow: ellipsis; overflow: hidden;">
                {{ Auth::user()->name ?? 'Administrator' }}
            </div>
            <div style="font-size: 11px; color: var(--color-stone);">Superadmin Sistem</div>
        </div>
    </div>

    <!-- Navigation Label -->
    <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.06em; color: var(--color-stone); padding: 6px 10px; margin-bottom: 4px;">
        KONTROL PLATFORM
    </div>

    <!-- Links -->
    <div class="d-flex flex-column gap-1">
        <a href="{{ route('admin.dashboard') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('admin.dashboard') ? 'background-color: var(--color-sky-tint); color: var(--color-ink-black); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-tachometer-alt mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('admin.dashboard') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Dashboard
        </a>

        <a href="{{ route('admin.kos.index') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('admin.kos.*') ? 'background-color: var(--color-sky-tint); color: var(--color-ink-black); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-building mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('admin.kos.*') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Moderasi Kos
        </a>

        <a href="{{ route('admin.users.index') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('admin.users.*') ? 'background-color: var(--color-sky-tint); color: var(--color-ink-black); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-users-cog mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('admin.users.*') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Pengguna Platform
        </a>

        <a href="{{ route('admin.bookings.index') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('admin.bookings.*') ? 'background-color: var(--color-sky-tint); color: var(--color-ink-black); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-receipt mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('admin.bookings.*') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Audit Transaksi
        </a>

        <a href="{{ route('admin.reviews.index') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13.5px; font-weight: 500; transition: all 0.15s ease; {{ request()->routeIs('admin.reviews.*') ? 'background-color: var(--color-sky-tint); color: var(--color-ink-black); font-weight: 600;' : 'color: var(--color-charcoal);' }}">
            <i class="fa fa-star mr-2" style="width: 18px; text-align: center; color: {{ request()->routeIs('admin.reviews.*') ? 'var(--color-notion-blue)' : 'var(--color-stone)' }};"></i> Moderasi Ulasan
        </a>

        <div class="my-2 border-top" style="border-color: rgba(0,0,0,0.06) !important;"></div>

        <a href="{{ route('home') }}"
           class="d-flex align-items-center px-3 py-2 rounded text-decoration-none"
           style="font-size: 13px; color: var(--color-stone); transition: all 0.15s ease;">
            <i class="fa fa-home mr-2" style="width: 18px; text-align: center;"></i> Beranda Publik
        </a>
    </div>

</div>
