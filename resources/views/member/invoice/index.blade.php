@extends('layouts.app')

@section('title', 'Invoice Saya - TEMPATIN')

@push('styles')
<style>
    .pk-invoice-table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 14px;
        border-bottom: 2px solid #dee2e6;
    }
    .pk-invoice-table tbody td {
        vertical-align: middle;
        font-size: 14px;
    }
    .pk-status-badge {
        font-size: 12px;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
    }
    .pk-status-badge--lunas {
        background-color: #d4edda;
        color: #155724;
    }
    .pk-status-badge--pending {
        background-color: #fff3cd;
        color: #856404;
    }
    .pk-status-badge--expired {
        background-color: #f8d7da;
        color: #721c24;
    }
    .pk-invoice-card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .pk-invoice-summary {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }
    .pk-summary-item {
        flex: 1;
        min-width: 150px;
        background: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        text-align: center;
    }
    .pk-summary-item .pk-summary-value {
        font-size: 24px;
        font-weight: 700;
        color: #333;
    }
    .pk-summary-item .pk-summary-label {
        font-size: 13px;
        color: #6c757d;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')

    @include('partials.alert')

    <main id="ts-main">

        <!--BREADCRUMB
        =========================================================================================================-->
        <section id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Invoice Saya</li>
                    </ol>
                </nav>
            </div>
        </section>

        <!--PAGE TITLE
        =========================================================================================================-->
        <section id="page-title">
            <div class="container">
                <div class="d-block d-sm-flex justify-content-between align-items-center">
                    <div class="ts-title mb-0">
                        <h1>Invoice Saya</h1>
                        <h5 class="ts-opacity__90">
                            <i class="fa fa-file-invoice text-primary mr-2"></i>
                            Daftar tagihan sewa kos kamu
                        </h5>
                    </div>
                </div>
            </div>
        </section>

        <!--CONTENT
        =========================================================================================================-->
        <section id="content">
            <div class="container">

                <!--Summary Cards-->
                <div class="pk-invoice-summary">
                    @php
                        $totalInvoice = count($invoices);
                        $totalLunas = collect($invoices)->filter(fn($i) => in_array(data_get($i, 'status'), ['paid', 'Lunas']))->count();
                        $totalBelum = collect($invoices)->filter(fn($i) => in_array(data_get($i, 'status'), ['unpaid', 'Belum Dibayar']))->count();
                        $totalAmount = collect($invoices)->sum(fn($i) => (float) (data_get($i, 'total_amount') ?? data_get($i, 'total')));
                    @endphp
                    <div class="pk-summary-item">
                        <div class="pk-summary-value">{{ $totalInvoice }}</div>
                        <div class="pk-summary-label">Total Invoice</div>
                    </div>
                    <div class="pk-summary-item">
                        <div class="pk-summary-value text-success">{{ $totalLunas }}</div>
                        <div class="pk-summary-label">Lunas</div>
                    </div>
                    <div class="pk-summary-item">
                        <div class="pk-summary-value text-warning">{{ $totalBelum }}</div>
                        <div class="pk-summary-label">Belum Dibayar</div>
                    </div>
                    <div class="pk-summary-item">
                        <div class="pk-summary-value text-primary" style="font-size: 18px;">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
                        <div class="pk-summary-label">Total Keseluruhan</div>
                    </div>
                </div>

                <!--Invoice Table-->
                <div class="card pk-invoice-card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table pk-invoice-table mb-0">
                                <thead>
                                    <tr>
                                        <th>No. Invoice</th>
                                        <th>Nama Kos</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($invoices as $invoice)
                                    <tr>
                                        <td>
                                            <strong>{{ data_get($invoice, 'invoice_number') }}</strong>
                                        </td>
                                        <td>{{ data_get($invoice, 'kos.title') ?? data_get($invoice, 'kos') ?? '-' }}</td>
                                        <td>{{ data_get($invoice, 'created_at') ? \Carbon\Carbon::parse(data_get($invoice, 'created_at'))->format('d M Y') : '-' }}</td>
                                        <td>
                                            @if(in_array(data_get($invoice, 'status'), ['paid', 'Lunas']))
                                                <span class="pk-status-badge pk-status-badge--lunas">
                                                    <i class="fa fa-check-circle mr-1"></i>Lunas
                                                </span>
                                            @elseif(in_array(data_get($invoice, 'status'), ['unpaid', 'Belum Dibayar']))
                                                <span class="pk-status-badge pk-status-badge--pending">
                                                    <i class="fa fa-clock mr-1"></i>Belum Dibayar
                                                </span>
                                            @else
                                                <span class="pk-status-badge pk-status-badge--expired">
                                                    <i class="fa fa-times-circle mr-1"></i>{{ ucfirst((string) data_get($invoice, 'status')) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td><strong>Rp {{ number_format((float) (data_get($invoice, 'total_amount') ?? data_get($invoice, 'total')), 0, ',', '.') }}</strong></td>
                                        <td class="text-center">
                                            <a href="{{ route('member.invoice.show', data_get($invoice, 'invoice_number')) }}"
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-eye mr-1"></i>Detail
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fa fa-file-invoice fa-2x mb-2 d-block"></i>
                                            Belum ada invoice saat ini.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end Invoice Table-->

                <div class="text-center mt-4">
                    <a href="{{ route('kos.index') }}" class="btn btn-outline-dark">
                        <i class="fa fa-search mr-2"></i>Cari Kos Lainnya
                    </a>
                </div>

            </div>
            <!--end container-->
        </section>

    </main>
    <!--end #ts-main-->

    @include('partials.footer')

</div>
<!--end page-->
@endsection
