@extends('layouts.owner')

@section('title', 'Detail Booking ' . $booking->booking_code . ' - TEMPATIN')

@section('owner-content')
<div class="container">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            @include('partials.owner-sidebar')
        </div>

        <!-- MAIN CONTENT -->
        <div class="col-lg-9">

            <!-- BREADCRUMB -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 13px;">
                    <li class="breadcrumb-item"><a href="{{ route('owner.dashboard') }}" style="color: var(--color-stone); text-decoration: none;">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('owner.bookings.index') }}" style="color: var(--color-stone); text-decoration: none;">Booking Masuk</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: var(--color-ink-black); font-weight: 600;">{{ $booking->booking_code }}</li>
                </ol>
            </nav>

            <!-- HEADER -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span style="font-family: monospace; font-size: 14px; font-weight: 700; color: var(--color-notion-blue);">
                            {{ $booking->booking_code }}
                        </span>
                        @php
                            $badgeBg = match($booking->status) {
                                'pending' => '#fef3c7',
                                'approved' => 'var(--color-sky-tint)',
                                'confirmed' => '#dcfce7',
                                'active' => 'var(--color-midnight-ink)',
                                'completed' => '#e0e7ff',
                                'rejected', 'cancelled' => '#fee2e2',
                                default => '#f3f4f6',
                            };
                            $badgeColor = match($booking->status) {
                                'pending' => '#92400e',
                                'approved' => 'var(--color-notion-blue)',
                                'confirmed' => '#166534',
                                'active' => '#ffffff',
                                'completed' => '#3730a3',
                                'rejected', 'cancelled' => '#991b1b',
                                default => '#374151',
                            };
                        @endphp
                        <span class="px-2 py-1 rounded" style="background-color: {{ $badgeBg }}; color: {{ $badgeColor }}; font-size: 11.5px; font-weight: 600;">
                            {{ $booking->status_label }}
                        </span>
                    </div>
                    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
                        Detail Pengajuan Sewa
                    </h1>
                    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
                        Diajukan pada {{ $booking->created_at->translatedFormat('d F Y, H:i') }} WIB
                    </p>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="d-flex flex-wrap gap-2">
                    @if($booking->status === 'pending')
                        <button type="button" class="btn" data-toggle="modal" data-target="#approveModal" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 700; font-size: 13.5px; padding: 10px 20px; border-radius: var(--radius-buttons); border: none; box-shadow: 0 2px 8px rgba(0, 117, 222, 0.25);">
                            <i class="fa fa-check-circle mr-1"></i> Setujui Booking
                        </button>
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#rejectModal" style="font-weight: 600; font-size: 13.5px; padding: 10px 18px; border-radius: var(--radius-buttons);">
                            <i class="fa fa-times-circle mr-1"></i> Tolak
                        </button>
                    @elseif($booking->status === 'approved')
                        <div class="p-2 px-3 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 13px; font-weight: 600; border: 1px solid rgba(0, 117, 222, 0.2);">
                            <i class="fa fa-info-circle mr-1"></i> Menunggu Penyewa Menyelesaikan Pembayaran
                        </div>
                    @elseif($booking->status === 'confirmed')
                        <form action="{{ route('owner.bookings.checkin', $booking->booking_code) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa penyewa sudah datang dan melakukan check-in?');">
                            @csrf
                            <button type="submit" class="btn" style="background-color: var(--color-midnight-ink); color: #ffffff; font-weight: 700; font-size: 13.5px; padding: 10px 20px; border-radius: var(--radius-buttons); border: none;">
                                <i class="fa fa-key mr-1"></i> Proses Check-in
                            </button>
                        </form>
                    @elseif($booking->status === 'active')
                        <form action="{{ route('owner.bookings.checkout', $booking->booking_code) }}" method="POST" onsubmit="return confirm('Konfirmasi penyelesaian masa sewa dan check-out kamar?');">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary" style="font-weight: 600; font-size: 13.5px; padding: 10px 18px; border-radius: var(--radius-buttons);">
                                <i class="fa fa-door-open mr-1"></i> Proses Check-out
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- REJECTION REASON CALLOUT IF REJECTED -->
            @if($booking->status === 'rejected' && $booking->rejection_reason)
                <div class="p-3 mb-4 rounded" style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; font-size: 13.5px;">
                    <div class="font-weight-bold mb-1"><i class="fa fa-info-circle mr-1"></i> Alasan Penolakan Booking:</div>
                    <div>{{ $booking->rejection_reason }}</div>
                </div>
            @endif

            <div class="row">
                <!-- LEFT COLUMN: PROPERTI & RINCIAN SEWA -->
                <div class="col-lg-7 mb-4">
                    <!-- KOS INFO CARD -->
                    <div class="p-4 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; color: var(--color-stone); margin-bottom: 12px;">
                            PROPERTI YANG DIPESAN
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{ asset($booking->kos->thumbnail) }}" alt="{{ $booking->kos->title }}" style="width: 72px; height: 72px; object-fit: cover; border-radius: 8px; border: var(--border-hairline);">
                            <div>
                                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 2px;">
                                    {{ $booking->kos->title }}
                                </h3>
                                <div style="font-size: 13px; color: var(--color-stone);">
                                    <i class="fa fa-map-marker-alt mr-1 text-primary"></i> {{ $booking->kos->city }} &bull; Kos {{ $booking->kos->type }}
                                </div>
                            </div>
                        </div>

                        <div class="row pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                            <div class="col-6 mb-2">
                                <div style="font-size: 12px; color: var(--color-stone);">Nomor Kamar</div>
                                <div style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">
                                    {{ $booking->room ? 'Kamar ' . $booking->room->room_number : 'Belum Ditentukan' }}
                                </div>
                            </div>
                            <div class="col-6 mb-2">
                                <div style="font-size: 12px; color: var(--color-stone);">Durasi Sewa</div>
                                <div style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">
                                    {{ $booking->duration_months }} Bulan
                                </div>
                            </div>
                            <div class="col-6">
                                <div style="font-size: 12px; color: var(--color-stone);">Tanggal Masuk (Check-in)</div>
                                <div style="font-size: 13.5px; font-weight: 600; color: var(--color-midnight-ink);">
                                    {{ $booking->start_date ? $booking->start_date->format('d M Y') : '-' }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div style="font-size: 12px; color: var(--color-stone);">Perkiraan Berakhir</div>
                                <div style="font-size: 13.5px; font-weight: 600; color: var(--color-midnight-ink);">
                                    {{ $booking->end_date ? $booking->end_date->format('d M Y') : '-' }}
                                </div>
                            </div>
                        </div>

                        @if($booking->notes)
                            <div class="mt-3 pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important;">
                                <div style="font-size: 12px; color: var(--color-stone); margin-bottom: 2px;">Catatan Tambahan Penyewa:</div>
                                <div style="font-size: 13px; color: var(--color-charcoal); font-style: italic;">
                                    "{{ $booking->notes }}"
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- PENYEWA DATA CARD -->
                    <div class="p-4 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; color: var(--color-stone); margin-bottom: 12px;">
                            IDENTITAS CALON PENYEWA
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle mr-3" style="width: 44px; height: 44px; background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-weight: 700; font-size: 16px;">
                                {{ strtoupper(substr($booking->tenant_name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size: 15px; font-weight: 700; color: var(--color-midnight-ink);">
                                    {{ $booking->tenant_name }}
                                </div>
                                <div style="font-size: 12.5px; color: var(--color-stone);">
                                    Akun Terverifikasi TEMPATIN
                                </div>
                            </div>
                        </div>

                        <div class="row pt-2" style="font-size: 13.5px;">
                            <div class="col-sm-6 mb-2">
                                <div style="font-size: 11.5px; color: var(--color-stone);">Nomor Telepon / WhatsApp</div>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->tenant_phone) }}" target="_blank" style="color: #059669; font-weight: 600; text-decoration: none;">
                                    <i class="fab fa-whatsapp mr-1"></i> {{ $booking->tenant_phone }}
                                </a>
                            </div>
                            <div class="col-sm-6 mb-2">
                                <div style="font-size: 11.5px; color: var(--color-stone);">Email Penyewa</div>
                                <div style="color: var(--color-charcoal); font-weight: 500;">
                                    {{ $booking->tenant_email }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: KEUANGAN & PEMBAYARAN -->
                <div class="col-lg-5">
                    <!-- RINCIAN FINANSIAL CARD -->
                    <div class="p-4 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div style="font-size: 12px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.05em; color: var(--color-stone); margin-bottom: 14px;">
                            RINCIAN PEMBAYARAN
                        </div>

                        <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px; color: var(--color-charcoal);">
                            <span>Sewa Bulanan (x{{ $booking->duration_months }})</span>
                            <span style="font-weight: 600;">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2" style="font-size: 13.5px; color: var(--color-charcoal);">
                            <span>Biaya Layanan &amp; Admin</span>
                            <span style="font-weight: 600;">Rp {{ number_format($booking->admin_fee, 0, ',', '.') }}</span>
                        </div>

                        <div class="pt-3 mt-3 border-top d-flex justify-content-between align-items-center" style="border-color: rgba(0,0,0,0.06) !important;">
                            <span style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">Total Transaksi</span>
                            <span style="font-size: 1.3rem; font-weight: 800; color: var(--color-notion-blue); font-variant-numeric: tabular-nums;">
                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- INVOICE & MIDTRANS STATUS -->
                        <div class="mt-4 pt-3 border-top" style="border-color: rgba(0,0,0,0.06) !important; font-size: 12.5px;">
                            <div class="d-flex justify-content-between mb-1">
                                <span style="color: var(--color-stone);">Nomor Invoice:</span>
                                <span style="font-family: monospace; font-weight: 600; color: var(--color-midnight-ink);">
                                    {{ $booking->invoice->invoice_number ?? '-' }}
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span style="color: var(--color-stone);">Status Tagihan:</span>
                                <span style="font-weight: 600; color: {{ ($booking->invoice && $booking->invoice->status === 'paid') ? '#059669' : '#d97706' }};">
                                    {{ $booking->invoice ? $booking->invoice->status_label : 'Belum Terbit' }}
                                </span>
                            </div>
                            @if($booking->invoice && $booking->invoice->payments->isNotEmpty())
                                @php $latestPay = $booking->invoice->payments->last(); @endphp
                                <div class="d-flex justify-content-between mb-1">
                                    <span style="color: var(--color-stone);">Kanal Pembayaran:</span>
                                    <span style="font-weight: 600; color: var(--color-midnight-ink);">
                                        {{ $latestPay->payment_channel ?? $latestPay->payment_method }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- KONTRAK SEWA STATUS -->
                    <div class="p-3 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: var(--color-stone);">KONTRAK DIGITAL</div>
                                <div style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">
                                    {{ $booking->contract ? $booking->contract->contract_number : 'Dokumen Perjanjian' }}
                                </div>
                            </div>
                            @if($booking->contract && $booking->contract->isSigned())
                                <span class="badge" style="background-color: #dcfce7; color: #166534; font-size: 11px;">
                                    Disepakati
                                </span>
                            @else
                                <span class="badge" style="background-color: #fef3c7; color: #92400e; font-size: 11px;">
                                    Draf / Belum TTD
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('contracts.forBooking', $booking->booking_code) }}" class="btn btn-sm btn-outline-primary btn-block font-weight-600" style="border-radius: 8px;">
                            <i class="fa fa-file-contract mr-1"></i> Buka Dokumen Kontrak
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- MODAL APPROVE BOOKING -->
@if($booking->status === 'pending')
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: var(--radius-cards); border: var(--border-hairline);">
            <form action="{{ route('owner.bookings.approve', $booking->booking_code) }}" method="POST">
                @csrf
                <div class="modal-header" style="border-bottom: var(--border-hairline);">
                    <h5 class="modal-title font-weight-bold" id="approveModalLabel" style="color: var(--color-midnight-ink); font-size: 1.15rem;">
                        Persetujuan Booking Calon Penyewa
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 14px;">
                    <p style="color: var(--color-stone); margin-bottom: 16px;">
                        Dengan menyetujui pengajuan ini, status pesanan akan menjadi <strong>Disetujui</strong> dan calon penyewa akan menerima notifikasi untuk melanjutkan pembayaran melalui Midtrans.
                    </p>

                    @if($availableRooms->isNotEmpty())
                        <div class="form-group mb-3">
                            <label class="font-weight-bold" style="font-size: 13px; color: var(--color-midnight-ink);">
                                Tetapkan Nomor Kamar (Opsional)
                            </label>
                            <select name="room_id" class="form-control" style="font-size: 13.5px; border-radius: var(--radius-inputs);">
                                <option value="">-- Tentukan Nanti Saat Check-in --</option>
                                @foreach($availableRooms as $rm)
                                    <option value="{{ $rm->id }}">Kamar {{ $rm->room_number }} (Lt. {{ $rm->floor ?? '1' }}) - Rp {{ number_format($rm->effective_price, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Kamar yang dipilih akan disiapkan untuk calon penyewa ini.</small>
                        </div>
                    @endif
                </div>
                <div class="modal-footer" style="border-top: var(--border-hairline);">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="font-size: 13px;">Batal</button>
                    <button type="submit" class="btn" style="background-color: var(--color-notion-blue); color: #ffffff; font-weight: 700; font-size: 13px; border-radius: var(--radius-buttons); border: none;">
                        Konfirmasi &amp; Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL REJECT BOOKING -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: var(--radius-cards); border: var(--border-hairline);">
            <form action="{{ route('owner.bookings.reject', $booking->booking_code) }}" method="POST">
                @csrf
                <div class="modal-header" style="border-bottom: var(--border-hairline);">
                    <h5 class="modal-title font-weight-bold" id="rejectModalLabel" style="color: #991b1b; font-size: 1.15rem;">
                        Tolak Pengajuan Booking
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 14px;">
                    <p style="color: var(--color-stone); margin-bottom: 14px;">
                        Mohon berikan alasan penolakan secara jelas. Alasan ini akan dikirimkan kepada calon penyewa.
                    </p>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold" style="font-size: 13px; color: var(--color-midnight-ink);">
                            Alasan Penolakan <span class="text-danger">*</span>
                        </label>
                        <textarea name="rejection_reason" class="form-control" rows="3" placeholder="Contoh: Kamar sudah terisi penuh offline / jadwal sewa belum sesuai ketersediaan." required minlength="3" maxlength="500" style="font-size: 13.5px; border-radius: var(--radius-inputs);"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: var(--border-hairline);">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="font-size: 13px;">Batal</button>
                    <button type="submit" class="btn btn-danger" style="font-weight: 700; font-size: 13px; border-radius: var(--radius-buttons);">
                        Tolak Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
