<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Payment;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        $this->initConfiguration();
    }

    /**
     * Inisialisasi konfigurasi SDK Midtrans resmi secara aman.
     */
    protected function initConfiguration(): void
    {
        Config::$serverKey = config('services.midtrans.server_key') ?: config('midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key') ?: config('midtrans.client_key');
        Config::$isProduction = (bool) (config('services.midtrans.is_production') ?? config('midtrans.is_production', false));
        Config::$isSanitized = (bool) (config('services.midtrans.is_sanitized') ?? config('midtrans.is_sanitized', true));
        Config::$is3ds = (bool) (config('services.midtrans.is_3ds') ?? config('midtrans.is_3ds', true));
    }

    /**
     * Buat atau gunakan kembali Snap Token untuk sebuah Booking & Invoice.
     *
     * @return array{snap_token: string, redirect_url: string, order_id: string, payment: Payment}
     * @throws Exception
     */
    public function getOrCreateSnapTransaction(Booking $booking, Invoice $invoice): array
    {
        // Cari payment pending yang sudah memiliki snap_token yang masih valid
        $existingPayment = Payment::where('invoice_id', $invoice->id)
            ->whereNotNull('snap_token')
            ->where('status', 'pending')
            ->latest('id')
            ->first();

        if ($existingPayment && $existingPayment->snap_token) {
            // Token Snap & QRIS Midtrans memiliki batas kedaluwarsa 15 menit
            $isExpired = $existingPayment->created_at && $existingPayment->created_at->diffInMinutes(now()) >= 15;

            if (!$isExpired) {
                return [
                    'snap_token' => $existingPayment->snap_token,
                    'redirect_url' => $existingPayment->snap_redirect_url ?? "https://app.sandbox.midtrans.com/snap/v2/vtweb/{$existingPayment->snap_token}",
                    'order_id' => $existingPayment->order_id,
                    'payment' => $existingPayment,
                ];
            }

            // Jika sudah lewat 15 menit, tandai expired agar otomatis dibuatkan Snap token dan order_id baru yang aktif
            $existingPayment->update(['status' => 'expired']);
        }

        // Generate order_id unik yang terikat pada booking code
        $orderId = $this->generateUniqueOrderId($booking);

        $grossAmount = (int) round((float) $invoice->total_amount);

        // Siapkan rincian item: Sewa Kos + Biaya Admin
        $itemKosPrice = (int) round((float) $booking->kos_price);
        $durationMonths = max(1, (int) $booking->duration_months);
        $adminFee = (int) round((float) $booking->admin_fee);

        $items = [
            [
                'id' => 'KOS-' . $booking->kos_id,
                'price' => $itemKosPrice,
                'quantity' => $durationMonths,
                'name' => Str::limit($booking->kos->title ?? 'Sewa Kamar Kos', 45, '...'),
            ],
            [
                'id' => 'ADMIN-FEE',
                'price' => $adminFee,
                'quantity' => 1,
                'name' => 'Biaya Layanan Admin',
            ],
        ];

        // Validasi kesesuaian total nominal rincian item dengan gross amount
        $calculatedTotal = ($itemKosPrice * $durationMonths) + $adminFee;
        if ($calculatedTotal !== $grossAmount) {
            // Jika ada selisih pembulatan, sesuaikan item tunggal
            $items = [
                [
                    'id' => 'BKG-' . $booking->id,
                    'price' => $grossAmount,
                    'quantity' => 1,
                    'name' => Str::limit($booking->kos->title ?? 'Sewa Kamar Kos', 45, '...'),
                ],
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $grossAmount,
            ],
            'item_details' => $items,
            'customer_details' => [
                'first_name' => $booking->tenant_name,
                'email' => $booking->tenant_email,
                'phone' => $booking->tenant_phone,
            ],
            'callbacks' => [
                'finish' => route('member.booking.show', $booking->booking_code),
                'unfinish' => route('member.booking.show', $booking->booking_code),
                'error' => route('member.booking.show', $booking->booking_code),
            ],
        ];

        try {
            $transaction = Snap::createTransaction($params);
            $snapToken = $transaction->token;
            $redirectUrl = $transaction->redirect_url;
        } catch (Exception $e) {
            Log::error('Gagal membuat transaksi Midtrans Snap', [
                'booking_code' => $booking->booking_code,
                'order_id' => $orderId,
                'message' => $e->getMessage(),
            ]);

            throw new Exception('Gagal menghubungi gerbang pembayaran Midtrans. Silakan coba beberapa saat lagi.');
        }

        // Simpan transaksi payment ke database
        $payment = DB::transaction(function () use ($invoice, $orderId, $grossAmount, $snapToken, $redirectUrl) {
            return Payment::create([
                'invoice_id' => $invoice->id,
                'payment_code' => Payment::generatePaymentCode(),
                'order_id' => $orderId,
                'payment_method' => 'virtual_account',
                'amount' => $grossAmount,
                'snap_token' => $snapToken,
                'snap_redirect_url' => $redirectUrl,
                'status' => 'pending',
            ]);
        });

        return [
            'snap_token' => $snapToken,
            'redirect_url' => $redirectUrl,
            'order_id' => $orderId,
            'payment' => $payment,
        ];
    }

    /**
     * Generate order_id unik untuk Midtrans (format: TPT-YYYYMM-XXXXX-timestamp).
     */
    protected function generateUniqueOrderId(Booking $booking): string
    {
        $cleanCode = str_replace('-', '', $booking->booking_code);
        $suffix = time();

        $candidate = 'TPT-' . $cleanCode . '-' . $suffix;

        // Pastikan tidak melebihi 50 karakter Midtrans limit
        if (strlen($candidate) > 50) {
            $candidate = substr('TPT-' . $booking->id . '-' . $cleanCode . '-' . $suffix, 0, 50);
        }

        return $candidate;
    }

    /**
     * Verifikasi signature notification resmi Midtrans (SHA512).
     * Format: sha512(order_id + status_code + gross_amount + ServerKey)
     */
    public function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
    {
        $serverKey = config('services.midtrans.server_key') ?: config('midtrans.server_key');

        if (empty($serverKey)) {
            Log::error('Midtrans Server Key belum dikonfigurasi saat verifikasi webhook.');
            return false;
        }

        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        return hash_equals($expected, $signatureKey);
    }

    /**
     * Ambil status transaksi terkini langsung dari API Midtrans.
     *
     * @return object|null
     */
    public function fetchTransactionStatus(string $orderId): ?object
    {
        try {
            return Transaction::status($orderId);
        } catch (Exception $e) {
            Log::warning('Gagal memeriksa status Midtrans via API', [
                'order_id' => $orderId,
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Proses notifikasi webhook dari Midtrans secara idempotent dan aman.
     *
     * @param array<string, mixed> $payload
     * @return array{success: bool, message: string, payment_status: ?string}
     */
    public function handleNotification(array $payload): array
    {
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;
        $transactionId = $payload['transaction_id'] ?? null;
        $paymentType = $payload['payment_type'] ?? 'midtrans';

        if (!$orderId || !$statusCode || !$grossAmount || !$signatureKey || !$transactionStatus) {
            Log::warning('Notifikasi Midtrans ditolak: Payload tidak lengkap.', [
                'has_order_id' => !empty($orderId),
                'has_status_code' => !empty($statusCode),
            ]);

            return [
                'success' => false,
                'message' => 'Payload notifikasi tidak lengkap.',
                'payment_status' => null,
            ];
        }

        // 1. Verifikasi Signature Key
        if (!$this->verifySignature((string) $orderId, (string) $statusCode, (string) $grossAmount, (string) $signatureKey)) {
            Log::warning('Notifikasi Midtrans ditolak: Signature key tidak valid.', [
                'order_id' => $orderId,
            ]);

            return [
                'success' => false,
                'message' => 'Signature key tidak valid.',
                'payment_status' => null,
            ];
        }

        // 2. Temukan record Payment terkait
        $payment = Payment::with(['invoice.booking'])->where('order_id', $orderId)->first();

        if (!$payment) {
            Log::warning('Notifikasi Midtrans: Order ID tidak ditemukan di database.', [
                'order_id' => $orderId,
            ]);

            return [
                'success' => false,
                'message' => 'Order ID tidak ditemukan.',
                'payment_status' => null,
            ];
        }

        $invoice = $payment->invoice;
        $booking = $invoice?->booking;

        // 3. Validasi nominal transaksi lokal vs notifikasi
        $localAmount = (int) round((float) $payment->amount);
        $incomingAmount = (int) round((float) $grossAmount);

        if ($localAmount !== $incomingAmount) {
            Log::error('Notifikasi Midtrans: Nominal tidak cocok dengan tagihan lokal.', [
                'order_id' => $orderId,
                'local_amount' => $localAmount,
                'incoming_amount' => $incomingAmount,
            ]);

            return [
                'success' => false,
                'message' => 'Nominal transaksi tidak cocok.',
                'payment_status' => null,
            ];
        }

        // 4. Petakan status transaksi Midtrans
        // settlement / capture (dengan accept) => success
        // pending => pending
        // deny, cancel, expire => failed/expired/cancelled
        $newPaymentStatus = match ($transactionStatus) {
            'capture' => ($fraudStatus === 'accept' || empty($fraudStatus)) ? 'success' : 'failed',
            'settlement' => 'success',
            'pending' => 'pending',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'failed',
            'refund' => 'failed',
            default => 'pending',
        };

        // Identifikasi kanal pembayaran yang digunakan (cth: bca, gopay, mandiri)
        $paymentChannel = $this->resolvePaymentChannel($payload);

        // 5. Proteksi Idempotency & Late Notification
        // Status yang sudah success tidak boleh diubah kembali menjadi pending/failed
        if ($payment->status === 'success' && $newPaymentStatus !== 'success') {
            Log::info('Notifikasi Midtrans diabaikan karena pembayaran sudah sukses sebelumnya.', [
                'order_id' => $orderId,
                'current_status' => $payment->status,
                'incoming_status' => $transactionStatus,
            ]);

            return [
                'success' => true,
                'message' => 'Pembayaran sudah berstatus sukses sebelumnya.',
                'payment_status' => 'success',
            ];
        }

        // 6. Update database secara terisolasi dalam transaksi database
        DB::transaction(function () use (
            $payment,
            $invoice,
            $booking,
            $newPaymentStatus,
            $transactionId,
            $paymentType,
            $paymentChannel,
            $payload
        ) {
            $paymentUpdates = [
                'status' => $newPaymentStatus,
                'payment_method' => $paymentType,
                'payment_channel' => $paymentChannel,
                'payload_response' => $payload,
            ];

            if ($transactionId) {
                $paymentUpdates['transaction_id'] = $transactionId;
            }

            if ($newPaymentStatus === 'success' && empty($payment->paid_at)) {
                $paymentUpdates['paid_at'] = now();
            }

            $payment->update($paymentUpdates);

            // Update Invoice & Booking sesuai status pembayaran
            if ($newPaymentStatus === 'success') {
                if ($invoice) {
                    $invoice->update([
                        'status' => 'paid',
                        'paid_at' => $invoice->paid_at ?? now(),
                    ]);
                }

                if ($booking) {
                    // Update booking menjadi confirmed jika sebelumnya pending
                    if ($booking->status === 'pending') {
                        $booking->update(['status' => 'confirmed']);
                    }
                }
            } elseif ($newPaymentStatus === 'expired') {
                if ($invoice && $invoice->status === 'unpaid') {
                    $invoice->update(['status' => 'expired']);
                }
            } elseif ($newPaymentStatus === 'failed') {
                if ($invoice && $invoice->status === 'unpaid') {
                    $invoice->update(['status' => 'cancelled']);
                }
            }
        });

        Log::info('Notifikasi Midtrans berhasil diproses.', [
            'order_id' => $orderId,
            'payment_status' => $newPaymentStatus,
            'transaction_status' => $transactionStatus,
        ]);

        return [
            'success' => true,
            'message' => 'Notifikasi berhasil diproses.',
            'payment_status' => $newPaymentStatus,
        ];
    }

    /**
     * Resolusi nama kanal pembayaran dari payload notifikasi Midtrans.
     */
    protected function resolvePaymentChannel(array $payload): string
    {
        if (!empty($payload['va_numbers'][0])) {
            $vaFirst = $payload['va_numbers'][0];
            $bank = is_array($vaFirst) ? ($vaFirst['bank'] ?? null) : ($vaFirst->bank ?? null);
            if ($bank) {
                return strtoupper((string) $bank) . ' VA';
            }
        }

        if (!empty($payload['bank'])) {
            return strtoupper((string) $payload['bank']);
        }

        if (!empty($payload['bill_key']) || ($payload['payment_type'] ?? '') === 'echannel') {
            return 'Mandiri Bill';
        }

        if (!empty($payload['payment_type'])) {
            return match ($payload['payment_type']) {
                'qris' => 'QRIS',
                'gopay' => 'GoPay',
                'shopeepay' => 'ShopeePay',
                'credit_card' => 'Kartu Kredit',
                'cstore' => strtoupper((string) ($payload['store'] ?? 'Convenience Store')),
                default => ucfirst(str_replace('_', ' ', (string) $payload['payment_type'])),
            };
        }

        return 'Midtrans';
    }
}
