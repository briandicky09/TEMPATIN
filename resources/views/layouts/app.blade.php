<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="TEMPATIN">
    <meta name="description" content="TEMPATIN - Temukan Kos Impianmu dengan Mudah. Cari kos putra, putri, campur, eksklusif, bulanan dan harian di seluruh kota di Indonesia.">

    <!-- Google Fonts (Inter & Source Serif 4 for Notion Design System) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,600;1,8..60,400&display=swap" rel="stylesheet">

    <!--CSS -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tempatin.css') }}">
    @stack('styles')

    <title>@yield('title', 'TEMPATIN - Temukan Kos Impianmu dengan Mudah')</title>

</head>

<body>

<!-- WRAPPER
=====================================================================================================================-->
@yield('content')
<!--end .ts-page-wrapper-->

<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
@stack('scripts')

</body>
</html>
