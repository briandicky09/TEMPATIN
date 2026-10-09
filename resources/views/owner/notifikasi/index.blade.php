@extends('layouts.owner')

@section('title', 'Notifikasi Properti - TEMPATIN')

@section('owner-content')
<div class="container">
    <div class="row">

        <!-- OWNER SIDEBAR -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            @include('partials.owner-sidebar')
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-lg-9">

            <!-- HEADER -->
            <div class="mb-4">
                <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 600;">
                    <i class="fa fa-bell mr-1"></i> AKTIVITAS PROPERTI
                </div>
                <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                    Notifikasi Properti
                </h1>
                <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                    Pemberitahuan masuk seputar pesanan sewa baru, pelunasan invoice, dan pertanyaan calon penghuni.
                </p>
            </div>

            <!-- NOTIFICATIONS LIST -->
            <div class="rounded overflow-hidden" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                @if(isset($notifications) && count($notifications) > 0)
                    <div class="d-flex flex-column">
                        @foreach($notifications as $notif)
                            <div class="p-4 d-flex align-items-start border-bottom position-relative" style="border-color: rgba(0,0,0,0.06) !important; background-color: {{ !$notif['is_read'] ? 'rgba(0, 117, 222, 0.02)' : '#ffffff' }}; transition: background 0.15s ease;">
                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-3 flex-shrink-0" style="width: 40px; height: 40px; background-color: var(--surface-page-canvas); color: var(--color-notion-blue); font-size: 16px;">
                                    <i class="fa {{ $notif['icon'] }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h3 style="font-size: 14.5px; font-weight: {{ !$notif['is_read'] ? '700' : '600' }}; color: var(--color-midnight-ink); margin-bottom: 0;">
                                            {{ $notif['title'] }}
                                        </h3>
                                        <span style="font-size: 12px; color: var(--color-stone);">{{ $notif['time'] }}</span>
                                    </div>
                                    <p style="font-size: 13.5px; color: {{ !$notif['is_read'] ? 'var(--color-charcoal)' : 'var(--color-stone)' }}; line-height: 1.5; margin-bottom: 0;">
                                        {{ $notif['message'] }}
                                    </p>
                                </div>
                                @if(!$notif['is_read'])
                                    <span class="rounded-circle ml-2" style="width: 8px; height: 8px; background-color: var(--color-notion-blue); flex-shrink: 0; margin-top: 6px;"></span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-5 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px; border-radius: 50%; background-color: var(--surface-page-canvas); color: var(--color-stone); font-size: 24px;">
                            <i class="fa fa-envelope-open"></i>
                        </div>
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                            Belum Ada Notifikasi Baru
                        </h3>
                        <p style="font-size: 13.5px; color: var(--color-stone); max-width: 440px; margin: 0 auto;">
                            Setiap ada booking atau pembayaran baru untuk kos Anda, notifikasi akan langsung muncul di sini.
                        </p>
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
