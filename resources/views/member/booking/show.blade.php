@extends('layouts.app')

@section('title', 'Detail Booking ' . $booking->booking_code . ' - TEMPATIN')

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
                    <li class="breadcrumb-item"><a href="{{ route('customer.kos.index') }}" style="color: var(--color-stone); text-decoration: none;">Kos Saya</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 500;">Detail Booking</li>
                </ol>
            </nav>
        </div>

        <section class="container mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <span class="badge mb-1 px-2 py-1" style="background-color: var(--surface-page-canvas); color: var(--color-stone); border: var(--border-hairline); font-size: 11px;">KODE TRANSAKSI</span>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">
                        Booking #{{ $booking->booking_code }}
                    </h1>
                </div>
                <div>
                    @php
                        $statusColor = match(strtolower($booking->status)) {
                            'confirmed', 'paid', 'approved', 'success' => 'background-color: #edf7ee; color: #166534; border: 1px solid rgba(22, 101, 52, 0.2);',
                            'pending' => 'background-color: #fef9c3; color: #854d0e; border: 1px solid rgba(133, 77, 14, 0.2);',
                            'cancelled', 'rejected' => 'background-color: #fee2e2; color: #991b1b; border: 1px solid rgba(153, 27, 27, 0.2);',
                            default => 'background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.2);',
                        };
                    @endphp
                    <span class="px-3 py-2 rounded-pill font-weight-bold text-uppercase" style="{{ $statusColor }}; font-size: 12px; letter-spacing: 0.05em;">
                        <i class="fa fa-info-circle mr-1"></i> {{ $booking->status }}
                    </span>
                </div>
            </div>
        </section>

        <section class="container">

            <!-- SUCCESS BANNER -->
            <div class="p-4 mb-4 rounded d-flex align-items-center" style="background-color: #ffffff; border: var(--border-hairline); border-left: 4px solid var(--color-notion-blue); border-radius: var(--radius-cards);">
                <div class="d-inline-flex align-items-center justify-content-center mr-3 rounded-circle" style="width: 44px; height: 44px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); border: 1px solid rgba(0, 117, 222, 0.2); font-size: 1.25rem;">
                    <i class="fa fa-check"></i>
                </div>
                <div>
                    <h3 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">Booking Terdaftar Resmi</h3>
                    <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 0;">
                        Pesanan booking Anda telah tersimpan. Silakan simpan kode booking <strong>{{ $booking->booking_code }}</strong> untuk konfirmasi saat check-in.
                    </p>
                </div>
            </div>

            <div class="row">

                <!-- LEFT COLUMN: DETAIL PENYEWA & PEMBAYARAN -->
                <div class="col-lg-7 mb-4 mb-lg-0">

                    <!-- Data Penyewa Card -->
                    <div class="p-4 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <h2 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 16px; border-bottom: 1px solid rgba(0,0,0,0.06); padding-bottom: 10px;">
                            <i class="fa fa-user mr-2 text-primary"></i> Data Penghuni
                        </h2>

                        <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px;">
                            <span style="color: var(--color-stone);">Nama Lengkap</span>
                            <strong style="color: var(--color-midnight-ink);">{{ $booking->tenant_name }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px;">
                            <span style="color: var(--color-stone);">Nomor WhatsApp</span>
                            <strong style="color: var(--color-midnight-ink);">{{ $booking->tenant_phone }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px;">
                            <span style="color: var(--color-stone);">Email</span>
                            <strong style="color: var(--color-midnight-ink);">{{ $booking->tenant_email }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px;">
                            <span style="color: var(--color-stone);">Tanggal Check-in</span>
                            <strong style="color: var(--color-midnight-ink);">{{ $booking->start_date ? $booking->start_date->format('d M Y') : '-' }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px;">
                            <span style="color: var(--color-stone);">Durasi Sewa</span>
                            <strong style="color: var(--color-midnight-ink);">{{ $booking->duration_months }} Bulan</strong>
                        </div>
                        @if($booking->notes)
                        <div class="p-3 mt-3 rounded" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06); font-size: 13px;">
                            <span style="color: var(--color-stone); font-weight: 600;">Catatan:</span>
                            <span style="color: var(--color-charcoal);">{{ $booking->notes }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Payment Information Card -->
                    <div class="p-4 rounded" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <h2 style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 16px; border-bottom: 1px solid rgba(0,0,0,0.06); padding-bottom: 10px;">
                            <i class="fa fa-receipt mr-2 text-primary"></i> Rincian Tagihan
                        </h2>

                        <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px; color: var(--color-stone);">
                            <span>Subtotal Sewa</span>
                            <span style="color: var(--color-midnight-ink); font-weight: 600;">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3" style="font-size: 13.5px; color: var(--color-stone);">
                            <span>Biaya Layanan Admin</span>
                            <span style="color: var(--color-midnight-ink); font-weight: 600;">Rp {{ number_format($booking->admin_fee, 0, ',', '.') }}</span>
                        </div>

                        <div class="p-3 rounded mb-3" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">Total Biaya</span>
                                <span style="font-size: 1.25rem; font-weight: 700; color: var(--color-notion-blue); font-variant-numeric: tabular-nums;">
                                    Rp {{ number_format($booking->total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center" style="font-size: 13px; color: var(--color-stone);">
                            <span>Metode Pembayaran</span>
                            <span style="font-weight: 600; color: var(--color-midnight-ink);">{{ $booking->payment_method ?? 'Transfer Bank' }}</span>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: KOS PROPERTY & CONTACT -->
                <div class="col-lg-5">
                    <div style="position: sticky; top: 90px;">

                        @if($booking->kos)
                        <div class="p-4 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <img src="{{ asset($booking->kos->thumbnail) }}" alt="{{ $booking->kos->title }}" class="w-100 rounded mb-3" style="height: 180px; object-fit: cover; border: var(--border-hairline);">
                            <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">{{ $booking->kos->title }}</h3>
                            <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 16px;"><i class="fa fa-map-marker-alt mr-1" style="color: var(--color-stone);"></i> {{ $booking->kos->address ?? $booking->kos->city }}</p>
                            <a href="{{ route('member.kos.show', $booking->kos->slug) }}" class="btn btn-block" style="background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-weight: 600; font-size: 13px; padding: 10px; border-radius: var(--radius-buttons); text-align: center;">
                                Lihat Profil Kos Lengkap
                            </a>
                        </div>
                        @endif

                        <div class="p-4 rounded text-center" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width: 44px; height: 44px; background-color: var(--surface-page-canvas); color: var(--color-midnight-ink); border: var(--border-hairline); font-size: 18px;">
                                <i class="fa fa-file-invoice"></i>
                            </div>
                            <h4 style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 6px;">Butuh Bukti Invoice?</h4>
                            <p style="font-size: 12.5px; color: var(--color-stone); margin-bottom: 16px;">Invoice resmi diterbitkan di pusat tagihan akun kamu.</p>
                            <a href="{{ route('member.invoice.index') }}" class="btn btn-block" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 600; font-size: 13px; padding: 10px; border-radius: var(--radius-buttons); border: none;">
                                Buka Tagihan & Invoice
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </section>

    </main>

    @include('partials.footer')

</div>
@endsection
