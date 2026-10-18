<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Kos;
use App\Models\RentalContract;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RentalContractTest extends TestCase
{
    use DatabaseTransactions;

    protected User $owner;
    protected User $customer;
    protected User $stranger;
    protected Kos $kos;
    protected Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Kontrak',
            'email' => 'owner.kontrak@example.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'phone' => '081234560001',
        ]);

        $this->customer = User::create([
            'name' => 'Penyewa Kontrak',
            'email' => 'cust.kontrak@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'phone' => '081234560002',
        ]);

        $this->stranger = User::create([
            'name' => 'Orang Lain',
            'email' => 'stranger.kontrak@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'phone' => '081234560003',
        ]);

        $this->kos = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Melati Harmoni',
            'slug' => 'kos-melati-harmoni',
            'type' => 'Putri',
            'price' => 1000000,
            'address' => 'Jl. Harmoni 12',
            'city' => 'Yogyakarta',
            'status' => 'active',
        ]);

        $this->booking = Booking::create([
            'booking_code' => 'BK-TEST-KONTRAK',
            'customer_id' => $this->customer->id,
            'kos_id' => $this->kos->id,
            'tenant_name' => 'Penyewa Kontrak',
            'tenant_email' => 'cust.kontrak@example.com',
            'tenant_phone' => '081234560002',
            'start_date' => now()->addDays(5)->format('Y-m-d'),
            'end_date' => now()->addDays(35)->format('Y-m-d'),
            'duration_months' => 1,
            'kos_price' => 1000000,
            'subtotal' => 1000000,
            'admin_fee' => 10000,
            'total_amount' => 1010000,
            'status' => 'approved',
        ]);
    }

    public function test_contract_can_be_accessed_via_booking_code(): void
    {
        $response = $this->actingAs($this->customer)
            ->get(route('contracts.forBooking', $this->booking->booking_code));

        $contract = RentalContract::where('booking_id', $this->booking->id)->first();
        $this->assertNotNull($contract);
        $response->assertRedirect(route('contracts.show', $contract->contract_number));
    }

    public function test_customer_and_owner_can_view_contract(): void
    {
        $contract = RentalContract::firstOrCreateForBooking($this->booking);

        // Customer can view
        $responseCustomer = $this->actingAs($this->customer)
            ->get(route('contracts.show', $contract->contract_number));
        $responseCustomer->assertOk();
        $responseCustomer->assertSee($contract->contract_number);
        $responseCustomer->assertSee('SURAT PERJANJIAN SEWA MENYEWA KAMAR KOS');

        // Owner can view
        $responseOwner = $this->actingAs($this->owner)
            ->get(route('contracts.show', $contract->contract_number));
        $responseOwner->assertOk();
        $responseOwner->assertSee($contract->contract_number);
    }

    public function test_stranger_cannot_view_contract(): void
    {
        $contract = RentalContract::firstOrCreateForBooking($this->booking);

        $response = $this->actingAs($this->stranger)
            ->get(route('contracts.show', $contract->contract_number));

        $response->assertStatus(403);
    }

    public function test_customer_can_sign_contract(): void
    {
        $contract = RentalContract::firstOrCreateForBooking($this->booking);

        $response = $this->actingAs($this->customer)
            ->post(route('contracts.sign', $contract->contract_number), [
                'agree' => 1,
            ]);

        $response->assertSessionHas('success');

        $contract->refresh();
        $this->assertTrue($contract->isSigned());
        $this->assertEquals('active', $contract->status);
        $this->assertNotNull($contract->signed_at);

        // Owner receives notification
        $this->assertEquals(1, $this->owner->unreadNotifications()->count());
    }

    public function test_stranger_cannot_sign_contract(): void
    {
        $contract = RentalContract::firstOrCreateForBooking($this->booking);

        $response = $this->actingAs($this->stranger)
            ->post(route('contracts.sign', $contract->contract_number), [
                'agree' => 1,
            ]);

        $response->assertStatus(403);
    }

    public function test_authorized_user_can_download_pdf(): void
    {
        $contract = RentalContract::firstOrCreateForBooking($this->booking);

        $response = $this->actingAs($this->customer)
            ->get(route('contracts.pdf', $contract->contract_number));

        $response->assertOk();
        $this->assertEquals('application/pdf', $response->headers->get('content-type'));
    }
}
