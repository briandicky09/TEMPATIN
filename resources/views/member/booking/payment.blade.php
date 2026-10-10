@extends('layouts.app')

@section('title', 'Pembayaran Booking - TEMPATIN')

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
                    <li class="breadcrumb-item"><a href="{{ route('member.booking.create', $kos['slug']) }}" style="color: var(--color-stone); text-decoration: none;">Booking</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Pembayaran</li>
                </ol>
            </nav>
        </div>

        <!-- STEP PROGRESS INDICATOR -->
        <div class="container mb-5">
            <div class="d-flex align-items-center justify-content-center flex-wrap gap-2">
                <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill" style="background-color: #ffffff; color: var(--color-stone); font-size: 13px; font-weight: 500; border: var(--border-hairline);">
                    <span class="mr-2" style="width: 20px; height: 20px; border-radius: 50%; background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); display: inline-flex; align-items: center; justify-content: center; font-size: 11px; border: var(--border-hairline);"><i class="fa fa-check"></i></span>
                    Data Penyewa
                </div>
                <span style="color: var(--color-stone); font-size: 12px;"><i class="fa fa-chevron-right"></i></span>
                <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); font-size: 13px; font-weight: 600; border: var(--border-hairline);">
                    <span class="mr-2" style="width: 20px; height: 20px; border-radius: 50%; background-color: var(--color-midnight-ink); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;">2</span>
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

                <!-- LEFT COLUMN: PAYMENT METHOD -->
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <h2 style="font-family: var(--font-serif); font-size: 1.5rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 8px;">
                            Pilih Metode Pembayaran
                        </h2>
                        <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 24px;">
                            Pilih kanal pembayaran yang paling nyaman untuk Anda selesaikan.
                        </p>

                        <form method="POST" action="{{ route('member.payment.confirm') }}">
                            @csrf
                            <input type="hidden" name="total" value="{{ $booking['total'] }}">
                            <input type="hidden" name="kos_slug" value="{{ $kos['slug'] }}">

                            <div class="d-flex flex-column gap-3 mb-4">

                                <!-- Method 1: Virtual Account -->
                                <label class="p-3 rounded d-flex align-items-center justify-content-between mb-0 cursor-pointer" style="border: 2px solid var(--color-notion-blue); background-color: var(--color-sky-tint); border-radius: var(--radius-cards); cursor: pointer;">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" name="payment_method" value="Virtual Account" checked class="mr-3" style="width: 18px; height: 18px; accent-color: var(--color-notion-blue);">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">Virtual Account Otomatis</div>
                                            <div style="font-size: 12px; color: var(--color-stone);">BCA, Mandiri, BRI, BNI (Verifikasi Real-time)</div>
                                        </div>
                                    </div>
                                    <span style="font-size: 1.25rem; color: var(--color-notion-blue);"><i class="fa fa-qrcode"></i></span>
                                </label>

                                <!-- Method 2: Transfer Bank Manual -->
                                <label class="p-3 rounded d-flex align-items-center justify-content-between mb-0 cursor-pointer" style="border: var(--border-hairline); background-color: #ffffff; border-radius: var(--radius-cards); cursor: pointer;">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" name="payment_method" value="Transfer Bank" class="mr-3" style="width: 18px; height: 18px; accent-color: var(--color-notion-blue);">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">Transfer Bank Manual</div>
                                            <div style="font-size: 12px; color: var(--color-stone);">Rekening Giro Escrow PT TEMPATIN KOS INDONESIA</div>
                                        </div>
                                    </div>
                                    <span style="font-size: 1.25rem; color: var(--color-stone);"><i class="fa fa-university"></i></span>
                                </label>

                                <!-- Method 3: E-Wallet -->
                                <label class="p-3 rounded d-flex align-items-center justify-content-between mb-0 cursor-pointer" style="border: var(--border-hairline); background-color: #ffffff; border-radius: var(--radius-cards); cursor: pointer;">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" name="payment_method" value="E-Wallet" class="mr-3" style="width: 18px; height: 18px; accent-color: var(--color-notion-blue);">
                                        <div>
                                            <div style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">Dompet Digital (E-Wallet)</div>
                                            <div style="font-size: 12px; color: var(--color-stone);">QRIS, GoPay, OVO, ShopeePay, DANA</div>
                                        </div>
                                    </div>
                                    <span style="font-size: 1.25rem; color: var(--color-stone);"><i class="fa fa-wallet"></i></span>
                                </label>

                            </div>

                            <div class="p-3 mb-4 rounded d-flex align-items-center" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13px; color: var(--color-charcoal);">
                                <i class="fa fa-info-circle mr-3" style="font-size: 18px; color: var(--color-charcoal);"></i>
                                <span>Instruksi nomor rekening atau nomor Virtual Account akan diterbitkan setelah konfirmasi dibuat.</span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                                <a href="{{ route('member.booking.create', $kos['slug']) }}" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 10px 18px;">
                                    <i class="fa fa-arrow-left mr-2"></i> Ubah Data
                                </a>
                                <button type="submit" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 14px; padding: 12px 28px; border-radius: var(--radius-buttons); border: none;">
                                    <i class="fa fa-lock mr-2"></i> Konfirmasi Booking Sekarang
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- RIGHT COLUMN: ORDER DETAILS -->
                <div class="col-lg-5">
                    <div style="position: sticky; top: 90px;">
                        <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                            <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">{{ $kos['title'] }}</h3>
                            <p style="font-size: 12px; color: var(--color-stone); margin-bottom: 16px;"><i class="fa fa-map-marker-alt mr-1" style="color: var(--color-stone);"></i> {{ $kos['address'] ?? $kos['city'] }}</p>

                            <div class="p-3 mb-3 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: var(--color-stone);">Penyewa:</span>
                                    <strong style="color: var(--color-midnight-ink);">{{ $booking['tenant_name'] }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: var(--color-stone);">Mulai Sewa:</span>
                                    <strong style="color: var(--color-midnight-ink);">{{ date('d M Y', strtotime($booking['check_in'])) }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span style="color: var(--color-stone);">Durasi Sewa:</span>
                                    <strong style="color: var(--color-midnight-ink);">{{ $booking['duration_label'] }}</strong>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px; color: var(--color-stone);">
                                <span>Subtotal Sewa</span>
                                <span style="color: var(--color-midnight-ink); font-weight: 600;">Rp {{ number_format($booking['subtotal'], 0, ',', '.') }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3" style="font-size: 13.5px; color: var(--color-stone);">
                                <span>Biaya Layanan Admin</span>
                                <span style="color: var(--color-midnight-ink); font-weight: 600;">Rp {{ number_format($booking['admin_fee'], 0, ',', '.') }}</span>
                            </div>

                            <div class="p-3 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0, 0, 0, 0.08);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Total Pembayaran</span>
                                    <span style="font-size: 1.25rem; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums;">
                                        Rp {{ number_format($booking['total'], 0, ',', '.') }}
                                    </span>
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
