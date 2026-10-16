<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Nota Pembayaran - {{ $booking->booking_code }}</title>
    <style>
        @page {
            margin: 28px 32px;
            size: a4 portrait;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11.5px;
            line-height: 1.45;
            color: #000000;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table {
            margin-bottom: 18px;
            border-bottom: 2px solid #000000;
            padding-bottom: 14px;
        }
        .brand-title {
            font-size: 24px;
            font-weight: 800;
            color: #000000;
            letter-spacing: -0.5px;
            margin: 0;
        }
        .brand-subtitle {
            font-size: 10px;
            color: #444444;
            margin-top: 3px;
        }
        .doc-title {
            text-align: right;
            font-size: 18px;
            font-weight: 800;
            color: #000000;
            margin: 0;
            text-transform: uppercase;
        }
        .doc-invoice-number {
            font-size: 11px;
            font-weight: 700;
            color: #222222;
            margin-top: 2px;
        }
        .badge-lunas {
            display: inline-block;
            background-color: #ffffff;
            color: #000000;
            border: 1.5px solid #000000;
            padding: 3px 10px;
            border-radius: 3px;
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }
        .section-box {
            background-color: #ffffff;
            border: 1px solid #000000;
            border-radius: 4px;
            padding: 10px 12px;
            margin-bottom: 14px;
        }
        .section-title {
            font-size: 10.5px;
            font-weight: 800;
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            border-bottom: 1px solid #000000;
            padding-bottom: 4px;
        }
        .info-table td {
            padding: 2.5px 0;
            vertical-align: top;
        }
        .info-label {
            color: #444444;
            width: 32%;
        }
        .info-val {
            color: #000000;
            font-weight: 700;
            width: 68%;
        }
        .items-table {
            width: 100%;
            margin-top: 8px;
            margin-bottom: 14px;
            border: 1px solid #000000;
            border-collapse: collapse;
        }
        .items-table th {
            background-color: #f2f2f2;
            color: #000000;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 8px 10px;
            border: 1px solid #000000;
            text-align: left;
        }
        .items-table td {
            padding: 8px 10px;
            border: 1px solid #000000;
            font-size: 11px;
            color: #000000;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-box {
            background-color: #ffffff;
            border: 2px solid #000000;
            border-radius: 4px;
            padding: 10px 14px;
            margin-bottom: 16px;
        }
        .total-label {
            font-size: 13px;
            font-weight: 800;
            color: #000000;
        }
        .total-amount {
            font-size: 18px;
            font-weight: 800;
            color: #000000;
            text-align: right;
        }
        .notice-box {
            background-color: #ffffff;
            border: 1px dashed #000000;
            border-radius: 4px;
            padding: 10px 12px;
            font-size: 10px;
            color: #222222;
            line-height: 1.5;
            margin-bottom: 14px;
        }
        .footer-table {
            margin-top: 20px;
            border-top: 1px solid #000000;
            padding-top: 8px;
            font-size: 9.5px;
            color: #444444;
        }
    </style>
</head>
<body>

    <!-- HEADER / BRANDING -->
    <table class="header-table">
        <tr>
            <td style="width: 55%; vertical-align: middle;">
                <h1 class="brand-title">TEMPATIN</h1>
                <div class="brand-subtitle">Platform Terpercaya Sewa Kos & Hunian Mahasiswa Indonesia</div>
                <div style="font-size: 9.5px; color: #444444; margin-top: 2px;">
                    Jl. Raya Sidoarjo No. 17, Jawa Timur | hello@tempatin.id
                </div>
            </td>
            <td style="width: 45%; vertical-align: middle; text-align: right;">
                <h2 class="doc-title">Nota Pembayaran</h2>
                <div class="doc-invoice-number">
                    {{ $invoice->invoice_number ?? ('INV/' . date('Y/m') . '/' . str_pad($booking->id, 5, '0', STR_PAD_LEFT)) }}
                </div>
                <div class="badge-lunas">
                    LUNAS / VERIFIED PAID
                </div>
            </td>
        </tr>
    </table>

    <!-- TRANSACTION META HIGHLIGHT -->
    <table style="margin-bottom: 14px;">
        <tr>
            <td style="width: 50%; padding-right: 6px;">
                <div class="section-box" style="margin-bottom: 0;">
                    <div class="section-title">Data Penyewa</div>
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Nama Lengkap</td>
                            <td class="info-val">: {{ $booking->tenant_name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">WhatsApp</td>
                            <td class="info-val">: {{ $booking->tenant_phone }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Email</td>
                            <td class="info-val">: {{ $booking->tenant_email }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">ID Customer</td>
                            <td class="info-val">: CST-{{ str_pad($booking->customer_id, 4, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                    </table>
                </div>
            </td>
            <td style="width: 50%; padding-left: 6px;">
                <div class="section-box" style="margin-bottom: 0;">
                    <div class="section-title">Informasi Transaksi</div>
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Kode Booking</td>
                            <td class="info-val">: {{ $booking->booking_code }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Waktu Bayar</td>
                            <td class="info-val">: {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') . ' WIB' : now()->format('d M Y, H:i') . ' WIB' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Metode Bayar</td>
                            <td class="info-val">: {{ $payment->payment_channel ?? ($payment->payment_method ? strtoupper(str_replace('_', ' ', $payment->payment_method)) : 'Midtrans Payment') }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Order ID</td>
                            <td class="info-val">: {{ $payment->order_id ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <!-- PROPERTY & LEASE DETAILS -->
    <div class="section-box">
        <div class="section-title">Rincian Properti & Sewa Kos</div>
        <table>
            <tr>
                <td style="width: 50%; vertical-align: top; padding-right: 10px;">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Nama Kos</td>
                            <td class="info-val">: {{ $booking->kos->title ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Tipe Kos</td>
                            <td class="info-val">: Kos {{ $booking->kos->type ?? 'Campur' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Alamat Kos</td>
                            <td class="info-val">: {{ $booking->kos->address ?? '-' }}, {{ $booking->kos->city ?? '' }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%; vertical-align: top; padding-left: 10px;">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Pemilik Kos</td>
                            <td class="info-val">: {{ $booking->kos->owner->name ?? 'Mitra Pemilik Kos' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Tanggal Check-in</td>
                            <td class="info-val">: {{ $booking->start_date ? $booking->start_date->format('d M Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Periode Sewa</td>
                            <td class="info-val">: {{ $booking->duration_months }} Bulan (s/d {{ $booking->end_date ? $booking->end_date->format('d M Y') : '-' }})</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- TABLE ITEMS / BILLING -->
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 47%;">Deskripsi Pembayaran</th>
                <th style="width: 16%; text-align: center;">Durasi</th>
                <th style="width: 16%; text-align: right;">Tarif Satuan</th>
                <th style="width: 16%; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>
                    <strong>Sewa Kamar - {{ $booking->kos->title ?? 'Kamar Kos' }}</strong><br>
                    <span style="font-size: 9.5px; color: #444444;">Periode sewa kamar kos aktif sesuai perjanjian sewa elektronik TEMPATIN</span>
                </td>
                <td class="text-center">{{ $booking->duration_months }} Bulan</td>
                <td class="text-right">Rp {{ number_format($booking->kos_price, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($booking->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>
                    <strong>Biaya Layanan & Administrasi</strong><br>
                    <span style="font-size: 9.5px; color: #444444;">Biaya pemeliharaan sistem & jaminan perlindungan transaksi Midtrans Escrow</span>
                </td>
                <td class="text-center">1 Transaksi</td>
                <td class="text-right">Rp {{ number_format($booking->admin_fee, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($booking->admin_fee, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- TOTAL BOX -->
    <div class="total-box">
        <table>
            <tr>
                <td class="total-label" style="width: 55%; vertical-align: middle;">
                    TOTAL PEMBAYARAN LUNAS
                </td>
                <td class="total-amount" style="width: 45%; vertical-align: middle;">
                    Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <!-- SECURITY NOTICE & TERMS -->
    <div class="notice-box">
        <strong>Ketentuan & Bukti Sah:</strong>
        <ul style="margin: 4px 0 0 16px; padding: 0;">
            <li>Nota ini merupakan bukti pembayaran resmi yang sah diterbitkan secara elektronik oleh platform TEMPATIN melalui Midtrans Payment Gateway.</li>
            <li>Tunjukkan dokumen nota ini kepada pemilik kos pada saat kedatangan / serah terima kunci kamar kos.</li>
            <li>Dana sewa diamankan oleh Midtrans Escrow Guarantee sampai Anda resmi menempati kamar.</li>
        </ul>
    </div>

    <!-- FOOTER STAMP -->
    <table class="footer-table">
        <tr>
            <td style="width: 70%; vertical-align: middle;">
                Dicetak secara elektronik pada {{ now()->format('d F Y, H:i') }} WIB &bull; TEMPATIN ID Transaksi: #{{ $booking->booking_code }}
            </td>
            <td style="width: 30%; vertical-align: middle; text-align: right;">
                <strong style="color: #000000;">TEMPATIN &bull; Verified Payment</strong>
            </td>
        </tr>
    </table>

</body>
</html>
