@extends('layouts.customer')

@section('title', 'Tagihan & Invoice - TEMPATIN')

@section('customer-content')

<!-- HEADER -->
<div class="mb-4">
    <div class="d-inline-flex align-items-center mb-2 px-2 py-1 rounded" style="background-color: var(--color-sky-tint); color: var(--color-notion-blue); font-size: 11px; font-weight: 600;">
        <i class="fa fa-file-invoice mr-1"></i> TAGIHAN HUNIAN
    </div>
    <h1 style="font-family: var(--font-serif); font-size: 1.85rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
        Tagihan & Invoice Saya
    </h1>
    <p style="font-size: 14px; color: var(--color-stone); margin-bottom: 0;">
        Daftar tagihan sewa kamar kos aktif dan riwayat pembayaran resmi.
    </p>
</div>

<!-- INVOICE LIST TABLE -->
<div class="rounded overflow-hidden mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
    <div class="p-3 border-bottom" style="border-color: rgba(0,0,0,0.06) !important;">
        <h3 style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 0;">
            Riwayat Tagihan
        </h3>
    </div>
    <div class="table-responsive mb-0">
        <table class="table mb-0 align-middle">
            <thead style="background-color: var(--surface-page-canvas); border-bottom: var(--border-hairline);">
                <tr>
                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 20px; border-top: none;">No. Invoice</th>
                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 20px; border-top: none;">Kos</th>
                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 20px; border-top: none;">Jumlah</th>
                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 20px; border-top: none;">Jatuh Tempo</th>
                    <th style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-stone); font-weight: 600; padding: 12px 20px; border-top: none;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    @php
                        $isPaid = in_array(strtolower($invoice['status']), ['paid', 'lunas', 'selesai']);
                        $statusStyle = $isPaid 
                            ? 'background-color: #edf7ee; color: #166534; border: 1px solid rgba(22, 101, 52, 0.2);'
                            : 'background-color: #fef9c3; color: #854d0e; border: 1px solid rgba(133, 77, 14, 0.2);';
                    @endphp
                    <tr style="border-bottom: 1px solid rgba(0,0,0,0.06);">
                        <td style="padding: 14px 20px; font-family: monospace; font-weight: 700; color: var(--color-notion-blue);">
                            {{ $invoice['invoice_number'] }}
                        </td>
                        <td style="padding: 14px 20px; font-weight: 600; color: var(--color-midnight-ink); font-size: 14px;">
                            {{ $invoice['kos'] }}
                        </td>
                        <td style="padding: 14px 20px; font-weight: 700; color: var(--color-midnight-ink); font-variant-numeric: tabular-nums; font-size: 14px;">
                            Rp {{ number_format($invoice['amount'], 0, ',', '.') }}
                        </td>
                        <td style="padding: 14px 20px; font-size: 13px; color: var(--color-stone);">
                            {{ $invoice['due_date'] }}
                        </td>
                        <td style="padding: 14px 20px;">
                            <span class="px-2 py-1 rounded-pill" style="{{ $statusStyle }}; font-size: 11px; font-weight: 600;">
                                {{ $invoice['status'] }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- PAYMENT FORM CARD -->
<div class="p-4 rounded mb-4" style="background-color: #ffffff; border: var(--border-hairline); border-radius: var(--radius-cards);">
    <h2 style="font-size: 1.15rem; font-weight: 700; color: var(--color-midnight-ink); margin-bottom: 4px;">
        Konfirmasi Pembayaran Tagihan
    </h2>
    <p style="font-size: 13px; color: var(--color-stone); margin-bottom: 20px;">
        Selesaikan pembayaran untuk tagihan terbaru: <strong>{{ $invoices[0]['invoice_number'] ?? '-' }}</strong> ({{ $invoices[0]['kos'] ?? '-' }}).
    </p>

    <form id="payment-form" action="#" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 form-group mb-3">
                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="{{ Auth::user()->name ?? '' }}" placeholder="Nama sesuai KTP" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
            </div>
            <div class="col-md-6 form-group mb-3">
                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Alamat Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email ?? '' }}" placeholder="nama@email.com" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group mb-3">
                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Nomor WhatsApp <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="08xxxxxxxxxx" required style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
            </div>
            <div class="col-md-6 form-group mb-3">
                <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink);">Tanggal Check-in</label>
                <input type="date" class="form-control" id="checkin" name="checkin" value="{{ date('Y-m-d') }}" style="border-radius: var(--radius-inputs); border: var(--border-hairline); font-size: 14px; padding: 10px 14px;">
            </div>
        </div>

        <div class="mb-4">
            <label style="font-size: 13px; font-weight: 600; color: var(--color-midnight-ink); margin-bottom: 8px;">Metode Pembayaran</label>
            <div class="d-flex flex-column gap-2">
                <label class="p-3 rounded d-flex align-items-center justify-content-between mb-0 cursor-pointer" style="border: 2px solid var(--color-midnight-ink); background-color: var(--surface-page-canvas); border-radius: var(--radius-cards); cursor: pointer;">
                    <div class="d-flex align-items-center">
                        <input type="radio" name="payment_method" value="bank_transfer" checked class="mr-3" style="width: 18px; height: 18px; accent-color: var(--color-midnight-ink);">
                        <div>
                            <span style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">Transfer Bank / Virtual Account</span>
                            <small class="d-block text-muted">BCA, Mandiri, BRI, BNI (Otomatis)</small>
                        </div>
                    </div>
                    <i class="fa fa-university" style="color: var(--color-midnight-ink);"></i>
                </label>
                <label class="p-3 rounded d-flex align-items-center justify-content-between mb-0 cursor-pointer" style="border: var(--border-hairline); background-color: #ffffff; border-radius: var(--radius-cards); cursor: pointer;">
                    <div class="d-flex align-items-center">
                        <input type="radio" name="payment_method" value="e_wallet" class="mr-3" style="width: 18px; height: 18px; accent-color: var(--color-midnight-ink);">
                        <div>
                            <span style="font-size: 14px; font-weight: 700; color: var(--color-midnight-ink);">Dompet Digital / QRIS</span>
                            <small class="d-block text-muted">GoPay, OVO, Dana, LinkAja</small>
                        </div>
                    </div>
                    <i class="fa fa-wallet" style="color: var(--color-stone);"></i>
                </label>
            </div>
        </div>

        <div class="p-3 rounded mb-4 d-flex justify-content-between align-items-center" style="background-color: var(--surface-page-canvas); border: 1px solid rgba(0,0,0,0.06);">
            <span style="font-size: 14px; font-weight: 600; color: var(--color-midnight-ink);">Total yang Harus Dibayar:</span>
            <span style="font-size: 1.25rem; font-weight: 800; color: var(--color-notion-blue); font-variant-numeric: tabular-nums;">
                Rp {{ number_format($invoices[0]['amount'] ?? 0, 0, ',', '.') }}
            </span>
        </div>

        <button type="submit" class="btn btn-primary" style="font-weight: 600; font-size: 14px; padding: 12px 28px; border-radius: var(--radius-buttons);">
            <i class="fa fa-check-circle mr-2"></i> Konfirmasi & Bayar Sekarang
        </button>
    </form>
</div>

@push('scripts')
<script>
    $('#payment-form').on('submit', function (e) {
        e.preventDefault();
        var submitBtn = $(this).find('button[type="submit"]');
        submitBtn.html('<i class="fa fa-spinner fa-spin mr-2"></i> Memproses...').prop('disabled', true);

        setTimeout(function () {
            alert('Pembayaran Berhasil! Tagihan Anda telah diverifikasi oleh TEMPATIN.');
            submitBtn.html('<i class="fa fa-check-circle mr-2"></i> Pembayaran Berhasil').removeClass('btn-primary').addClass('btn-success');
            setTimeout(function () {
                window.location.reload();
            }, 1000);
        }, 1500);
    });
</script>
@endpush

@endsection
