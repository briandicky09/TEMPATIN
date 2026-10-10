@extends('layouts.app')

@section('content')
<div class="ts-page-wrapper" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main style="padding-top: 20px; padding-bottom: 80px;">
        <div class="container">
            <div class="row">
                <!-- Sidebar Customer -->
                <div class="col-lg-3 mb-4 mb-lg-0">
                    @include('partials.customer-sidebar')
                </div>

                <!-- Content Area -->
                <div class="col-lg-9">
                    @yield('customer-content')
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')

</div>
@endsection
