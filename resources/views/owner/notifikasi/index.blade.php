@extends('layouts.owner')

@section('title', 'Notifikasi Owner - TEMPATIN')

@push('styles')
<style>
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
</style>
@endpush

@section('owner-content')
<main id="ts-main">
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="mb-1">Notifikasi</h2>
                    <p class="text-muted mb-0">Pusat pemberitahuan aktivitas kos Anda.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 8px; overflow: hidden;">
                <div class="card-header bg-white border-bottom p-4">
                    <ul class="nav nav-pills nav-pills-custom" id="notificationTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active d-flex align-items-center" id="utama-tab" data-toggle="pill" href="#utama" role="tab" aria-controls="utama" aria-selected="true">
                                <i class="fa fa-info-circle mr-2"></i> Utama
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body p-0">
                    <div class="tab-content" id="notificationTabContent">
                        <div class="tab-pane fade show active" id="utama" role="tabpanel" aria-labelledby="utama-tab">
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
                                <div class="text-center py-5">
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
    </section>
</main>
@endsection
