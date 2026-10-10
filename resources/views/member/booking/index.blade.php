@extends('layouts.app')

@section('title', 'Booking ' . $kos['title'] . ' - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    <main id="ts-main" style="padding-top: 20px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('member.home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('member.kos.show', $kos['slug']) }}" style="color: var(--color-stone); text-decoration: none;">{{ $kos['title'] }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Booking</li>
                </ol>
            </nav>
        </div>

        <!-- STEP PROGRESS INDICATOR -->
        <div class="container mb-5">
            <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 13px; font-weight: 600; border: 1px solid rgba(0, 117, 222, 0.2);">
                    <span class="mr-2" style="width: 20px; height: 20px; border-radius: 50%; background-color: var(--color-notion-blue); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;">1</span>
                    Data Penyewa
                </div>
                <span style="color: var(--color-stone); font-size: 12px;"><i class="fa fa-chevron-right"></i></span>
                <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill" style="background-color: #ffffff; color: var(--color-stone); font-size: 13px; font-weight: 500; border: var(--border-hairline);">
                    <span class="mr-2" style="width: 20px; height: 20px; border-radius: 50%; background-color: var(--surface-page-canvas); color: var(--color-stone); display: inline-flex; align-items: center; justify-content: center; font-size: 11px;">2</span>
                    Metode Pembayaran
                </div>
                <span style="color: var(--color-stone); font-size: 12px;"><i class="fa fa-chevron-right"></i></span>
                <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill" style="background-color: #ffffff; color: var(--color-stone); font-size: 13px; font-weight: 500; border: var(--border-hairline);">
                    <span class="mr-2" style="width: 20px; height: 20px; border-radius: 50%; background-color: var(--surface-page-canvas); color: var(--color-stone); display: inline-flex; align-items: center; justify-content: center; font-size: 11px;">3</span>
                    Konfirmasi Selesai
                </div>
            </div>
        </div>

        <section class="container">
            <div class="row">

                <!-- LEFT COLUMN: FORM DATA PENYEWA -->
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <h2 style="font-family: var(--font-serif); font-size: 1.5rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">
                            Formulir Pemesanan Kamar
                        </h2>
                        <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 24px;">
                            Mohon lengkapi identitas penghuni yang akan menempati kamar kos.
                        </p>

                        <form method="POST" action="{{ route('member.booking.store', $kos['slug']) }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="tenant_name" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Nama Lengkap Penyewa <span class="text-danger">*</span></label>
                                    <input id="tenant_name" name="tenant_name" type="text" class="form-control @error('tenant_name') is-invalid @enderror" value="{{ old('tenant_name', auth()->user()->name ?? '') }}" placeholder="Nama sesuai KTP" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                    @error('tenant_name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="tenant_phone" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Nomor WhatsApp Aktif <span class="text-danger">*</span></label>
                                    <input id="tenant_phone" name="tenant_phone" type="tel" class="form-control @error('tenant_phone') is-invalid @enderror" value="{{ old('tenant_phone', auth()->user()->phone ?? '') }}" placeholder="cth. 081234567890" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                    @error('tenant_phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="tenant_email" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Alamat Email <span class="text-danger">*</span></label>
                                <input id="tenant_email" name="tenant_email" type="email" class="form-control @error('tenant_email') is-invalid @enderror" value="{{ old('tenant_email', auth()->user()->email ?? '') }}" placeholder="nama@email.com" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                @error('tenant_email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="start_date" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Tanggal Mulai Sewa <span class="text-danger">*</span></label>
                                    <input id="start_date" name="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" min="{{ date('Y-m-d') }}" value="{{ old('start_date', old('check_in', date('Y-m-d'))) }}" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
                                    @error('start_date')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="duration_months" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Durasi Sewa <span class="text-danger">*</span></label>
                                    <select id="duration_months" name="duration_months" class="form-control @error('duration_months') is-invalid @enderror" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; height: 44px; padding: 0 14px;">
                                        @for($month = 1; $month <= 12; $month++)
                                            <option value="{{ $month }}" {{ old('duration_months', old('duration', 1)) == $month ? 'selected' : '' }}>{{ $month }} Bulan</option>
                                        @endfor
                                    </select>
                                    @error('duration_months')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label for="notes" style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Catatan Khusus ke Pemilik <span style="font-weight: 400; color: var(--color-stone);">(opsional)</span></label>
                                <textarea id="notes" name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" placeholder="cth. Membawa motor, rencana check-in sore hari" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 12px 14px; line-height: 1.5;">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Security Guarantee Notice -->
                            <div class="p-3 mb-4 rounded d-flex align-items-center" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13px; color: var(--color-charcoal);">
                                <i class="fa fa-shield-alt mr-3 text-primary" style="font-size: 18px;"></i>
                                <span>Data privasi Anda terlindungi. Pembayaran hanya akan diteruskan ke pemilik setelah kamar diverifikasi.</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                                <a href="{{ route('member.kos.show', $kos['slug']) }}" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 10px 18px;">
                                    <i class="fa fa-arrow-left mr-2"></i> Kembali
                                </a>
                                <button type="submit" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 600; font-size: 14px; padding: 12px 28px; border-radius: var(--radius-buttons); border: none;">
                                    Lanjut ke Pembayaran <i class="fa fa-arrow-right ml-2"></i>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- RIGHT COLUMN: PROPERTY & PRICE SUMMARY -->
                <div class="col-lg-4">
                    <div style="position: sticky; top: 90px;">

                        <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                            <!-- Property Brief -->
                            <div class="d-flex gap-3 mb-3 pb-3 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
                                <img src="{{ asset($kos['thumbnail']) }}" alt="{{ $kos['title'] }}" class="rounded mr-3" style="width: 80px; height: 80px; object-fit: cover; border: var(--border-hairline);">
                                <div>
                                    <span class="badge mb-1" style="background-color: var(--surface-page-canvas); color: var(--color-stone); border: var(--border-hairline); font-size: 10px;">PROPERTI</span>
                                    <h3 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">{{ $kos['title'] }}</h3>
                                    <div style="font-size: 12px; color: var(--color-stone);"><i class="fa fa-map-marker-alt mr-1 text-danger"></i> {{ $kos['city'] }}</div>
                                </div>
                            </div>

                            <!-- Cost Breakdown -->
                            <h4 style="font-size: 13px; text-transform: uppercase; font-weight: 700; color: var(--color-stone); letter-spacing: 0.05em; margin-bottom: 12px;">
                                Ringkasan Harga
                            </h4>

                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px; color: var(--color-stone);">
                                <span>Tarif Sewa / bulan</span>
                                <span style="color: var(--color-midnight-ink); font-weight: 600;">Rp {{ number_format($kos['price'], 0, ',', '.') }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px; color: var(--color-stone);">
                                <span>Durasi Dipilih</span>
                                <span id="summary-duration" style="color: var(--color-midnight-ink); font-weight: 600;">1 Bulan</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px; color: var(--color-stone);">
                                <span>Subtotal Sewa</span>
                                <span id="summary-subtotal" style="color: var(--color-midnight-ink); font-weight: 600;">Rp {{ number_format($kos['price'], 0, ',', '.') }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3" style="font-size: 13.5px; color: var(--color-stone);">
                                <span>Biaya Layanan Admin</span>
                                <span style="color: var(--color-midnight-ink); font-weight: 600;">Rp 25.000</span>
                            </div>

                            <div class="p-3 rounded mb-2" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Total Pembayaran</span>
                                    <span id="summary-total" style="font-size: 1.25rem; font-weight: 700; color: var(--color-notion-blue); font-variant-numeric: tabular-nums;">
                                        Rp {{ number_format($kos['price'] + 25000, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <div style="font-size: 11px; color: var(--color-stone); line-height: 1.5;">
                                * Perhitungan otomatis diverifikasi oleh sistem penagihan resmi TEMPATIN.
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </section>

    </main>

    @include('partials.footer')

</div>

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
@endsection
