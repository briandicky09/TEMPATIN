@extends('layouts.app')

@section('title', 'Pesan & Percakapan - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 6px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('member.home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Pesan</li>
                </ol>
            </nav>
        </div>

        <section class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <!-- NOTION CHAT EMPTY CARD -->
                    <div class="p-5 text-center rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px; border-radius: 50%; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 24px;">
                            <i class="fa fa-comment-dots"></i>
                        </div>
                        <h1 style="font-family: var(--font-serif); font-size: 1.5rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">
                            Kotak Pesan Masuk
                        </h1>
                        <p style="font-size: 14px; color: var(--color-stone); max-width: 460px; margin: 0 auto 24px; line-height: 1.6;">
                            Saat ini belum ada percakapan aktif dengan pemilik kos. Hubungi pemilik melalui tombol WhatsApp pada halaman detail kamar kos.
                        </p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('search.kos') }}" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 13px; padding: 10px 20px; border-radius: var(--radius-buttons); border: none;">
                                <i class="fa fa-search mr-2"></i> Jelajahi Kos
                            </a>
                            <a href="{{ route('member.home') }}" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 13px; padding: 10px 20px; border-radius: var(--radius-buttons);">
                                Beranda Member
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
