@extends('layouts.app')

@section('title', 'Pembayaran Booking - TEMPATIN')

@section('content')
<div class="ts-page-wrapper" id="page-top" style="background-color: var(--surface-page-canvas); min-height: 100vh;">

    @include('partials.navbar')
    @include('partials.alert')

    @php
        $tenantName = is_array($booking) ? ($booking['tenant_name'] ?? '') : ($booking->tenant_name ?? '');
        $checkInRaw = is_array($booking) ? ($booking['check_in'] ?? ($booking['start_date'] ?? '')) : ($booking->start_date ? $booking->start_date->format('Y-m-d') : '');
        $checkInLabel = $checkInRaw ? date('d M Y', strtotime($checkInRaw)) : '-';
        $durationMonths = is_array($booking) ? ($booking['duration'] ?? ($booking['duration_months'] ?? 1)) : ($booking->duration_months ?? 1);
        $subtotal = is_array($booking) ? ($booking['subtotal'] ?? 0) : ($booking->subtotal ?? 0);
        $adminFee = is_array($booking) ? ($booking['admin_fee'] ?? 25000) : ($booking->admin_fee ?? 25000);
        $totalAmount = is_array($booking) ? ($booking['total'] ?? ($booking['total_amount'] ?? ($subtotal + $adminFee))) : ($booking->total_amount ?? ($subtotal + $adminFee));
        $bookingCode = is_array($booking) ? ($booking['booking_code'] ?? '') : ($booking->booking_code ?? '');
        $kosSlug = is_array($kos) ? ($kos['slug'] ?? '') : ($kos->slug ?? '');
        $kosTitle = is_array($kos) ? ($kos['title'] ?? '') : ($kos->title ?? '');
        $kosAddress = is_array($kos) ? ($kos['address'] ?? ($kos['city'] ?? '')) : ($kos->address ?? ($kos->city ?? ''));
        $clientKey = $clientKey ?? (config('services.midtrans.client_key') ?: config('midtrans.client_key'));
        $isProduction = config('services.midtrans.is_production') ?? config('midtrans.is_production', false);
        $snapJsUrl = $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp

    <main id="ts-main" style="padding-top: 20px; padding-bottom: 80px;">

        <!-- BREADCRUMB -->
        <div class="container mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('member.home') }}" style="color: var(--color-stone); text-decoration: none;">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('member.booking.create', $kosSlug) }}" style="color: var(--color-stone); text-decoration: none;">Booking</a></li>
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
                <div class="d-inline-flex align-items-center px-3 py-1 rounded-pill" style="background-color: var(--color-sky-tint); color: var(--color-ink-black); font-size: 13px; font-weight: 600; border: 1px solid rgba(0, 117, 222, 0.2);">
                    <span class="mr-2" style="width: 20px; height: 20px; border-radius: 50%; background-color: var(--color-notion-blue); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 11px;">2</span>
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

                <!-- LEFT COLUMN: PAYMENT METHOD & MIDTRANS SNAP -->
                <div class="col-lg-7 mb-4 mb-lg-0">
                    <div class="p-4 p-md-5 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h2 style="font-family: var(--font-serif); font-size: 1.5rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
                                Pembayaran Midtrans Snap
                            </h2>
                            <span class="badge px-2 py-1" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.2); font-size: 11px; font-weight: 700;">
                                SANDBOX MODE
                            </span>
                        </div>
                        
                        <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 24px;">
                            Selesaikan transaksi aman Anda secara instan dengan kanal pembayaran Midtrans.
                        </p>

                        <!-- Notification / Status Banner -->
                        <div id="payment-status-box" class="d-none p-3 mb-4 rounded" style="font-size: 13.5px;"></div>

                        <!-- Midtrans Channel Cards Info -->
                        <div class="d-flex flex-column gap-3 mb-4">

                            <!-- Channel 1: Virtual Account -->
                            <div class="p-3 rounded d-flex align-items-center justify-content-between mb-0" style="border: 2px solid var(--color-notion-blue); background-color: var(--color-sky-tint); border-radius: var(--radius-cards);">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 text-center" style="width: 32px; font-size: 1.4rem; color: var(--color-notion-blue);">
                                        <i class="fa fa-university"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">Virtual Account Otomatis</div>
                                        <div style="font-size: 12px; color: var(--color-stone);">BCA, Mandiri, BRI, BNI, Permata (Verifikasi Instan)</div>
                                    </div>
                                </div>
                                <span class="badge" style="background-color: #ffffff; color: var(--color-notion-blue); border: var(--border-hairline); font-size: 11px;">Tersedia</span>
                            </div>

                            <!-- Channel 2: QRIS & E-Wallet -->
                            <div class="p-3 rounded d-flex align-items-center justify-content-between mb-0" style="border: var(--border-hairline); background-color: #ffffff; border-radius: var(--radius-cards);">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 text-center" style="width: 32px; font-size: 1.4rem; color: var(--color-charcoal);">
                                        <i class="fa fa-qrcode"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">QRIS & Dompet Digital</div>
                                        <div style="font-size: 12px; color: var(--color-stone);">GoPay, ShopeePay, QRIS Nasional</div>
                                    </div>
                                </div>
                                <span class="badge" style="background-color: var(--surface-page-canvas); color: var(--color-stone); border: var(--border-hairline); font-size: 11px;">Tersedia</span>
                            </div>

                            <!-- Channel 3: Kartu Kredit & Debit -->
                            <div class="p-3 rounded d-flex align-items-center justify-content-between mb-0" style="border: var(--border-hairline); background-color: #ffffff; border-radius: var(--radius-cards);">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 text-center" style="width: 32px; font-size: 1.4rem; color: var(--color-charcoal);">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <div>
                                        <div style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">Kartu Kredit / Debit Online</div>
                                        <div style="font-size: 12px; color: var(--color-stone);">Visa, MasterCard, JCB dengan 3D Secure</div>
                                    </div>
                                </div>
                                <span class="badge" style="background-color: var(--surface-page-canvas); color: var(--color-stone); border: var(--border-hairline); font-size: 11px;">Tersedia</span>
                            </div>

                        </div>

                        <!-- Midtrans Escrow Notice -->
                        <div class="p-3 mb-4 rounded d-flex align-items-center" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13px; color: var(--color-charcoal);">
                            <i class="fa fa-shield-alt mr-3 text-primary" style="font-size: 20px;"></i>
                            <span>
                                Transaksi diamankan oleh enkripsi Midtrans Escrow. Dana hanya akan diteruskan ke pemilik kos setelah masa check-in terkonfirmasi.
                            </span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                            <a href="{{ route('member.booking.create', $kosSlug) }}" class="btn" style="background-color: var(--surface-page-canvas); color: var(--color-charcoal); border: var(--border-hairline); font-weight: 600; font-size: 13px; border-radius: var(--radius-buttons); padding: 10px 18px;">
                                <i class="fa fa-arrow-left mr-2"></i> Ubah Data
                            </a>

                            <div class="d-flex flex-column align-items-end">
                                <button type="button" id="pay-button" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 700; font-size: 14px; padding: 12px 28px; border-radius: var(--radius-buttons); border: none; box-shadow: 0 4px 14px rgba(0, 117, 222, 0.28);">
                                    <i class="fa fa-lock mr-2"></i> Bayar Sekarang (Midtrans)
                                </button>
                                
                                @if(!empty($redirectUrl))
                                <a href="{{ $redirectUrl }}" target="_blank" class="mt-2 text-muted" style="font-size: 11.5px; text-decoration: underline;">
                                    Gunakan Snap Redirect <i class="fa fa-external-link-alt ml-1"></i>
                                </a>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

                <!-- RIGHT COLUMN: ORDER DETAILS -->
                <div class="col-lg-5">
                    <div style="position: sticky; top: 90px;">
                        <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">

                            <span class="badge mb-2 px-2 py-1" style="background-color: var(--surface-page-canvas); color: var(--color-stone); border: var(--border-hairline); font-size: 10.5px;">KODE BOOKING</span>
                            <div style="font-family: monospace; font-weight: 800; font-size: 14px; color: var(--color-notion-blue); margin-bottom: 12px;">
                                {{ $bookingCode ?: 'DRAFT-BOOKING' }}
                            </div>

                            <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">{{ $kosTitle }}</h3>
                            <p style="font-size: 12px; color: var(--color-stone); margin-bottom: 16px;"><i class="fa fa-map-marker-alt mr-1" style="color: var(--color-stone);"></i> {{ $kosAddress }}</p>

                            <div class="p-3 mb-3 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: var(--color-stone);">Penyewa:</span>
                                    <strong style="color: var(--color-midnight-ink);">{{ $tenantName }}</strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: var(--color-stone);">Mulai Sewa:</span>
                                    <strong style="color: var(--color-midnight-ink);">{{ $checkInLabel }}</strong>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span style="color: var(--color-stone);">Durasi Sewa:</span>
                                    <strong style="color: var(--color-midnight-ink);">{{ $durationMonths }} Bulan</strong>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px; color: var(--color-stone);">
                                <span>Subtotal Sewa</span>
                                <span style="color: var(--color-midnight-ink); font-weight: 600;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3" style="font-size: 13.5px; color: var(--color-stone);">
                                <span>Biaya Layanan Admin</span>
                                <span style="color: var(--color-midnight-ink); font-weight: 600;">Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                            </div>

                            <div class="p-3 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0, 0, 0, 0.08);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Total Pembayaran</span>
                                    <span style="font-size: 1.25rem; font-weight: 700; color: var(--color-notion-blue); font-variant-numeric: tabular-nums;">
                                        Rp {{ number_format($totalAmount, 0, ',', '.') }}
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

@push('scripts')
<script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('pay-button');
        const statusBox = document.getElementById('payment-status-box');
        const snapToken = @json($snapToken ?? null);
        const bookingShowUrl = @json($bookingCode ? route('member.booking.show', $bookingCode) : route('member.invoice.index'));

        function showStatus(message, type) {
            statusBox.className = 'p-3 mb-4 rounded';
            if (type === 'success') {
                statusBox.style.backgroundColor = 'var(--color-sky-tint)';
                statusBox.style.border = '1px solid rgba(0, 117, 222, 0.3)';
                statusBox.style.color = 'var(--color-ink-black)';
                statusBox.innerHTML = '<i class="fa fa-check-circle mr-2 text-primary"></i> ' + message;
            } else if (type === 'warning') {
                statusBox.style.backgroundColor = '#fffbeb';
                statusBox.style.border = '1px solid #fde68a';
                statusBox.style.color = '#92400e';
                statusBox.innerHTML = '<i class="fa fa-clock mr-2 text-warning"></i> ' + message;
            } else {
                statusBox.style.backgroundColor = '#fef2f2';
                statusBox.style.border = '1px solid #fecaca';
                statusBox.style.color = '#991b1b';
                statusBox.innerHTML = '<i class="fa fa-exclamation-circle mr-2 text-danger"></i> ' + message;
            }
            statusBox.classList.remove('d-none');
        }

        if (!payButton) return;

        payButton.addEventListener('click', function () {
            if (!snapToken) {
                showStatus('Snap token Midtrans belum tersedia. Silakan muat ulang halaman atau hubungi layanan bantuan.', 'danger');
                return;
            }

            payButton.disabled = true;
            payButton.innerHTML = '<i class="fa fa-spinner fa-spin mr-2"></i> Membuka Gerbang Pembayaran...';

            window.snap.pay(snapToken, {
                onSuccess: function (result) {
                    showStatus('Pembayaran berhasil! Mengarahkan Anda ke rincian pesanan...', 'success');
                    setTimeout(function () {
                        window.location.href = bookingShowUrl + '?payment_status=success';
                    }, 1200);
                },
                onPending: function (result) {
                    showStatus('Pembayaran menunggu verifikasi. Silakan selesaikan pembayaran sesuai petunjuk.', 'warning');
                    setTimeout(function () {
                        window.location.href = bookingShowUrl + '?payment_status=pending';
                    }, 1500);
                },
                onError: function (result) {
                    showStatus('Pembayaran gagal diproses oleh gerbang pembayaran. Silakan coba kembali.', 'danger');
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fa fa-lock mr-2"></i> Coba Bayar Lagi';
                },
                onClose: function () {
                    showStatus('Jendela pembayaran ditutup sebelum transaksi diselesaikan. Anda dapat menekan tombol kembali untuk melanjutkan.', 'warning');
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fa fa-lock mr-2"></i> Bayar Sekarang (Midtrans)';
                }
            });
        });
    });
</script>
@endpush
@endsection
