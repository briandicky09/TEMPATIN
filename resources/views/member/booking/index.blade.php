@extends('layouts.app')

@section('title', 'Booking ' . $kos['title'] . ' - TEMPATIN')

@push('styles')
<style>
    .pk-booking-card { background: #fff; border: 0; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.08); }
    .pk-booking-card .card-header { background: #f8f9fa; border-bottom: 1px solid #e9ecef; padding: 20px 24px; }
    .pk-booking-card .card-body { padding: 24px; }
    .pk-step { display: flex; align-items: center; color: #adb5bd; font-size: 13px; font-weight: 600; }
    .pk-step.active { color: #007bff; }
    .pk-step-number { width: 30px; height: 30px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px; background: #e9ecef; }
    .pk-step.active .pk-step-number { background: #007bff; color: #fff; }
    .pk-step-line { width: 42px; border-top: 1px solid #dee2e6; margin: 0 12px; }
    .pk-kos-summary { display: flex; align-items: center; padding: 18px; border-bottom: 1px solid #e9ecef; }
    .pk-kos-summary img { width: 84px; height: 68px; object-fit: cover; border-radius: 6px; margin-right: 16px; }
    .pk-kos-summary h4 { margin: 0 0 5px; font-size: 18px; }
    .pk-price { color: #007bff; font-weight: 700; }
    .pk-form-label { font-weight: 600; font-size: 14px; color: #343a40; }
    .pk-note { background: #eef7ff; color: #486581; border-left: 3px solid #007bff; padding: 13px 15px; font-size: 13px; }
    @media (max-width: 575px) { .pk-step-line { width: 18px; margin: 0 6px; } .pk-step { font-size: 11px; } .pk-booking-card .card-body { padding: 18px; } }
</style>
@endpush

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">
    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main">
        <section id="breadcrumb"><div class="container"><nav aria-label="breadcrumb"><ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('member.home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('member.kos.show', $kos['slug']) }}">{{ $kos['title'] }}</a></li>
            <li class="breadcrumb-item active">Booking</li>
        </ol></nav></div></section>

        <section id="page-title"><div class="container"><div class="ts-title mb-0">
            <h1>Booking Kos</h1>
            <h5 class="ts-opacity__90"><i class="fa fa-calendar-check text-primary mr-2"></i>Lengkapi data untuk melanjutkan ke pembayaran</h5>
        </div></div></section>

        <section id="content"><div class="container">
            <div class="d-flex justify-content-center align-items-center mb-4">
                <div class="pk-step active"><span class="pk-step-number">1</span>Data Booking</div>
                <span class="pk-step-line"></span>
                <div class="pk-step"><span class="pk-step-number">2</span>Pembayaran</div>
                <span class="pk-step-line"></span>
                <div class="pk-step"><span class="pk-step-number">3</span>Selesai</div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="pk-booking-card">
                        <div class="card-header"><h3 class="mb-0">Data Penyewa</h3></div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('member.booking.store', $kos['slug']) }}">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="pk-form-label" for="tenant_name">Nama Lengkap</label>
                                        <input id="tenant_name" name="tenant_name" type="text" class="form-control @error('tenant_name') is-invalid @enderror" value="{{ old('tenant_name', auth()->user()->name ?? '') }}" placeholder="Masukkan nama lengkap" required>
                                        @error('tenant_name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="pk-form-label" for="tenant_phone">Nomor WhatsApp</label>
                                        <input id="tenant_phone" name="tenant_phone" type="tel" class="form-control @error('tenant_phone') is-invalid @enderror" value="{{ old('tenant_phone', auth()->user()->phone ?? '') }}" placeholder="08xxxxxxxxxx" required>
                                        @error('tenant_phone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="pk-form-label" for="tenant_email">Email</label>
                                    <input id="tenant_email" name="tenant_email" type="email" class="form-control @error('tenant_email') is-invalid @enderror" value="{{ old('tenant_email', auth()->user()->email ?? '') }}" placeholder="nama@email.com" required>
                                    @error('tenant_email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="pk-form-label" for="start_date">Tanggal Mulai Sewa</label>
                                        <input id="start_date" name="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" min="{{ date('Y-m-d') }}" value="{{ old('start_date', old('check_in', date('Y-m-d'))) }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="pk-form-label" for="duration_months">Durasi Sewa</label>
                                        <select id="duration_months" name="duration_months" class="form-control @error('duration_months') is-invalid @enderror" required>
                                            @for($month = 1; $month <= 12; $month++)
                                                <option value="{{ $month }}" {{ old('duration_months', old('duration', 1)) == $month ? 'selected' : '' }}>{{ $month }} Bulan</option>
                                            @endfor
                                        </select>
                                        @error('duration_months')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="pk-form-label" for="notes">Catatan <span class="text-muted font-weight-normal">(opsional)</span></label>
                                    <textarea id="notes" name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="Contoh: membutuhkan parkir motor">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="pk-note mb-4">
                                    <i class="fa fa-shield-alt mr-2"></i>Data kamu digunakan hanya untuk proses booking dan konfirmasi pemilik kos.
                                </div>
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <a href="{{ route('member.kos.show', $kos['slug']) }}" class="btn btn-outline-secondary mb-2">
                                        <i class="fa fa-arrow-left mr-2"></i>Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary mb-2">
                                        <i class="fa fa-calendar-check mr-2"></i>Konfirmasi & Buat Booking
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="pk-booking-card">
                        <div class="pk-kos-summary">
                            <img src="{{ asset($kos['thumbnail']) }}" alt="{{ $kos['title'] }}">
                            <div>
                                <h4>{{ $kos['title'] }}</h4>
                                <div class="text-muted small"><i class="fa fa-map-marker mr-1"></i>{{ $kos['city'] }}</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="mb-3">Ringkasan Harga</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Harga / bulan</span>
                                <span>Rp {{ number_format($kos['price'], 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Durasi</span>
                                <span id="summary-duration">1 Bulan</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal</span>
                                <span id="summary-subtotal">Rp {{ number_format($kos['price'], 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Biaya admin</span>
                                <span>Rp 25.000</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>Total</strong>
                                <strong class="pk-price" id="summary-total">Rp {{ number_format($kos['price'] + 25000, 0, ',', '.') }}</strong>
                            </div>
                            <small class="text-muted d-block mt-2">Perhitungan resmi akan diverifikasi oleh sistem saat booking dibuat.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div></section>
    </main>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const durationSelect = document.getElementById('duration_months');
            const summaryDuration = document.getElementById('summary-duration');
            const summarySubtotal = document.getElementById('summary-subtotal');
            const summaryTotal = document.getElementById('summary-total');

            const pricePerMonth = {{ (float) $kos['price'] }};
            const adminFee = 25000;

            function formatRupiah(number) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
            }

            function updateSummary() {
                const duration = parseInt(durationSelect.value, 10) || 1;
                const subtotal = pricePerMonth * duration;
                const total = subtotal + adminFee;

                summaryDuration.textContent = duration + ' Bulan';
                summarySubtotal.textContent = formatRupiah(subtotal);
                summaryTotal.textContent = formatRupiah(total);
            }

            if (durationSelect) {
                durationSelect.addEventListener('change', updateSummary);
                updateSummary();
            }
        });
    </script>
    @endpush

    @include('partials.footer')
</div>
@endsection

