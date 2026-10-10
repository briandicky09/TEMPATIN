@extends('layouts.app')

@section('title', 'Notifikasi - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 20px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('member.home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Notifikasi</li>
                </ol>
            </nav>
        </div>

        <section class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <!-- HEADER -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <div class="d-inline-flex align-items-center mb-1 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 600;">
                                <i class="fa fa-bell mr-1"></i> PUSAT INFORMASI
                            </div>
                            <h1 style="font-family: var(--font-serif); font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
                                Notifikasi
                            </h1>
                        </div>
                    </div>

                    <!-- NOTIFICATIONS LIST -->
                    <div class="rounded overflow-hidden" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                        @if(!empty($notifications) && count($notifications) > 0)
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
                                    Belum Ada Notifikasi
                                </h3>
                                <p style="font-size: 13.5px; color: var(--color-stone); max-width: 440px; margin: 0 auto;">
                                    Pemberitahuan seputar reservasi, tagihan jatuh tempo, dan pesan pemilik akan tampil di sini.
                                </p>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
