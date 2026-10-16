<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Kos;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class NotaPdfTest extends TestCase
{
    use DatabaseTransactions;

    protected User $owner;
    protected User $customerA;
    protected User $customerB;
    protected Kos $kos;
    protected Booking $bookingConfirmed;
    protected Booking $bookingPending;
    protected Invoice $invoiceConfirmed;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Kos Nota',
            'email' => 'owner_nota_' . uniqid() . '@example.com',
            'phone' => '081233330001',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->customerA = User::create([
            'name' => 'Customer Nota A',
            'email' => 'cust_nota_a_' . uniqid() . '@example.com',
            'phone' => '081233330002',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->customerB = User::create([
            'name' => 'Customer Nota B',
            'email' => 'cust_nota_b_' . uniqid() . '@example.com',
            'phone' => '081233330003',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->kos = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Nyaman Sejahtera',
            'slug' => 'kos-nyaman-sejahtera-' . uniqid(),
            'description' => 'Kos strategis dan bersih',
            'price' => 1200000,
            'thumbnail' => 'assets/img/kos/1.png',
            'address' => 'Jl. Mawar No. 10',
            'city' => 'Sidoarjo',
            'type' => 'Campur',
            'status' => 'active',
            'room_total' => 10,
            'room_available' => 5,
        ]);

        $this->bookingConfirmed = Booking::create([
            'booking_code' => 'TMP-TEST-CONFIRMED',
            'customer_id' => $this->customerA->id,
            'kos_id' => $this->kos->id,
            'tenant_name' => 'Customer Nota A',
            'tenant_phone' => '081233330002',
            'tenant_email' => $this->customerA->email,
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addMonths(2)->addDays(2)->format('Y-m-d'),
            'duration_months' => 2,
            'kos_price' => 1200000,
            'subtotal' => 2400000,
            'admin_fee' => 5000,
            'total_amount' => 2405000,
            'payment_method' => 'midtrans',
            'status' => 'confirmed',
        ]);

        $this->invoiceConfirmed = Invoice::createFromBooking($this->bookingConfirmed);
        $this->invoiceConfirmed->update(['status' => 'paid']);

        Payment::create([
            'invoice_id' => $this->invoiceConfirmed->id,
            'payment_code' => Payment::generatePaymentCode(),
            'order_id' => 'TMP-ORDER-TEST-01',
            'amount' => 2405000,
            'status' => 'success',
            'payment_method' => 'bank_transfer',
            'payment_channel' => 'BCA Virtual Account',
            'paid_at' => now(),
        ]);

        $this->bookingPending = Booking::create([
            'booking_code' => 'TMP-TEST-PENDING',
            'customer_id' => $this->customerA->id,
            'kos_id' => $this->kos->id,
            'tenant_name' => 'Customer Nota A',
            'tenant_phone' => '081233330002',
            'tenant_email' => $this->customerA->email,
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addMonths(1)->addDays(2)->format('Y-m-d'),
            'duration_months' => 1,
            'kos_price' => 1200000,
            'subtotal' => 1200000,
            'admin_fee' => 5000,
            'total_amount' => 1205000,
            'payment_method' => 'midtrans',
            'status' => 'pending',
        ]);
    }

    public function test_01_customer_can_download_pdf_nota_for_confirmed_booking(): void
    {
        $response = $this->actingAs($this->customerA)
            ->get(route('member.booking.nota.pdf', $this->bookingConfirmed->booking_code));

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('Nota-Pembayaran-TMP-TEST-CONFIRMED.pdf', $response->headers->get('Content-Disposition'));
    }

    public function test_02_guest_cannot_download_pdf_nota(): void
    {
        $response = $this->get(route('member.booking.nota.pdf', $this->bookingConfirmed->booking_code));

        $response->assertRedirect(route('login'));
    }

    public function test_03_customer_b_cannot_download_customer_a_nota_idor_protection(): void
    {
        $response = $this->actingAs($this->customerB)
            ->get(route('member.booking.nota.pdf', $this->bookingConfirmed->booking_code));

        $response->assertStatus(403);
    }

    public function test_04_pending_booking_cannot_download_nota_and_redirects_with_error(): void
    {
        $response = $this->actingAs($this->customerA)
            ->get(route('member.booking.nota.pdf', $this->bookingPending->booking_code));

        $response->assertRedirect(route('member.booking.show', $this->bookingPending->booking_code));
        $response->assertSessionHas('error');
    }

    public function test_05_download_pdf_button_is_rendered_on_confirmed_booking_page(): void
    {
        $response = $this->actingAs($this->customerA)
            ->get(route('member.booking.show', $this->bookingConfirmed->booking_code));

        $response->assertStatus(200);
        $response->assertSee(route('member.booking.nota.pdf', $this->bookingConfirmed->booking_code));
        $response->assertSee('Unduh Nota Pembayaran (PDF)');
    }
}
