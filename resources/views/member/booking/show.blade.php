@extends('layouts.app')

@section('title', 'Detail Booking ' . $booking->booking_code . ' - TEMPATIN')

@push('styles')
<style>
    .pk-booking-card { background: #fff; border: 0; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    .pk-booking-card .card-header { background: #f8f9fa; border-bottom: 1px solid #e9ecef; padding: 20px 24px; }
    .pk-booking-card .card-body { padding: 24px; }
    .pk-kos-summary { display: flex; align-items: center; padding: 18px; border-bottom: 1px solid #e9ecef; }
    .pk-kos-summary img { width: 84px; height: 68px; object-fit: cover; border-radius: 6px; margin-right: 16px; }
    .pk-kos-summary h4 { margin: 0 0 5px; font-size: 18px; }
    .pk-detail-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
    .pk-total { background: #f4f9ff; border-top: 3px solid #007bff; padding: 18px; border-radius: 0 0 8px 8px; }
    .pk-total strong { color: #007bff; font-size: 20px; }
    .badge-status-pending { background-color: #ffeeba; color: #856404; font-size: 13px; padding: 6px 12px; border-radius: 20px; font-weight: 600; }
    .badge-status-confirmed { background-color: #d4edda; color: #155724; font-size: 13px; padding: 6px 12px; border-radius: 20px; font-weight: 600; }
    .badge-status-active { background-color: #cce5ff; color: #004085; font-size: 13px; padding: 6px 12px; border-radius: 20px; font-weight: 600; }
    .badge-status-cancelled, .badge-status-rejected { background-color: #f8d7da; color: #721c24; font-size: 13px; padding: 6px 12px; border-radius: 20px; font-weight: 600; }
    .pk-success-banner { background: #e8f5e9; border: 1px solid #c8e6c9; border-radius: 8px; padding: 20px; margin-bottom: 24px; }
</style>
@endpush

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">
    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main">
        <section id="breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('member.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('member.kos.index') }}">Daftar Kos</a></li>
                        @if($booking->kos)
                            <li class="breadcrumb-item"><a href="{{ route('member.kos.show', $booking->kos->slug) }}">{{ $booking->kos->title }}</a></li>
                        @endif
                        <li class="breadcrumb-item active">Detail Booking</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section id="page-title">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <div class="ts-title mb-0">
                        <h1>Detail Booking</h1>
                        <h5 class="ts-opacity__90">
                            <i class="fa fa-receipt text-primary mr-2"></i>Kode Booking: <strong>{{ $booking->booking_code }}</strong>
                        </h5>
                    </div>
                    <div>
                        <span class="badge-status-{{ $booking->status }} text-uppercase">
                            <i class="fa fa-info-circle mr-1"></i>{{ $booking->status }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <section id="content">
            <div class="container">
                <div class="pk-success-banner d-flex align-items-center">
                    <i class="fa fa-check-circle text-success fa-2x mr-3"></i>
                    <div>
                        <h5 class="mb-1 text-success font-weight-bold">Booking Berhasil Didaftarkan!</h5>
                        <p class="mb-0 text-muted small">
                            Pesanan Anda dengan kode <strong>{{ $booking->booking_code }}</strong> telah tercatat di sistem kami dengan status <strong>{{ ucfirst($booking->status) }}</strong>.
                        </p>
                    </div>
                </div>

                <div class="row">
                    <!-- Data Penyewa & Periode -->
                    <div class="col-lg-7 mb-4 mb-lg-0">
                        <div class="pk-booking-card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Data Penyewa</h4>
                                <span class="text-muted small">ID Customer: #{{ $booking->customer_id }}</span>
                            </div>
                            <div class="card-body">
                                <div class="pk-detail-row">
                                    <span class="text-muted">Nama Lengkap</span>
                                    <strong>{{ $booking->tenant_name }}</strong>
                                </div>
                                <div class="pk-detail-row">
                                    <span class="text-muted">Nomor WhatsApp</span>
                                    <strong>{{ $booking->tenant_phone }}</strong>
                                </div>
                                <div class="pk-detail-row">
                                    <span class="text-muted">Email</span>
                                    <strong>{{ $booking->tenant_email }}</strong>
                                </div>
                                <div class="pk-detail-row">
                                    <span class="text-muted">Tanggal Mulai Sewa</span>
                                    <strong>{{ $booking->start_date ? $booking->start_date->format('d M Y') : '-' }}</strong>
                                </div>
                                <div class="pk-detail-row">
                                    <span class="text-muted">Tanggal Selesai Sewa</span>
                                    <strong>{{ $booking->end_date ? $booking->end_date->format('d M Y') : '-' }}</strong>
                                </div>
                                <div class="pk-detail-row">
                                    <span class="text-muted">Durasi</span>
                                    <strong>{{ $booking->duration_months }} Bulan</strong>
                                </div>
                                @if($booking->notes)
                                    <hr>
                                    <div class="pk-detail-row flex-column">
                                        <span class="text-muted mb-1">Catatan Tambahan:</span>
                                        <p class="mb-0 p-2 bg-light rounded text-dark font-italic">{{ $booking->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <a href="{{ route('member.kos.index') }}" class="btn btn-outline-secondary mb-2">
                                <i class="fa fa-arrow-left mr-2"></i>Cari Kos Lain
                            </a>
                            @if($booking->kos)
                                <a href="{{ route('member.kos.show', $booking->kos->slug) }}" class="btn btn-outline-primary mb-2">
                                    <i class="fa fa-building mr-2"></i>Lihat Kos
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Ringkasan Properti & Finansial -->
                    <div class="col-lg-5">
                        <div class="pk-booking-card">
                            <div class="card-header">
                                <h4 class="mb-0">Properti & Biaya</h4>
                            </div>
                            @if($booking->kos)
                                <div class="pk-kos-summary">
                                    <img src="{{ asset($booking->kos->thumbnail) }}" alt="{{ $booking->kos->title }}">
                                    <div>
                                        <h4>{{ $booking->kos->title }}</h4>
                                        <div class="text-muted small">
                                            <i class="fa fa-map-marker-alt mr-1"></i>{{ $booking->kos->city }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ $booking->kos->address }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="mb-3">Rincian Pembayaran</h5>
                                <div class="pk-detail-row">
                                    <span class="text-muted">Harga Kos / Bulan</span>
                                    <span>Rp {{ number_format($booking->kos_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="pk-detail-row">
                                    <span class="text-muted">Durasi Sewa</span>
                                    <span>{{ $booking->duration_months }} Bulan</span>
                                </div>
                                <div class="pk-detail-row">
                                    <span class="text-muted">Subtotal Sewa</span>
                                    <strong>Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</strong>
                                </div>
                                <div class="pk-detail-row">
                                    <span class="text-muted">Biaya Administrasi</span>
                                    <span>Rp {{ number_format($booking->admin_fee, 0, ',', '.') }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Total Tagihan:</span>
                                    <strong class="text-primary font-size-lg" style="font-size: 20px;">
                                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                    </strong>
                                </div>
                            </div>
                            <div class="pk-total">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">Status Pembayaran</span>
                                    <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('partials.footer')
</div>
@endsection
