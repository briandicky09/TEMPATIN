@extends('layouts.app')

@section('title', 'Pesan & Percakapan - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 20px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ Auth::user()->role === 'owner' ? route('owner.dashboard') : route('member.home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Pesan</li>
                </ol>
            </nav>
        </div>

        <section class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <!-- HEADER -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <div class="d-inline-flex align-items-center mb-1 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-ink-black); font-size: 11px; font-weight: 600;">
                                <i class="fa fa-comment-dots mr-1"></i> KOMUNIKASI LANGSUNG
                            </div>
                            <h1 style="font-family: var(--font-serif); font-size: 1.75rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
                                Kotak Pesan
                            </h1>
                        </div>
                    </div>

                    <!-- CONVERSATIONS LIST -->
                    <div class="rounded overflow-hidden" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                        @if($conversations->isNotEmpty())
                            <div class="d-flex flex-column">
                                @foreach($conversations as $conv)
                                    @php
                                        $otherUser = Auth::user()->role === 'owner' ? $conv->customer : $conv->owner;
                                        $lastMsg = $conv->lastMessage();
                                        $unreadCount = $conv->unreadCountFor(Auth::id());
                                    @endphp
                                    <a href="{{ route('chat.show', $conv->id) }}" class="p-3 d-flex align-items-start border-bottom text-decoration-none" style="border-color: rgba(0,0,0,0.06) !important; background-color: {{ $unreadCount > 0 ? 'rgba(0, 117, 222, 0.03)' : '#ffffff' }}; transition: background 0.15s ease;">
                                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-3 flex-shrink-0" style="width: 44px; height: 44px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 700; font-size: 16px;">
                                            {{ strtoupper(substr($otherUser?->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <div class="d-flex align-items-center">
                                                    <span style="font-size: 14.5px; font-weight: {{ $unreadCount > 0 ? '700' : '600' }}; color: var(--color-midnight-ink);">
                                                        {{ $otherUser?->name ?? 'Pengguna' }}
                                                    </span>
                                                    <span class="badge ml-2" style="background-color: var(--surface-page-canvas); color: var(--color-stone); font-size: 11px; font-weight: 500; border: var(--border-hairline);">
                                                        {{ $conv->kos?->title ?? 'Kos' }}
                                                    </span>
                                                </div>
                                                <span style="font-size: 11.5px; color: var(--color-stone);">
                                                    {{ $lastMsg ? $lastMsg->created_at->diffForHumans() : $conv->updated_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="text-truncate mb-0" style="font-size: 13px; color: {{ $unreadCount > 0 ? 'var(--color-midnight-ink)' : 'var(--color-stone)' }}; max-width: 480px;">
                                                    {{ $lastMsg ? $lastMsg->message : 'Belum ada pesan terkirim.' }}
                                                </p>
                                                @if($unreadCount > 0)
                                                    <span class="badge rounded-pill ml-2" style="background-color: var(--color-notion-blue); color: #ffffff; font-size: 10.5px; padding: 3px 7px;">
                                                        {{ $unreadCount }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="p-5 text-center">
                                <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 24px;">
                                    <i class="fa fa-comment-dots"></i>
                                </div>
                                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">
                                    Belum Ada Percakapan
                                </h3>
                                <p style="font-size: 13.5px; color: var(--color-stone); max-width: 440px; margin: 0 auto 20px; line-height: 1.6;">
                                    Mulai percakapan dengan pemilik kos melalui form &ldquo;Hubungi Pemilik&rdquo; pada halaman detail kos yang Anda minati.
                                </p>
                                <a href="{{ route('kos.index') }}" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13px; padding: 9px 20px; border-radius: var(--radius-buttons); border: none;">
                                    <i class="fa fa-search mr-1"></i> Cari Kos Idaman
                                </a>
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
