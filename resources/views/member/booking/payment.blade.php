@extends('layouts.app')

@section('title', 'Pembayaran Booking - TEMPATIN')

@push('styles')
<style>
    .pk-payment-card { background: #fff; border: 0; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    .pk-payment-card .card-header { background: #f8f9fa; border-bottom: 1px solid #e9ecef; padding: 20px 24px; }
    .pk-payment-card .card-body { padding: 24px; }
    .pk-payment-method { display: block; border: 1px solid #dee2e6; border-radius: 6px; padding: 15px; cursor: pointer; margin-bottom: 12px; transition: border-color .2s, background .2s; }
    .pk-payment-method:hover, .pk-payment-method:has(input:checked) { border-color: #007bff; background: #f4f9ff; }
    .pk-payment-method input { margin-right: 10px; }
    .pk-payment-method i { width: 24px; color: #007bff; margin-right: 8px; }
    .pk-total { background: #f4f9ff; border-top: 3px solid #007bff; padding: 18px; }
    .pk-total strong { color: #007bff; font-size: 22px; }
    .pk-step { display: flex; align-items: center; color: #adb5bd; font-size: 13px; font-weight: 600; }
    .pk-step.active { color: #007bff; }
    .pk-step-number { width: 30px; height: 30px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px; background: #e9ecef; }
    .pk-step.active .pk-step-number { background: #007bff; color: #fff; }
    .pk-step-line { width: 42px; border-top: 1px solid #dee2e6; margin: 0 12px; }
    .pk-detail-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; }
    @media (max-width: 575px) { .pk-step-line { width: 18px; margin: 0 6px; } .pk-step { font-size: 11px; } .pk-payment-card .card-body { padding: 18px; } }
</style>
@endpush

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">
    @include('partials.navbar')
    @include('partials.alert')
    <main id="ts-main">
        <section id="breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('member.home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('member.booking.create', $kos['slug']) }}">Booking</a></li><li class="breadcrumb-item active">Pembayaran</li></ol></nav></div></section>
        <section id="page-title"><div class="container"><div class="ts-title mb-0"><h1>Pembayaran Booking</h1><h5 class="ts-opacity__90"><i class="fa fa-credit-card text-primary mr-2"></i>Periksa detail booking dan pilih metode pembayaran</h5></div></div></section>
        <section id="content"><div class="container">
            <div class="d-flex justify-content-center align-items-center mb-4"><div class="pk-step active"><span class="pk-step-number"><i class="fa fa-check"></i></span>Data Booking</div><span class="pk-step-line"></span><div class="pk-step active"><span class="pk-step-number">2</span>Pembayaran</div><span class="pk-step-line"></span><div class="pk-step"><span class="pk-step-number">3</span>Selesai</div></div>
            <div class="row">
                <div class="col-lg-7 mb-4 mb-lg-0"><div class="pk-payment-card"><div class="card-header"><h3 class="mb-0">Pilih Metode Pembayaran</h3></div><div class="card-body"><form method="POST" action="{{ route('member.payment.confirm') }}">@csrf<input type="hidden" name="total" value="{{ $booking['total'] }}"><input type="hidden" name="kos_slug" value="{{ $kos['slug'] }}"><label class="pk-payment-method"><input type="radio" name="payment_method" value="Transfer Bank" required><i class="fa fa-university"></i><strong>Transfer Bank</strong><small class="d-block text-muted ml-4">BCA, BNI, Mandiri, dan BRI</small></label><label class="pk-payment-method"><input type="radio" name="payment_method" value="E-Wallet"><i class="fa fa-wallet"></i><strong>E-Wallet</strong><small class="d-block text-muted ml-4">GoPay, OVO, Dana, dan ShopeePay</small></label><label class="pk-payment-method"><input type="radio" name="payment_method" value="Virtual Account"><i class="fa fa-qrcode"></i><strong>Virtual Account</strong><small class="d-block text-muted ml-4">Pembayaran otomatis melalui virtual account</small></label><div class="alert alert-info small mt-4 mb-4"><i class="fa fa-info-circle mr-2"></i>Instruksi pembayaran akan ditampilkan setelah booking dikonfirmasi.</div><div class="d-flex justify-content-between align-items-center flex-wrap"><a href="{{ route('member.booking.create', $kos['slug']) }}" class="btn btn-outline-secondary mb-2"><i class="fa fa-arrow-left mr-2"></i>Ubah Data</a><button type="submit" class="btn btn-primary mb-2"><i class="fa fa-lock mr-2"></i>Konfirmasi Booking</button></div></form></div></div></div>
                <div class="col-lg-5"><div class="pk-payment-card"><div class="card-header"><h3 class="mb-0">Detail Booking</h3></div><div class="card-body"><h4 class="mb-1">{{ $kos['title'] }}</h4><p class="text-muted small mb-4"><i class="fa fa-map-marker mr-1"></i>{{ $kos['address'] }}</p><div class="pk-detail-row"><span class="text-muted">Penyewa</span><strong>{{ $booking['tenant_name'] }}</strong></div><div class="pk-detail-row"><span class="text-muted">Mulai sewa</span><strong>{{ date('d M Y', strtotime($booking['check_in'])) }}</strong></div><div class="pk-detail-row"><span class="text-muted">Durasi</span><strong>{{ $booking['duration_label'] }}</strong></div><hr><div class="pk-detail-row"><span class="text-muted">Sewa kos</span><span>Rp {{ number_format($booking['subtotal'], 0, ',', '.') }}</span></div><div class="pk-detail-row"><span class="text-muted">Biaya admin</span><span>Rp {{ number_format($booking['admin_fee'], 0, ',', '.') }}</span></div><div class="pk-total mt-3"><div class="d-flex justify-content-between align-items-center"><span>Total pembayaran</span><strong>Rp {{ number_format($booking['total'], 0, ',', '.') }}</strong></div></div></div></div></div>
            </div>
        </div></section>
    </main>
    @include('partials.footer')
</div>
@endsection
