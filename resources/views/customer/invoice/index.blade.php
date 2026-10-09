@extends('layouts.app')

@section('title', 'Tagihan / Invoice - TEMPATIN')

@push('styles')
<style>
        /* Tambahan style untuk payment */
        .payment-summary-box {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .payment-method-item {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fff;
        }

        .payment-method-item:hover {
            border-color: #007bff;
            background: #f8f9fa;
        }

        .payment-method-item.active {
            border-color: #007bff;
            background: #e7f1ff;
        }

        .payment-method-item input[type="radio"] {
            margin-right: 12px;
            accent-color: #007bff;
        }

        .payment-method-item .method-icon {
            font-size: 20px;
            color: #007bff;
            width: 30px;
            display: inline-block;
        }

        .payment-method-item .method-name {
            font-weight: 600;
            color: #333;
        }

        .payment-method-item .method-desc {
            font-size: 13px;
            color: #6c757d;
            margin-left: 42px;
        }

        .payment-total-box {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .payment-total-box .total-amount {
            font-size: 28px;
            font-weight: 700;
        }

        .payment-total-box .total-label {
            font-size: 14px;
            opacity: 0.9;
        }

        .payment-total-box .total-detail {
            font-size: 13px;
            opacity: 0.8;
        }

        .booking-steps {
            display: flex;
            justify-content: space-between;
            margin: 30px 0 40px;
            position: relative;
            padding: 0 20px;
        }

        .booking-steps::before {
            content: '';
            position: absolute;
            top: 18px;
            left: 15%;
            right: 15%;
            height: 2px;
            background: #dee2e6;
            z-index: 0;
        }

        .step-item {
            text-align: center;
            z-index: 1;
            flex: 1;
        }

        .step-number {
            display: inline-block;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #dee2e6;
            color: #fff;
            line-height: 36px;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .step-item.active .step-number {
            background: #007bff;
        }

        .step-item.completed .step-number {
            background: #28a745;
        }

        .step-label {
            font-size: 12px;
            color: #6c757d;
            font-weight: 500;
        }

        .step-item.active .step-label {
            color: #007bff;
            font-weight: 600;
        }

        .step-item.completed .step-label {
            color: #28a745;
        }

        .property-mini-card {
            border-left: 3px solid #007bff;
            padding-left: 15px;
            margin-bottom: 20px;
        }

        .property-mini-card .property-name {
            font-weight: 600;
            font-size: 16px;
            color: #333;
            margin-bottom: 4px;
        }

        .property-mini-card .property-address {
            font-size: 13px;
            color: #6c757d;
        }

        .form-control-payment {
            border-radius: 6px;
            padding: 10px 14px;
            border: 1px solid #ced4da;
        }

        .form-control-payment:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        .btn-payment-submit {
            padding: 12px 30px;
            font-size: 16px;
            border-radius: 6px;
            font-weight: 600;
            width: 100%;
        }

        .ts-box-payment {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 25px;
        }

        .text-muted-light {
            color: #868e96;
        }

        .badge-status {
            font-size: 12px;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .divider-custom {
            border-top: 1px solid #e9ecef;
            margin: 20px 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .booking-steps {
                padding: 0 5px;
            }

            .step-label {
                font-size: 10px;
            }

            .step-number {
                width: 30px;
                height: 30px;
                line-height: 30px;
                font-size: 12px;
            }

            .payment-total-box .total-amount {
                font-size: 22px;
            }
        }
    
</style>
@endpush

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')

    @include('partials.alert')


       

        <!-- MAIN -->
        <main id="ts-main">

            <!-- BREADCRUMB -->
            <section id="breadcrumb">
                <div class="container">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('kos.show', $kos['slug'] ?? 'kos-putri-melati') }}">Property</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tagihan Saya</li>
                        </ol>
                    </nav>
                </div>
            </section>

            <!-- PAGE TITLE -->
            <section id="page-title">
                <div class="container">
                    <div class="d-block d-sm-flex justify-content-between align-items-center">
                        <div class="ts-title mb-0">
                            <h1>Tagihan / Invoice</h1>
                            <h5 class="ts-opacity__90">
                                <i class="fa fa-calendar-check text-primary mr-2"></i>
                                Daftar tagihan sewa kos kamu
                            </h5>
                        </div>
                        <div>
                            <span class="badge badge-primary p-3 font-weight-normal ts-shadow__sm">
                                <i class="fa fa-clock mr-2"></i>
                                Selesaikan dalam 15:00
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CONTENT -->
            <section id="content">
                <div class="container">

                    <!-- Riwayat Tagihan -->
                    <div class="ts-box ts-box-payment mb-4">
                        <h3 class="mb-4">Riwayat Tagihan</h3>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>No. Invoice</th>
                                        <th>Kos</th>
                                        <th>Jumlah</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice['invoice_number'] }}</td>
                                        <td>{{ $invoice['kos'] }}</td>
                                        <td>Rp {{ number_format($invoice['amount'], 0, ',', '.') }}</td>
                                        <td>{{ $invoice['due_date'] }}</td>
                                        <td>
                                            <span class="badge {{ $invoice['status'] === 'Lunas' ? 'badge-success' : 'badge-warning' }}">
                                                {{ $invoice['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end Riwayat Tagihan-->

                    <!-- Booking Steps -->
                    <div class="booking-steps">
                        <div class="step-item completed">
                            <div class="step-number"><i class="fa fa-check"></i></div>
                            <div class="step-label">Pilih Properti</div>
                        </div>
                        <div class="step-item active">
                            <div class="step-number">2</div>
                            <div class="step-label">Konfirmasi & Bayar</div>
                        </div>
                        <div class="step-item">
                            <div class="step-number">3</div>
                            <div class="step-label">Selesai</div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- LEFT COLUMN - Payment Form -->
                        <div class="col-lg-8">
                            <div class="ts-box ts-box-payment">
                                <h3 class="mb-4">Detail Pembayaran</h3>

                                <!-- Property Info Mini -->
                                <div class="property-mini-card">
                                    <div class="property-name">{{ $invoices[0]['kos'] ?? '-' }}</div>
                                    <div class="property-address">
                                        <i class="fa fa-map-marker mr-1"></i>
                                        {{ $invoices[0]['kos'] ?? '-' }}
                                    </div>
                                    <div class="mt-2">
                                        <span class="badge badge-success badge-status">
                                            <i class="fa fa-check-circle mr-1"></i>
                                            Tersedia
                                        </span>
                                        <span class="badge badge-light badge-status ml-2">
                                            <i class="fa fa-tag mr-1"></i>
                                            {{ $invoices[0]['invoice_number'] ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="divider-custom"></div>

                                {{-- TODO: arahkan action ke route POST customer.invoice.pay setelah pembayaran diimplementasikan --}}
                                <form id="payment-form" action="#" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fullname">Nama Lengkap <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-payment"
                                                    id="fullname" name="fullname" placeholder="Masukkan nama lengkap"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control form-control-payment" id="email"
                                                    name="email" placeholder="Masukkan email" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">Nomor Telepon <span
                                                        class="text-danger">*</span></label>
                                                <input type="tel" class="form-control form-control-payment" id="phone"
                                                    name="phone" placeholder="Masukkan nomor telepon" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="checkin">Tanggal Check-in</label>
                                                <input type="date" class="form-control form-control-payment"
                                                    id="checkin" name="checkin">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="notes">Catatan Tambahan</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="2"
                                            placeholder="Tambahkan catatan jika ada (opsional)"></textarea>
                                    </div>

                                    <div class="divider-custom"></div>

                                    <!-- Payment Method -->
                                    <h4 class="mb-3">Metode Pembayaran</h4>

                                    <div class="payment-method-item active" onclick="selectPayment('bank_transfer')">
                                        <input type="radio" name="payment_method" value="bank_transfer"
                                            id="bank_transfer" checked>
                                        <span class="method-icon"><i class="fas fa-university"></i></span>
                                        <span class="method-name">Transfer Bank</span>
                                        <div class="method-desc">BCA, Mandiri, BNI, BRI</div>
                                    </div>

                                    <div class="payment-method-item" onclick="selectPayment('credit_card')">
                                        <input type="radio" name="payment_method" value="credit_card" id="credit_card">
                                        <span class="method-icon"><i class="fas fa-credit-card"></i></span>
                                        <span class="method-name">Kartu Kredit</span>
                                        <div class="method-desc">Visa, Mastercard, JCB</div>
                                    </div>

                                    <div class="payment-method-item" onclick="selectPayment('e_wallet')">
                                        <input type="radio" name="payment_method" value="e_wallet" id="e_wallet">
                                        <span class="method-icon"><i class="fas fa-wallet"></i></span>
                                        <span class="method-name">E-Wallet</span>
                                        <div class="method-desc">OVO, GoPay, DANA, LinkAja</div>
                                    </div>

                                    <input type="hidden" name="property_id" value="{{ $invoices[0]['invoice_number'] ?? '' }}">
                                    <input type="hidden" name="property_name" value="{{ $invoices[0]['kos'] ?? '' }}">
                                    <input type="hidden" name="price" value="1000000">

                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-primary btn-payment-submit">
                                            <i class="fa fa-check-circle mr-2"></i>
                                            Konfirmasi & Bayar Sekarang
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN - Summary -->
                        <div class="col-lg-4">

                            <!-- Summary Box -->
                            <div class="ts-box ts-box-payment">
                                <h4 class="mb-3">Ringkasan Booking</h4>

                                <div class="payment-summary-box">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted-light">Harga Sewa</span>
                                        <span><strong>Rp {{ number_format($invoices[0]['amount'] ?? 0, 0, ',', '.') }}</strong></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted-light">Biaya Admin</span>
                                        <span><strong>Rp 0</strong></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted-light">Pajak</span>
                                        <span><strong>Rp 0</strong></span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between">
                                        <span><strong>Total</strong></span>
                                        <span><strong class="text-primary" style="font-size:18px;">Rp {{ number_format($invoices[0]['amount'] ?? 0, 0, ',', '.') }}</strong></span>
                                    </div>
                                </div>

                                <!-- Payment Total Box -->
                                <div class="payment-total-box mt-3">
                                    <div class="total-label">Total Pembayaran</div>
                                    <div class="total-amount">Rp {{ number_format($invoices[0]['amount'] ?? 0, 0, ',', '.') }}</div>
                                    <div class="total-detail mt-2">
                                        <i class="fa fa-clock mr-1"></i>
                                        Selesaikan pembayaran dalam 15 menit
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="alert alert-info" style="border-radius:6px;padding:12px 15px;">
                                        <i class="fa fa-info-circle mr-2"></i>
                                        <small>Booking akan dikonfirmasi setelah pembayaran diverifikasi</small>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <a href="{{ route('kos.show', $kos['slug'] ?? 'kos-putri-melati') }}" class="btn btn-link text-decoration-none">
                                        <i class="fa fa-arrow-left mr-1"></i>
                                        Kembali ke Detail Properti
                                    </a>
                                </div>
                            </div>

                            <!-- Security Badge -->
                            <div class="ts-box ts-box-payment mt-3">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-shield-alt text-success"
                                        style="font-size:24px;margin-right:12px;"></i>
                                    <div>
                                        <h6 class="mb-0">Pembayaran Aman</h6>
                                        <small class="text-muted-light">Data Anda terenkripsi dan aman</small>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted-light">
                                        <i class="fa fa-lock mr-1"></i>
                                        SSL Enkripsi 256-bit
                                    </small>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </section>

        </main>

        <!-- FOOTER -->
        @include('partials.footer')
@endsection

@push('scripts')
<script>
        // Select payment method
        function selectPayment(method) {
            document.querySelectorAll('.payment-method-item').forEach(el => {
                el.classList.remove('active');
            });
            document.querySelector(`.payment-method-item input[value="${method}"]`).closest('.payment-method-item').classList.add('active');
            document.getElementById(method).checked = true;
        }

        // Handle form submission
        $('#payment-form').on('submit', function (e) {
            e.preventDefault();

            var submitBtn = $(this).find('button[type="submit"]');
            var originalText = submitBtn.html();
            submitBtn.html('<i class="fa fa-spinner fa-spin mr-2"></i> Memproses...');
            submitBtn.prop('disabled', true);

            // Simulate processing
            setTimeout(function () {
                // Show success using Bootstrap alert or modal
                var successHtml = `
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:8px;">
                    <i class="fa fa-check-circle mr-2"></i>
                    <strong>Pembayaran Berhasil!</strong> Booking Anda telah dikonfirmasi.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;
                $('#payment-form').prepend(successHtml);

                submitBtn.html('<i class="fa fa-check-circle mr-2"></i> Pembayaran Berhasil');
                submitBtn.removeClass('btn-primary').addClass('btn-success');
                submitBtn.prop('disabled', false);

                // Redirect after 3 seconds
                setTimeout(function () {
                    window.location.href = '{{ route('customer.invoice.index') }}';
                }, 3000);
            }, 2000);
        });
    
</script>
@endpush
