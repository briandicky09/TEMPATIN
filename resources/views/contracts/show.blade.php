@extends('layouts.app')

@section('title', 'Dokumen Kontrak Sewa Digital - ' . $contract->contract_number . ' - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 15px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('member.booking.show', $contract->booking->booking_code) }}" style="color: var(--color-stone); text-decoration: none;">Booking #{{ $contract->booking->booking_code }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Kontrak Sewa</li>
                </ol>
            </nav>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <!-- TOP ACTION BAR -->
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <div>
                            <span class="badge px-3 py-1 font-weight-normal mb-1" style="border-radius: 9999px; background-color: var(--color-sky-tint); color: var(--color-ink-black); border: 1px solid rgba(0, 117, 222, 0.2);">
                                <i class="fa fa-file-contract mr-1"></i> DOKUMEN PERJANJIAN SEWA DIGITAL
                            </span>
                            <h2 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">
                                Kontrak Sewa: {{ $contract->contract_number }}
                            </h2>
                            <p class="text-muted small mb-0">
                                Diterbitkan pada {{ $contract->created_at->format('d F Y, H:i') }} WIB
                            </p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-outline-secondary font-weight-600 btn-sm" onclick="window.print()" style="border-radius: 8px;">
                                <i class="fa fa-print mr-1"></i> Cetak
                            </button>
                            <a href="{{ route('contracts.pdf', $contract->contract_number) }}" class="btn btn-outline-primary font-weight-600 btn-sm" style="border-radius: 8px;">
                                <i class="fa fa-file-pdf mr-1"></i> Unduh PDF
                            </a>
                        </div>
                    </div>

                    <!-- CONTRACT DOCUMENT PAPER -->
                    <div class="card mb-4" style="border: var(--border-hairline); border-radius: 14px; background: #ffffff; box-shadow: 0 4px 20px rgba(0,0,0,0.04); overflow: hidden;">
                        
                        <!-- PAPER HEADER -->
                        <div class="p-4 border-bottom text-center" style="background-color: var(--surface-page-canvas); border-color: rgba(0,0,0,0.08) !important;">
                            <div class="font-weight-bold" style="font-size: 18px; color: var(--color-midnight-ink); letter-spacing: 0.05em;">
                                SURAT PERJANJIAN SEWA MENYEWA KAMAR KOS
                            </div>
                            <div class="text-muted small">
                                Platform Hunian &amp; Pencarian Kos TEMPATIN
                            </div>
                        </div>

                        <!-- PAPER CONTENT -->
                        <div class="p-4 p-md-5" style="font-family: var(--font-notioninter, 'Inter', sans-serif); color: #2f3437; font-size: 14px; line-height: 1.7;">
                            
                            <!-- SUMMARY GRID -->
                            <div class="row mb-4 p-3 rounded" style="background-color: var(--surface-page-canvas); border: var(--border-hairline); margin: 0;">
                                <div class="col-md-6 mb-3 mb-md-0 border-md-right">
                                    <div class="font-weight-bold text-dark mb-1" style="font-size: 13px; text-transform: uppercase; color: var(--color-stone);">
                                        Pihak Pertama (Pemilik Kos)
                                    </div>
                                    <div class="font-weight-bold" style="color: var(--color-midnight-ink); font-size: 15px;">
                                        {{ $contract->booking->kos->owner->name ?? 'Pemilik Properti' }}
                                    </div>
                                    <div class="text-muted small">
                                        Email: {{ $contract->booking->kos->owner->email ?? '-' }}<br>
                                        Telepon: {{ $contract->booking->kos->owner->phone ?? '-' }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="font-weight-bold text-dark mb-1" style="font-size: 13px; text-transform: uppercase; color: var(--color-stone);">
                                        Pihak Kedua (Penyewa / Penghuni)
                                    </div>
                                    <div class="font-weight-bold" style="color: var(--color-midnight-ink); font-size: 15px;">
                                        {{ $contract->booking->tenant_name ?? ($contract->booking->customer->name ?? 'Penyewa') }}
                                    </div>
                                    <div class="text-muted small">
                                        Email: {{ $contract->booking->tenant_email ?? ($contract->booking->customer->email ?? '-') }}<br>
                                        Telepon: {{ $contract->booking->tenant_phone ?? ($contract->booking->customer->phone ?? '-') }}
                                    </div>
                                </div>
                            </div>

                            <!-- TERMS BODY -->
                            <div class="contract-terms-box p-3 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); white-space: pre-wrap; font-size: 13.5px; line-height: 1.75; color: #374151;">
{{ $contract->terms }}
                            </div>

                            <!-- STATUS & DIGITAL SIGNATURE SECTION -->
                            <div class="p-4 rounded" style="border: 1px solid {{ $contract->isSigned() ? '#a7f3d0' : 'rgba(0, 117, 222, 0.25)' }}; background-color: {{ $contract->isSigned() ? '#f0fdf4' : 'var(--color-sky-tint)' }};">
                                @if($contract->isSigned())
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 48px; height: 48px; background: #10b981; color: #ffffff; font-size: 20px; flex-shrink: 0;">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div>
                                            <h5 class="font-weight-bold mb-1 text-dark" style="font-size: 16px;">
                                                Kontrak Telah Disetujui &amp; Ditandatangani Secara Elektronik
                                            </h5>
                                            <p class="mb-0 text-muted" style="font-size: 13px;">
                                                Disepakati oleh <strong>{{ $contract->booking->tenant_name ?? $contract->booking->customer->name }}</strong> pada <strong>{{ $contract->signed_at->format('d M Y, H:i:s') }} WIB</strong> (IP Perekam: <code>{{ $contract->signer_ip ?? '127.0.0.1' }}</code>).
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    @if($isCustomer)
                                        <h5 class="font-weight-bold mb-2 text-dark" style="font-size: 16px;">
                                            Persetujuan Kontrak Sewa Digital
                                        </h5>
                                        <p class="text-muted small mb-3">
                                            Harap baca seluruh pasal dan klausul di atas dengan teliti. Dengan mencentang kotak di bawah ini, Anda menyatakan telah menyetujui perjanjian sewa kamar ini secara sah.
                                        </p>
                                        <form action="{{ route('contracts.sign', $contract->contract_number) }}" method="POST">
                                            @csrf
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="checkAgreeTerms" name="agree" value="1" required>
                                                <label class="custom-control-label font-weight-600 text-dark" for="checkAgreeTerms" style="font-size: 13.5px; cursor: pointer;">
                                                    Saya menyetujui seluruh isi klausul, peraturan kos, dan kewajiban pembayaran yang tercantum dalam Kontrak Sewa ini.
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px;">
                                                <i class="fa fa-file-signature mr-2"></i>Tandatangani Kontrak Secara Elektronik
                                            </button>
                                        </form>
                                    @else
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-hourglass-half mr-3" style="font-size: 28px; color: #d97706;"></i>
                                            <div>
                                                <div class="font-weight-bold text-dark">Draf Kontrak Menunggu Persetujuan Penyewa</div>
                                                <div class="text-muted small">Penyewa belum menandatangani dokumen kontrak digital ini. Pemberitahuan akan dikirimkan otomatis setelah disetujui.</div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>

                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('member.booking.show', $contract->booking->booking_code) }}" class="btn btn-link text-muted font-weight-600">
                            &larr; Kembali ke Rincian Booking
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </main>

    @include('partials.footer')

</div>
@endsection
