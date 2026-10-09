@extends('layouts.app')

@section('title', 'Invoice ' . ($invoice->invoice_number ?? '') . ' - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 100px; padding-bottom: 80px;">

        <!-- BREADCRUMB (HIDDEN IN PRINT) -->
        <div class="container mb-4 d-print-none">
            <div class="d-flex justify-content-between align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                        <li class="breadcrumb-item"><a href="{{ route('member.home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('member.invoice.index') }}" style="color: var(--color-stone); text-decoration: none;">Invoice Saya</a></li>
                        <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">{{ $invoice->invoice_number }}</li>
                    </ol>
                </nav>
                <div class="d-flex gap-2">
                    <button type="button" onclick="window.print()" class="btn btn-sm" style="background-color: #ffffff; border: var(--border-hairline); font-size: 12px; font-weight: 600; color: var(--color-midnight-ink); border-radius: var(--radius-buttons); padding: 8px 14px;">
                        <i class="fa fa-print mr-1"></i> Cetak Invoice
                    </button>
                    <a href="{{ route('member.invoice.index') }}" class="btn btn-sm" style="background-color: var(--surface-page-canvas); border: var(--border-hairline); font-size: 12px; font-weight: 600; color: var(--color-stone); border-radius: var(--radius-buttons); padding: 8px 14px;">
                        <i class="fa fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- NOTION INVOICE DOCUMENT -->
        <section class="container">
            <div class="mx-auto p-4 p-md-5 rounded" style="max-width: 840px; background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                <!-- INVOICE TOP BAR -->
                <div class="d-flex flex-wrap justify-content-between align-items-start pb-4 mb-4 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <span style="font-size: 1.5rem; font-weight: 800; color: var(--color-midnight-ink); letter-spacing: -0.03em;">
                                <i class="fa fa-home mr-2" style="color: var(--color-notion-blue);"></i>TEMPATIN
                            </span>
                        </div>
                        <div style="font-size: 12px; color: var(--color-stone); line-height: 1.5;">
                            Platform Hunian & Sewa Kos Digital Indonesia<br>
                            support@tempatin.id • +62 812-3456-7890
                        </div>
                    </div>

                    <div class="text-md-right mt-3 mt-md-0">
                        <div style="font-size: 12px; text-transform: uppercase; font-weight: 700; color: var(--color-stone); letter-spacing: 0.05em; margin-bottom: 2px;">
                            FAKTUR TAGIHAN
                        </div>
                        <div style="font-family: monospace; font-size: 1.25rem; font-weight: 800; color: var(--color-midnight-ink); margin-bottom: 8px;">
                            {{ $invoice->invoice_number }}
                        </div>
                        @php
                            $statusStyle = 'background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline);';
                        @endphp
                        <span class="px-3 py-1 rounded-pill" style="{{ $statusStyle }}; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                            {{ $invoice->status_label ?? ucfirst($invoice->status) }}
                        </span>
                    </div>
                </div>

                <!-- 2-COLUMN PARTIES INFO -->
                <div class="row mb-4">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--color-stone); letter-spacing: 0.05em; margin-bottom: 6px;">
                            DITAGIHKAN KEPADA
                        </div>
                        <div style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">
                            {{ $invoice->booking->tenant_name ?? $invoice->customer->name ?? 'Penghuni Kos' }}
                        </div>
                        <div style="font-size: 13px; color: var(--color-stone); line-height: 1.5;">
                            {{ $invoice->booking->tenant_email ?? $invoice->customer->email ?? '-' }}<br>
                            {{ $invoice->booking->tenant_phone ?? $invoice->customer->phone ?? '-' }}
                        </div>
                    </div>

                    <div class="col-sm-6 text-sm-right">
                        <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--color-stone); letter-spacing: 0.05em; margin-bottom: 6px;">
                            DETAIL HUNIAN & WAKTU
                        </div>
                        <div style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">
                            {{ $invoice->kos->title ?? $invoice->booking->kos->title ?? 'Hunian Kos' }}
                        </div>
                        <div style="font-size: 13px; color: var(--color-stone); line-height: 1.5;">
                            {{ $invoice->kos->address ?? $invoice->booking->kos->address ?? '' }}<br>
                            Tanggal Terbit: {{ $invoice->created_at ? $invoice->created_at->format('d M Y') : date('d M Y') }}<br>
                            Jatuh Tempo: <strong style="color: var(--color-midnight-ink);">{{ $invoice->due_date ? $invoice->due_date->format('d M Y') : '-' }}</strong>
                        </div>
                    </div>
                </div>

                <!-- TABLE ITEMS -->
                <div class="table-responsive mb-4">
                    <table class="table mb-0" style="border-collapse: separate; border-spacing: 0;">
                        <thead style="background-color: var(--surface-page-canvas);">
                            <tr>
                                <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 16px; border: none; border-radius: 6px 0 0 6px;">Deskripsi Tagihan</th>
                                <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 16px; border: none; text-align: center;">Durasi</th>
                                <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 16px; border: none; text-align: right; border-radius: 0 6px 6px 0;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                                <td style="padding: 16px; font-size: 14px;">
                                    <div style="font-weight: 600; color: var(--color-midnight-ink);">Sewa Kamar Kos</div>
                                    <div style="font-size: 12px; color: var(--color-stone);">{{ $invoice->kos->title ?? $invoice->booking->kos->title ?? 'Hunian Kos' }}</div>
                                </td>
                                <td style="padding: 16px; font-size: 14px; text-align: center; color: var(--color-stone);">
                                    {{ $invoice->booking->duration_months ?? 1 }} Bulan
                                </td>
                                <td style="padding: 16px; font-size: 14px; text-align: right; font-weight: 600; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                                    Rp {{ number_format($invoice->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                                <td style="padding: 16px; font-size: 14px;">
                                    <div style="font-weight: 600; color: var(--color-midnight-ink);">Biaya Layanan Admin & Escrow</div>
                                    <div style="font-size: 12px; color: var(--color-stone);">Perlindungan transaksi garansi kamar</div>
                                </td>
                                <td style="padding: 16px; font-size: 14px; text-align: center; color: var(--color-stone);">-</td>
                                <td style="padding: 16px; font-size: 14px; text-align: right; font-weight: 600; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                                    Rp {{ number_format($invoice->admin_fee, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- TOTAL CALCULATION -->
                <div class="row justify-content-end mb-4">
                    <div class="col-sm-6">
                        <div class="p-3 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px; color: var(--color-stone);">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($invoice->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px; color: var(--color-stone);">
                                <span>Biaya Admin</span>
                                <span>Rp {{ number_format($invoice->admin_fee, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px; color: var(--color-stone);">
                                <span>Pajak (PPN 0%)</span>
                                <span>Rp 0</span>
                            </div>
                            <div class="pt-2 border-top d-flex justify-content-between align-items-center" style="border-color: rgba(0,0,0,0.08) !important;">
                                <strong style="font-size: 14px; color: var(--color-midnight-ink);">Total Pembayaran</strong>
                                <strong style="font-size: 1.3rem; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                                     Rp {{ number_format($invoice->total_amount ?? $invoice->amount, 0, ',', '.') }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER NOTICE -->
                <div class="p-3 rounded d-flex align-items-center" style="background-color: var(--surface-page-canvas); border: 1px dashed rgba(0, 0, 0, 0.15); font-size: 12.5px; color: var(--color-charcoal);">
                    <i class="fa fa-info-circle mr-2" style="font-size: 16px; color: var(--color-charcoal);"></i>
                    <span>
                        Dokumen ini diterbitkan secara sah oleh sistem elektronik TEMPATIN dan berlaku sebagai bukti sah perjanjian pembayaran sewa.
                    </span>
                </div>

            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
