{{-- Navbar Khusus Area Owner - Notion Design System --}}
<header id="ts-header" class="fixed-top">
    <nav id="ts-primary-navigation" class="navbar navbar-expand-lg navbar-light">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Brand Logo -->
            <a class="navbar-brand d-inline-flex align-items-center" href="{{ route('owner.dashboard') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="TEMPATIN" style="height: 28px; width: auto; object-fit: contain;">
                <span class="badge ml-2 font-weight-bold" style="font-size: 11px; background-color: var(--color-sky-tint); color: var(--color-ink-black); border: 1px solid rgba(0, 117, 222, 0.2);">Owner</span>
            </a>

            <!-- Right-aligned Actions (Public Switch, Notifications, Profile) -->
            <div class="d-flex align-items-center ml-auto" style="gap: 10px;">
                <!-- Public Switch Button -->
                <a href="{{ route('home') }}" class="btn btn-ghost btn-sm d-none d-sm-inline-flex align-items-center">
                    <i class="fa fa-globe mr-1"></i> Halaman Publik
                </a>

                <!-- Notification -->
                <div class="dropdown">
                    <a class="nav-link p-2" href="#" id="ownerNotificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell text-muted"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ownerNotificationDropdown" style="width: 300px;">
                        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 font-weight-bold">Notifikasi Owner</h6>
                            <span class="badge badge-light border">0 Baru</span>
                        </div>
                        <div class="p-4 text-center text-muted small">
                            <i class="fa fa-inbox fa-2x mb-2 text-muted opacity-50"></i>
                            <p class="mb-0">Belum ada notifikasi baru saat ini.</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center p-1" href="#" id="ownerUserDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="notion-character-mark mr-2" style="width: 32px; height: 32px; font-size: 13px; color: var(--color-notion-blue); border-color: var(--color-notion-blue);"><i class="fa fa-user"></i></span>
                        <span class="d-none d-md-inline font-weight-bold text-dark small">{{ Auth::user()->name ?? 'Pemilik' }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ownerUserDropdown">
                        <a class="dropdown-item" href="{{ route('owner.dashboard') }}"><i class="fa fa-user mr-2 text-muted"></i> Profil Pemilik</a>
                        <a class="dropdown-item" href="{{ route('owner.kos.my') }}"><i class="fa fa-home mr-2 text-muted"></i> Kelola Properti</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('owner.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-dark">
                                <i class="fa fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
