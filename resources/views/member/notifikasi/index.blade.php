@extends('layouts.app')

@section('title', 'Notifikasi - TEMPATIN')

@push('styles')
<style>
    .pk-notification-card {
        background: #fff;
        border: 0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    .pk-notification-header {
        padding: 20px 30px;
        border-bottom: 1px solid #e9ecef;
    }
    .pk-notification-header h3 {
        margin: 0;
        font-size: 22px;
    }
    .nav-pills-custom .nav-link {
        color: #495057;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 50rem;
        padding: 8px 20px;
        font-weight: 600;
        margin-right: 10px;
    }
    .nav-pills-custom .nav-link.active {
        color: #000;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    .notification-item {
        transition: all 0.2s;
    }
    .notification-item:hover {
        background-color: #f8f9fa;
    }
    .notification-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e9ecef;
    }
    .empty-state {
        padding: 60px 20px;
    }
</style>
@endpush

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main">
        <section id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('member.home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Notifikasi</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section id="page-title">
            <div class="container">
                <div class="ts-title mb-0">
                    <h1>Notifikasi</h1>
                    <h5 class="ts-opacity__90">
                        <i class="fa fa-bell text-primary mr-2"></i>
                        Pusat informasi dan pembaruan Anda
                    </h5>
                </div>
            </div>
        </section>

        <section id="content" class="pb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="pk-notification-card">
                            <div class="pk-notification-header">
                                <ul class="nav nav-pills nav-pills-custom" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active d-flex align-items-center" id="pills-utama-tab" data-toggle="pill" href="#pills-utama" role="tab" aria-controls="pills-utama" aria-selected="true">
                                            <i class="fa fa-info-circle mr-2"></i> Utama
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body p-0">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-utama" role="tabpanel" aria-labelledby="pills-utama-tab">
                                        @if(count($notifications) > 0)
                                            <div class="list-group list-group-flush">
                                                @foreach($notifications as $notif)
                                                    <a href="#" class="list-group-item list-group-item-action notification-item border-0 border-bottom py-4 {{ !$notif['is_read'] ? 'bg-light' : '' }}">
                                                        <div class="d-flex align-items-start px-3">
                                                            <div class="notification-icon-wrapper mr-3 flex-shrink-0">
                                                                <i class="fa {{ $notif['icon'] }} fa-lg"></i>
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                                                    <h6 class="mb-0 font-weight-bold {{ !$notif['is_read'] ? 'text-dark' : 'text-secondary' }}">{{ $notif['title'] }}</h6>
                                                                    <small class="text-muted">{{ $notif['time'] }}</small>
                                                                </div>
                                                                <p class="mb-0 {{ !$notif['is_read'] ? 'text-dark' : 'text-muted' }}">{{ $notif['message'] }}</p>
                                                            </div>
                                                            @if(!$notif['is_read'])
                                                                <div class="ml-3 mt-2">
                                                                    <span class="badge badge-primary badge-pill p-1"> </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-center empty-state">
                                                <i class="fa fa-envelope-open-text fa-5x text-light mb-4" style="color: #dee2e6 !important;"></i>
                                                <h4 class="font-weight-bold text-dark mt-3">Belum ada notifikasi...</h4>
                                                <p class="text-muted mb-0">Belum ada notifikasi. Ketika ada notifikasi baru, akan muncul di halaman ini.</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')

</div>
@endsection
