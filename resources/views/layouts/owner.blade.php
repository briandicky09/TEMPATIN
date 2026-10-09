@extends('layouts.app')

@section('content')
<div class="ts-page-wrapper" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.owner-navbar')
    @include('partials.alert')

    <main style="padding-top: 84px; padding-bottom: 80px;">
        @yield('owner-content')
    </main>

    @include('partials.footer')

</div>
@endsection
