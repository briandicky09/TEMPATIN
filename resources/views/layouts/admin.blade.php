<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Admin Platform - TEMPATIN')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:ital,opsz,wght@0,8..60,600;0,8..60,700;1,8..60,600&display=swap">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tempatin.css') }}">
    @stack('styles')
</head>
<body style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); min-height: 100vh;">

    <!-- TOP ADMIN NAVBAR -->
    <header class="border-bottom sticky-top" style="background-color: #ffffff; border-color: rgba(0,0,0,0.08) !important; z-index: 1020;">
        <div class="container-fluid px-4 py-2 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('admin.dashboard') }}" class="d-inline-flex align-items-center text-decoration-none">
                    <span style="font-family: var(--font-serif); font-size: 20px; font-weight: 700; color: var(--color-midnight-ink); letter-spacing: -0.02em;">
                        TEMPATIN
                    </span>
                    <span class="badge ml-2 px-2 py-1 font-weight-bold" style="background-color: #fee2e2; color: #991b1b; font-size: 10.5px; border-radius: 4px; letter-spacing: 0.05em;">
                        ADMIN PLATFORM
                    </span>
                </a>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small d-none d-sm-inline">
                    Login sebagai: <strong>{{ Auth::user()->name ?? 'Superadmin' }}</strong>
                </span>
                <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger font-weight-600" style="border-radius: 6px; font-size: 12px;">
                        <i class="fa fa-sign-out-alt mr-1"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    @include('partials.alert')

    <div class="container-fluid px-4 py-4">
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-lg-3 col-xl-2 mb-4 mb-lg-0">
                @include('partials.admin-sidebar')
            </div>

            <!-- CONTENT -->
            <div class="col-lg-9 col-xl-10">
                @yield('admin-content')
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
