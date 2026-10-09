@extends('layouts.app')

@section('title', 'Profil Saya - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    @php
        $displayName = $user?->name ?? 'Member TEMPATIN';
        $displayEmail = $user?->email ?? 'Email belum tersedia';
        $displayPhone = $user?->phone ?? 'Belum diisi';
        $displayRole = ucfirst($user?->role ?? 'member');
    @endphp

    <main id="ts-main" style="padding-top: 100px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('member.home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Profil Saya</li>
                </ol>
            </nav>
        </div>

        <section class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">

                    <!-- NOTION PROFILE CARD -->
                    <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                        <!-- Avatar & Identity -->
                        <div class="d-flex align-items-center pb-4 mb-4 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-3" style="width: 68px; height: 68px; background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 26px; font-weight: 700;">
                                {{ strtoupper(substr($displayName, 0, 1)) }}
                            </div>
                            <div>
                                <h1 style="font-family: var(--font-serif); font-size: 1.5rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">
                                    {{ $displayName }}
                                </h1>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-size: 11px; font-weight: 600; padding: 4px 8px; border-radius: 4px;">
                                        {{ $displayRole }}
                                    </span>
                                    <span style="font-size: 13px; color: var(--color-stone);">{{ $displayEmail }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Info List -->
                        <div class="mb-4">
                            <h2 style="font-size: 12px; text-transform: uppercase; font-weight: 700; color: var(--color-stone); letter-spacing: 0.05em; margin-bottom: 12px;">
                                INFORMASI AKUN
                            </h2>
                            <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important; font-size: 13.5px;">
                                <span style="color: var(--color-stone);">Nama Lengkap</span>
                                <strong style="color: var(--color-midnight-ink);">{{ $displayName }}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important; font-size: 13.5px;">
                                <span style="color: var(--color-stone);">Email Terdaftar</span>
                                <strong style="color: var(--color-midnight-ink);">{{ $displayEmail }}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-2 border-bottom" style="border-color: rgba(0,0,0,0.06) !important; font-size: 13.5px;">
                                <span style="color: var(--color-stone);">Nomor Telepon</span>
                                <strong style="color: var(--color-midnight-ink);">{{ $displayPhone }}</strong>
                            </div>
                            <div class="d-flex justify-content-between py-2" style="font-size: 13.5px;">
                                <span style="color: var(--color-stone);">Status Keanggotaan</span>
                                <span style="color: var(--color-midnight-ink); font-weight: 600;"><i class="fa fa-check-circle mr-1" style="color: var(--color-charcoal);"></i> Aktif Terverifikasi</span>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="pt-3 border-top d-flex flex-wrap gap-2 justify-content-between align-items-center" style="border-color: rgba(0,0,0,0.06) !important;">
                            <a href="{{ route('member.invoice.index') }}" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 10px 18px; border: none;">
                                <i class="fa fa-file-invoice mr-2"></i> Riwayat Invoice
                            </a>
                            <a href="{{ route('member.contact') }}" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 10px 18px;">
                                <i class="fa fa-life-ring mr-2"></i> Pusat Bantuan
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
