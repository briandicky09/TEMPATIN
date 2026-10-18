<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kontrak Sewa {{ $contract->contract_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1f2937;
            font-size: 12px;
            line-height: 1.6;
            margin: 25px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0075de;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 16px;
            text-transform: uppercase;
            margin: 0 0 4px 0;
            color: #02093a;
        }
        .header p {
            margin: 0;
            color: #6b7280;
            font-size: 11px;
        }
        .meta-box {
            margin-bottom: 20px;
            font-size: 11.5px;
        }
        .meta-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .meta-box td {
            padding: 4px 6px;
        }
        .parties-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .parties-table td {
            width: 50%;
            vertical-align: top;
            padding: 10px;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }
        .party-title {
            font-weight: bold;
            font-size: 12px;
            color: #0075de;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        .terms-content {
            white-space: pre-wrap;
            line-height: 1.65;
            font-size: 11px;
            text-align: justify;
            margin-bottom: 25px;
        }
        .signatures {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .signatures td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
        }
        .sig-box {
            min-height: 70px;
            display: block;
            margin: 10px auto;
        }
        .signed-badge {
            border: 1px solid #10b981;
            background-color: #ecfdf5;
            color: #065f46;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 10px;
            display: inline-block;
        }
        .footer {
            margin-top: 35px;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
            font-size: 10px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>SURAT PERJANJIAN SEWA MENYEWA KAMAR KOS</h1>
        <p>Platform Hunian Resmi &bull; TEMPATIN (tempatin.id)</p>
    </div>

    <div class="meta-box">
        <table>
            <tr>
                <td style="width: 25%; font-weight: bold;">Nomor Dokumen:</td>
                <td style="width: 40%;">{{ $contract->contract_number }}</td>
                <td style="width: 15%; font-weight: bold;">Status:</td>
                <td><strong>{{ $contract->isSigned() ? 'AKTIF / TERDAFTAR' : 'DRAF PERJANJIAN' }}</strong></td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Tanggal Terbit:</td>
                <td>{{ $contract->created_at->format('d F Y') }}</td>
                <td style="font-weight: bold;">Kode Booking:</td>
                <td>{{ $contract->booking->booking_code }}</td>
            </tr>
        </table>
    </div>

    <table class="parties-table">
        <tr>
            <td>
                <div class="party-title">PIHAK PERTAMA (PEMILIK KOS)</div>
                <div><strong>Nama:</strong> {{ $contract->booking->kos->owner->name ?? 'Pemilik Kos' }}</div>
                <div><strong>Email:</strong> {{ $contract->booking->kos->owner->email ?? '-' }}</div>
                <div><strong>Telepon:</strong> {{ $contract->booking->kos->owner->phone ?? '-' }}</div>
                <div><strong>Properti:</strong> {{ $contract->booking->kos->title }}</div>
            </td>
            <td>
                <div class="party-title">PIHAK KEDUA (PENYEWA / PENGHUNI)</div>
                <div><strong>Nama:</strong> {{ $contract->booking->tenant_name ?? $contract->booking->customer->name }}</div>
                <div><strong>Email:</strong> {{ $contract->booking->tenant_email ?? $contract->booking->customer->email }}</div>
                <div><strong>Telepon:</strong> {{ $contract->booking->tenant_phone ?? ($contract->booking->customer->phone ?? '-') }}</div>
                <div><strong>Durasi:</strong> {{ $contract->booking->duration_months }} Bulan</div>
            </td>
        </tr>
    </table>

    <div class="terms-content">
{{ $contract->terms }}
    </div>

    <table class="signatures">
        <tr>
            <td>
                <div>Pihak Pertama,</div>
                <div style="font-weight: bold; margin-top: 4px;">Pemilik Kos</div>
                <div class="sig-box">
                    <div style="margin-top: 45px; font-weight: bold; text-decoration: underline;">
                        {{ $contract->booking->kos->owner->name ?? 'Pemilik Properti' }}
                    </div>
                </div>
            </td>
            <td>
                <div>Pihak Kedua,</div>
                <div style="font-weight: bold; margin-top: 4px;">Penyewa / Penghuni</div>
                <div class="sig-box">
                    @if($contract->isSigned())
                        <div class="signed-badge" style="margin-top: 15px;">
                            TERVERIFIKASI SECARA ELEKTRONIK<br>
                            Waktu: {{ $contract->signed_at->format('d/m/Y H:i:s') }} WIB<br>
                            IP: {{ $contract->signer_ip ?? '127.0.0.1' }}
                        </div>
                    @else
                        <div style="margin-top: 45px; color: #9ca3af; font-style: italic;">
                            (Menunggu Tanda Tangan)
                        </div>
                    @endif
                    <div style="margin-top: 10px; font-weight: bold; text-decoration: underline;">
                        {{ $contract->booking->tenant_name ?? $contract->booking->customer->name }}
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen ini diterbitkan secara resmi melalui sistem aplikasi TEMPATIN. &bull; Halaman 1 dari 1 &bull; {{ date('Y') }}
    </div>

</body>
</html>
