<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Kos;
use App\Models\Payment;
use App\Models\User;
use App\Services\MidtransService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MidtransPaymentTest extends TestCase
{
    use DatabaseTransactions;

    protected User $owner;
    protected User $customerA;
    protected User $customerB;
    protected Kos $kosActive;
    protected Booking $bookingA;
    protected Invoice $invoiceA;
    protected Payment $paymentA;
    protected string $testOrderId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Midtrans',
            'email' => 'owner_midtrans_' . uniqid() . '@example.com',
            'phone' => '081211110001',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->customerA = User::create([
            'name' => 'Customer Midtrans A',
            'email' => 'cust_a_' . uniqid() . '@example.com',
            'phone' => '081211110002',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->customerB = User::create([
            'name' => 'Customer Midtrans B',
            'email' => 'cust_b_' . uniqid() . '@example.com',
            'phone' => '081211110003',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->kosActive = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Midtrans Executive',
            'slug' => 'kos-midtrans-exec-' . uniqid(),
            'description' => 'Kos modern lengkap.',
            'price' => 1000000.00,
            'type' => 'Campur',
            'city' => 'Jakarta Selatan',
            'address' => 'Jl. Sudirman No. 10',
            'thumbnail' => 'assets/img/kos/1.png',
            'status' => 'active',
        ]);

        // Buat booking dan invoice untuk Customer A
        $this->bookingA = Booking::create([
            'customer_id' => $this->customerA->id,
            'kos_id' => $this->kosActive->id,
            'booking_code' => Booking::generateBookingCode(),
            'tenant_name' => $this->customerA->name,
            'tenant_phone' => $this->customerA->phone,
            'tenant_email' => $this->customerA->email,
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addMonths(1)->addDays(2)->format('Y-m-d'),
            'duration_months' => 1,
            'kos_price' => 1000000.00,
            'subtotal' => 1000000.00,
            'admin_fee' => 25000.00,
            'total_amount' => 1025000.00,
            'status' => 'pending',
        ]);

        $this->invoiceA = Invoice::createFromBooking($this->bookingA);

        $this->testOrderId = 'TPT-TEST-' . uniqid();

        $this->paymentA = Payment::create([
            'invoice_id' => $this->invoiceA->id,
            'payment_code' => Payment::generatePaymentCode(),
            'order_id' => $this->testOrderId,
            'payment_method' => 'virtual_account',
            'amount' => 1025000.00,
            'snap_token' => 'dummy-snap-token-' . uniqid(),
            'snap_redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/dummy',
            'status' => 'pending',
        ]);
    }

    /**
     * Helper untuk membuat signature key Midtrans valid.
     */
    protected function generateValidSignature(string $orderId, string $statusCode, string $grossAmount): string
    {
        $serverKey = config('services.midtrans.server_key') ?: config('midtrans.server_key');
        return hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
    }

    /**
     * 1. Guest tidak dapat mengakses halaman pembayaran booking (Redirect ke Login).
     */
    public function test_01_guest_cannot_access_payment_page(): void
    {
        $response = $this->get(route('member.booking.payment', [
            'slug' => $this->kosActive->slug,
            'booking_code' => $this->bookingA->booking_code,
        ]));

        $response->assertRedirect(route('login'));
    }

    /**
     * 2. Customer tidak berhak mengakses pembayaran booking milik customer lain (Anti-IDOR 403).
     */
    public function test_02_customer_cannot_access_other_customer_payment(): void
    {
        // Customer B mencoba mengakses pembayaran milik Customer A
        $response = $this->actingAs($this->customerB)->get(route('member.booking.payment', [
            'slug' => $this->kosActive->slug,
            'booking_code' => $this->bookingA->booking_code,
        ]));

        $response->assertForbidden();
    }

    /**
     * 3. Customer pemilik sah langsung diarahkan ke gerbang pembayaran Midtrans resmi.
     */
    public function test_03_authorized_customer_can_open_payment_page(): void
    {
        $response = $this->actingAs($this->customerA)->get(route('member.booking.payment', [
            'slug' => $this->kosActive->slug,
            'booking_code' => $this->bookingA->booking_code,
        ]));

        $response->assertRedirect();
        $this->assertStringContainsString('midtrans.com', (string) $response->headers->get('Location'));
    }

    /**
     * 4. Webhook notifikasi Midtrans berhasil mengubah status ke success (Settlement).
     */
    public function test_04_webhook_settlement_marks_payment_and_booking_as_confirmed(): void
    {
        $grossAmount = '1025000.00';
        $statusCode = '200';
        $signature = $this->generateValidSignature($this->testOrderId, $statusCode, $grossAmount);

        $payload = [
            'order_id' => $this->testOrderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'transaction_id' => 'TRX-MIDTRANS-' . uniqid(),
            'va_numbers' => [
                ['bank' => 'bca', 'va_number' => '1234567890'],
            ],
        ];

        $response = $this->postJson(route('midtrans.notification'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'payment_status' => 'success',
        ]);

        $this->paymentA->refresh();
        $this->invoiceA->refresh();
        $this->bookingA->refresh();

        $this->assertEquals('success', $this->paymentA->status);
        $this->assertEquals('BCA VA', $this->paymentA->payment_channel);
        $this->assertNotNull($this->paymentA->paid_at);

        $this->assertEquals('paid', $this->invoiceA->status);
        $this->assertNotNull($this->invoiceA->paid_at);

        $this->assertEquals('confirmed', $this->bookingA->status);
    }

    /**
     * 5. Webhook capture dengan fraud_status accept ditandai sebagai success.
     */
    public function test_05_webhook_capture_accept_marks_payment_as_success(): void
    {
        $grossAmount = '1025000.00';
        $statusCode = '200';
        $signature = $this->generateValidSignature($this->testOrderId, $statusCode, $grossAmount);

        $payload = [
            'order_id' => $this->testOrderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'capture',
            'fraud_status' => 'accept',
            'payment_type' => 'credit_card',
            'transaction_id' => 'TRX-CC-' . uniqid(),
        ];

        $response = $this->postJson(route('midtrans.notification'), $payload);

        $response->assertStatus(200);
        $this->assertEquals('success', $this->paymentA->fresh()->status);
        $this->assertEquals('paid', $this->invoiceA->fresh()->status);
        $this->assertEquals('confirmed', $this->bookingA->fresh()->status);
    }

    /**
     * 6. Webhook capture dengan fraud_status challenge tidak menandai sebagai success.
     */
    public function test_06_webhook_capture_challenge_does_not_mark_as_success(): void
    {
        $grossAmount = '1025000.00';
        $statusCode = '201';
        $signature = $this->generateValidSignature($this->testOrderId, $statusCode, $grossAmount);

        $payload = [
            'order_id' => $this->testOrderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'capture',
            'fraud_status' => 'challenge',
            'payment_type' => 'credit_card',
            'transaction_id' => 'TRX-CHALLENGE-' . uniqid(),
        ];

        $response = $this->postJson(route('midtrans.notification'), $payload);

        $response->assertStatus(200);
        $this->assertNotEquals('success', $this->paymentA->fresh()->status);
        $this->assertNotEquals('paid', $this->invoiceA->fresh()->status);
    }

    /**
     * 7. Webhook status pending tidak menandai invoice sebagai paid.
     */
    public function test_07_webhook_pending_does_not_mark_invoice_as_paid(): void
    {
        $grossAmount = '1025000.00';
        $statusCode = '201';
        $signature = $this->generateValidSignature($this->testOrderId, $statusCode, $grossAmount);

        $payload = [
            'order_id' => $this->testOrderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'pending',
            'payment_type' => 'qris',
            'transaction_id' => 'TRX-PENDING-' . uniqid(),
        ];

        $response = $this->postJson(route('midtrans.notification'), $payload);

        $response->assertStatus(200);
        $this->assertEquals('pending', $this->paymentA->fresh()->status);
        $this->assertEquals('unpaid', $this->invoiceA->fresh()->status);
        $this->assertEquals('pending', $this->bookingA->fresh()->status);
    }

    /**
     * 8. Webhook status expire/cancel mengubah invoice menjadi expired/cancelled.
     */
    public function test_08_webhook_expire_marks_payment_as_expired(): void
    {
        $grossAmount = '1025000.00';
        $statusCode = '202';
        $signature = $this->generateValidSignature($this->testOrderId, $statusCode, $grossAmount);

        $payload = [
            'order_id' => $this->testOrderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'expire',
            'payment_type' => 'bank_transfer',
            'transaction_id' => 'TRX-EXPIRE-' . uniqid(),
        ];

        $response = $this->postJson(route('midtrans.notification'), $payload);

        $response->assertStatus(200);
        $this->assertEquals('expired', $this->paymentA->fresh()->status);
        $this->assertEquals('expired', $this->invoiceA->fresh()->status);
    }

    /**
     * 9. Webhook ditolak jika signature key tidak valid (Signature Protection).
     */
    public function test_09_webhook_fails_on_invalid_signature(): void
    {
        $payload = [
            'order_id' => $this->testOrderId,
            'status_code' => '200',
            'gross_amount' => '1025000.00',
            'signature_key' => 'signature_palsu_tidak_valid',
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
        ];

        $response = $this->postJson(route('midtrans.notification'), $payload);

        $response->assertStatus(400);
        $response->assertJson([
            'status' => 'error',
            'message' => 'Signature key tidak valid.',
        ]);

        // Status lokal tidak boleh berubah
        $this->assertEquals('pending', $this->paymentA->fresh()->status);
    }

    /**
     * 10. Webhook ditolak jika nominal gross_amount tidak cocok dengan database lokal (Tamper Protection).
     */
    public function test_10_webhook_fails_on_amount_mismatch(): void
    {
        $tamperedAmount = '50000.00'; // Mencoba bayar 50rb padahal tagihan 1.025.000
        $statusCode = '200';
        $signature = $this->generateValidSignature($this->testOrderId, $statusCode, $tamperedAmount);

        $payload = [
            'order_id' => $this->testOrderId,
            'status_code' => $statusCode,
            'gross_amount' => $tamperedAmount,
            'signature_key' => $signature,
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
        ];

        $response = $this->postJson(route('midtrans.notification'), $payload);

        $response->assertStatus(400);
        $response->assertJson([
            'status' => 'error',
            'message' => 'Nominal transaksi tidak cocok.',
        ]);

        $this->assertEquals('pending', $this->paymentA->fresh()->status);
    }

    /**
     * 11. Idempotensi webhook: Notifikasi settlement kedua tidak menimbulkan error atau perubahan ganda.
     */
    public function test_11_webhook_is_idempotent_on_duplicate_settlement(): void
    {
        $grossAmount = '1025000.00';
        $statusCode = '200';
        $signature = $this->generateValidSignature($this->testOrderId, $statusCode, $grossAmount);

        $payload = [
            'order_id' => $this->testOrderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'transaction_id' => 'TRX-IDEMPOTENT-001',
        ];

        // Pengiriman pertama
        $res1 = $this->postJson(route('midtrans.notification'), $payload);
        $res1->assertStatus(200);

        // Pengiriman kedua (duplikat webhook)
        $res2 = $this->postJson(route('midtrans.notification'), $payload);
        $res2->assertStatus(200);

        $this->assertEquals('success', $this->paymentA->fresh()->status);
        $this->assertEquals('paid', $this->invoiceA->fresh()->status);
        $this->assertEquals('confirmed', $this->bookingA->fresh()->status);
    }

    /**
     * 12. Notifikasi lama yang terlambat tidak boleh menurunkan status payment yang sudah sukses.
     */
    public function test_12_late_webhook_cannot_revert_successful_payment(): void
    {
        // Set payment menjadi success terlebih dahulu
        $this->paymentA->update([
            'status' => 'success',
            'paid_at' => now(),
        ]);
        $this->invoiceA->update(['status' => 'paid']);
        $this->bookingA->update(['status' => 'confirmed']);

        $grossAmount = '1025000.00';
        $statusCode = '201';
        $signature = $this->generateValidSignature($this->testOrderId, $statusCode, $grossAmount);

        // Notifikasi pending datang terlambat
        $payload = [
            'order_id' => $this->testOrderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'pending',
            'payment_type' => 'bank_transfer',
        ];

        $response = $this->postJson(route('midtrans.notification'), $payload);

        $response->assertStatus(200);

        // Status harus tetap success, bukan pending
        $this->assertEquals('success', $this->paymentA->fresh()->status);
        $this->assertEquals('paid', $this->invoiceA->fresh()->status);
        $this->assertEquals('confirmed', $this->bookingA->fresh()->status);
    }

    /**
     * 13. Callback query frontend tidak menentukan status pembayaran secara sepihak.
     */
    public function test_13_frontend_callback_query_does_not_change_database_status(): void
    {
        // Customer membuka detail booking dengan query payment_status=success palsu dari browser
        $response = $this->actingAs($this->customerA)->get(route('member.booking.show', [
            'booking_code' => $this->bookingA->booking_code,
            'payment_status' => 'success',
        ]));

        $response->assertStatus(200);

        // Database harus tetap pending karena webhook belum mengirim notifikasi sah
        $this->assertEquals('pending', $this->paymentA->fresh()->status);
        $this->assertEquals('pending', $this->bookingA->fresh()->status);
        $this->assertEquals('unpaid', $this->invoiceA->fresh()->status);
    }
}
