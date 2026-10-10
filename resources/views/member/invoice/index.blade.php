@extends('layouts.app')

@section('title', 'Invoice & Tagihan Saya - TEMPATIN')

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
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Invoice Saya</li>
                </ol>
            </nav>
        </div>

        <!-- HEADER -->
        <section class="container mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 600;">
                        <i class="fa fa-file-invoice mr-1"></i> PUSAT TAGIHAN RESMI
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Invoice & Tagihan Saya
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Kelola seluruh riwayat tagihan berkala, status verifikasi, dan unduh kuitansi resmi sewa kos.
                    </p>
                </div>
            </div>
        </section>

        <!-- SUMMARY STATS -->
        @php
            $totalCount = $invoices->count();
            $paidCount = $invoices->where('status', 'paid')->count();
            $unpaidCount = $invoices->where('status', 'unpaid')->count();
        @endphp
        <section class="container mb-4">
            <div class="row">
                <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                    <div class="p-3 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 4px;">Total Tagihan</div>
                        <div style="font-size: 1.6rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">{{ $totalCount }}</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 mb-3 mb-md-0">
                    <div class="p-3 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 4px;">Sudah Lunas</div>
                        <div style="font-size: 1.6rem; font-weight: 700; color: #166534; font-variant-numeric: tabular-nums;">{{ $paidCount }}</div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="p-3 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; color: var(--color-stone); font-weight: 500; margin-bottom: 4px;">Menunggu Pembayaran</div>
                        <div style="font-size: 1.6rem; font-weight: 700; color: #b45309; font-variant-numeric: tabular-nums;">{{ $unpaidCount }}</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- INVOICE LIST TABLE -->
        <section class="container">
            <div class="rounded overflow-hidden" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                @if($invoices->isNotEmpty())
                    <div class="table-responsive mb-0">
                        <table class="table mb-0 align-middle">
                            <thead style="background-color: var(--surface-page-canvas); border-bottom: var(--border-hairline);">
                                <tr>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">No. Invoice</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Properti Kos</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Jatuh Tempo</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Total Biaya</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none;">Status</th>
                                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 14px 20px; border-top: none; text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $inv)
                                    @php
                                        $isPaid = in_array(strtolower($inv->status), ['paid', 'lunas', 'settled', 'success']);
                                        $statusClass = $isPaid 
                                            ? 'background-color: #edf7ee; color: #166534; border: 1px solid rgba(22, 101, 52, 0.2);'
                                            : 'background-color: #fef9c3; color: #854d0e; border: 1px solid rgba(133, 77, 14, 0.2);';
                                        $statusLabel = $inv->status_label ?? ucfirst($inv->status);
                                    @endphp
                                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                                        <td style="padding: 16px 20px;">
                                            <a href="{{ route('member.invoice.show', $inv->invoice_number) }}" style="font-family: monospace; font-weight: 700; color: var(--color-notion-blue); text-decoration: none;">
                                                {{ $inv->invoice_number }}
                                            </a>
                                        </td>
                                        <td style="padding: 16px 20px;">
                                            <div style="font-weight: 600; color: var(--color-midnight-ink); font-size: 14px;">
                                                {{ $inv->kos->title ?? $inv->booking->kos->title ?? 'Hunian Kos' }}
                                            </div>
                                            <div style="font-size: 12px; color: var(--color-stone);">
                                                {{ $inv->kos->city ?? 'Indonesia' }}
                                            </div>
                                        </td>
                                        <td style="padding: 16px 20px; font-size: 13.5px; color: var(--color-stone);">
                                            {{ $inv->due_date ? $inv->due_date->format('d M Y') : '-' }}
                                        </td>
                                        <td style="padding: 16px 20px; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums; font-size: 14px;">
                                            Rp {{ number_format($inv->total_amount ?? $inv->amount, 0, ',', '.') }}
                                        </td>
                                        <td style="padding: 16px 20px;">
                                            <span class="px-2 py-1 rounded-pill" style="{{ $statusClass }}; font-size: 11px; font-weight: 600;">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td style="padding: 16px 20px; text-align: right;">
                                            <a href="{{ route('member.invoice.show', $inv->invoice_number) }}" class="btn btn-sm btn-ghost" style="font-weight: 600; font-size: 12px; border-radius: var(--radius-buttons); padding: 6px 14px;">
                                                Lihat Rincian
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px; border-radius: 50%; background-color: var(--surface-page-canvas); color: var(--color-stone); font-size: 24px;">
                            <i class="fa fa-file-invoice"></i>
                        </div>
                        <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">
                            Belum Ada Invoice
                        </h3>
                        <p style="font-size: 13.5px; color: var(--color-stone); max-width: 440px; margin: 0 auto 20px;">
                            Anda belum memiliki tagihan sewa. Saat Anda melakukan booking kos, invoice otomatis akan terbit di halaman ini.
                        </p>
                        <a href="{{ route('search.kos') }}" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13px; padding: 10px 20px; border-radius: var(--radius-buttons); border: none;">
                            <i class="fa fa-search mr-2"></i> Cari Kos Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
