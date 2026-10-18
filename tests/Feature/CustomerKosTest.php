<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerKosTest extends TestCase
{
    use DatabaseTransactions;

    protected User $owner;
    protected User $customer;
    protected Kos $kosA;
    protected Kos $kosB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Property',
            'email' => 'owner_prop_' . uniqid() . '@example.com',
            'phone' => '081299991111',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->customer = User::create([
            'name' => 'Customer Renter',
            'email' => 'renter_' . uniqid() . '@example.com',
            'phone' => '081299992222',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->kosA = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Permata Nyata',
            'slug' => 'kos-permata-nyata-' . uniqid(),
            'description' => 'Kos riil dari database',
            'price' => 1250000.00,
            'type' => 'Campur',
            'city' => 'Yogyakarta',
            'address' => 'Jl. Kaliurang KM 5',
            'status' => 'active',
        ]);
    }

    /**
     * 1. Customer tanpa booking melihat empty state di Kos Saya.
     */
    public function test_01_customer_without_booking_sees_empty_state(): void
    {
        $response = $this->actingAs($this->customer)->get(route('customer.kos.index'));

        $response->assertStatus(200);
        $response->assertSee('Belum Ada Kos yang Disewa');
        $response->assertDontSee('Kos Putri Melati'); // Data hardcoded lama harus hilang
    }

    /**
     * 2. Customer dengan booking confirmed/active melihat kos aktualnya.
     */
    public function test_02_customer_with_confirmed_booking_sees_real_kos(): void
    {
        Booking::create([
            'customer_id' => $this->customer->id,
            'kos_id' => $this->kosA->id,
            'booking_code' => Booking::generateBookingCode(),
            'tenant_name' => $this->customer->name,
            'tenant_phone' => $this->customer->phone,
            'tenant_email' => $this->customer->email,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonths(3)->format('Y-m-d'),
            'duration_months' => 3,
            'kos_price' => 1250000.00,
            'subtotal' => 3750000.00,
            'admin_fee' => 25000.00,
            'total_amount' => 3775000.00,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($this->customer)->get(route('customer.kos.index'));

        $response->assertStatus(200);
        $response->assertSee('Kos Permata Nyata');
        $response->assertSee('Yogyakarta');
        $response->assertDontSee('Kos Putri Melati');
    }

    /**
     * 3. Booking pending tidak ditampilkan seolah-olah sudah dihuni.
     */
    public function test_03_pending_booking_is_separated_from_rented_kos(): void
    {
        Booking::create([
            'customer_id' => $this->customer->id,
            'kos_id' => $this->kosA->id,
            'booking_code' => 'BKG-PENDING-CHECK',
            'tenant_name' => $this->customer->name,
            'tenant_phone' => $this->customer->phone,
            'tenant_email' => $this->customer->email,
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addMonths(1)->format('Y-m-d'),
            'duration_months' => 1,
            'kos_price' => 1250000.00,
            'subtotal' => 1250000.00,
            'admin_fee' => 25000.00,
            'total_amount' => 1275000.00,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->customer)->get(route('customer.kos.index'));

        $response->assertStatus(200);
        // Belum ada kos aktif yang disewa
        $response->assertSee('Belum Ada Kos yang Disewa');
        // Tapi muncul di bagian Booking dalam Proses
        $response->assertSee('Booking dalam Proses');
        $response->assertSee('BKG-PENDING-CHECK');
    }
}
