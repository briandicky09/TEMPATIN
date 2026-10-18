<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OwnerBookingTest extends TestCase
{
    use DatabaseTransactions;

    protected User $ownerA;
    protected User $ownerB;
    protected User $customer;
    protected Kos $kosA;
    protected Kos $kosB;
    protected Booking $bookingA;
    protected Booking $bookingB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ownerA = User::create([
            'name' => 'Owner Alpha',
            'email' => 'owner_a_' . uniqid() . '@example.com',
            'phone' => '081200000001',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->ownerB = User::create([
            'name' => 'Owner Beta',
            'email' => 'owner_b_' . uniqid() . '@example.com',
            'phone' => '081200000002',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->customer = User::create([
            'name' => 'Customer Charlie',
            'email' => 'cust_' . uniqid() . '@example.com',
            'phone' => '081200000003',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->kosA = Kos::create([
            'owner_id' => $this->ownerA->id,
            'title' => 'Kos Alpha Resident',
            'slug' => 'kos-alpha-' . uniqid(),
            'description' => 'Kos nyaman Alpha',
            'price' => 1500000.00,
            'type' => 'Putra',
            'city' => 'Jakarta Selatan',
            'address' => 'Jl. Alpha No. 1',
            'status' => 'active',
        ]);

        $this->kosB = Kos::create([
            'owner_id' => $this->ownerB->id,
            'title' => 'Kos Beta Resident',
            'slug' => 'kos-beta-' . uniqid(),
            'description' => 'Kos nyaman Beta',
            'price' => 1800000.00,
            'type' => 'Putri',
            'city' => 'Bandung',
            'address' => 'Jl. Beta No. 2',
            'status' => 'active',
        ]);

        $this->bookingA = Booking::create([
            'customer_id' => $this->customer->id,
            'kos_id' => $this->kosA->id,
            'booking_code' => Booking::generateBookingCode(),
            'tenant_name' => $this->customer->name,
            'tenant_phone' => $this->customer->phone,
            'tenant_email' => $this->customer->email,
            'start_date' => now()->addDays(3)->format('Y-m-d'),
            'end_date' => now()->addMonths(1)->addDays(3)->format('Y-m-d'),
            'duration_months' => 1,
            'kos_price' => 1500000.00,
            'subtotal' => 1500000.00,
            'admin_fee' => 25000.00,
            'total_amount' => 1525000.00,
            'status' => 'pending',
        ]);

        $this->bookingB = Booking::create([
            'customer_id' => $this->customer->id,
            'kos_id' => $this->kosB->id,
            'booking_code' => Booking::generateBookingCode(),
            'tenant_name' => $this->customer->name,
            'tenant_phone' => $this->customer->phone,
            'tenant_email' => $this->customer->email,
            'start_date' => now()->addDays(5)->format('Y-m-d'),
            'end_date' => now()->addMonths(2)->addDays(5)->format('Y-m-d'),
            'duration_months' => 2,
            'kos_price' => 1800000.00,
            'subtotal' => 3600000.00,
            'admin_fee' => 25000.00,
            'total_amount' => 3625000.00,
            'status' => 'pending',
        ]);
    }

    /**
     * 1. Owner hanya melihat booking terkait kos miliknya.
     */
    public function test_01_owner_only_sees_own_kos_bookings(): void
    {
        $response = $this->actingAs($this->ownerA)->get(route('owner.bookings.index'));

        $response->assertStatus(200);
        $response->assertSee($this->bookingA->booking_code);
        $response->assertDontSee($this->bookingB->booking_code);
    }

    /**
     * 2. Customer tidak dapat mengakses daftar booking owner (403 Forbidden).
     */
    public function test_02_customer_cannot_access_owner_bookings(): void
    {
        $response = $this->actingAs($this->customer)->get(route('owner.bookings.index'));

        $response->assertForbidden();
    }

    /**
     * 3. Owner dapat melihat detail booking miliknya.
     */
    public function test_03_owner_can_view_booking_detail(): void
    {
        $response = $this->actingAs($this->ownerA)->get(route('owner.bookings.show', $this->bookingA->booking_code));

        $response->assertStatus(200);
        $response->assertSee($this->bookingA->booking_code);
        $response->assertSee($this->customer->name);
        $response->assertSee('Setujui Booking');
        $response->assertSee('Tolak');
    }

    /**
     * 4. Owner tidak dapat melihat detail booking milik owner lain (Anti-IDOR 403).
     */
    public function test_04_owner_cannot_view_other_owner_booking(): void
    {
        $response = $this->actingAs($this->ownerA)->get(route('owner.bookings.show', $this->bookingB->booking_code));

        $response->assertForbidden();
    }

    /**
     * 5. Owner dapat menyetujui booking yang berstatus pending.
     */
    public function test_05_owner_can_approve_pending_booking(): void
    {
        $response = $this->actingAs($this->ownerA)->post(route('owner.bookings.approve', $this->bookingA->booking_code));

        $response->assertRedirect(route('owner.bookings.show', $this->bookingA->booking_code));
        $this->assertEquals('approved', $this->bookingA->fresh()->status);
    }

    /**
     * 6. Owner lain tidak dapat menyetujui booking yang bukan miliknya (403 Forbidden).
     */
    public function test_06_unauthorized_owner_cannot_approve_booking(): void
    {
        $response = $this->actingAs($this->ownerB)->post(route('owner.bookings.approve', $this->bookingA->booking_code));

        $response->assertForbidden();
        $this->assertEquals('pending', $this->bookingA->fresh()->status);
    }

    /**
     * 7. Owner dapat menolak booking dengan alasan yang valid.
     */
    public function test_07_owner_can_reject_booking_with_reason(): void
    {
        $response = $this->actingAs($this->ownerA)->post(route('owner.bookings.reject', $this->bookingA->booking_code), [
            'rejection_reason' => 'Kamar sudah terisi untuk jadwal tersebut.',
        ]);

        $response->assertRedirect(route('owner.bookings.show', $this->bookingA->booking_code));
        $this->assertEquals('rejected', $this->bookingA->fresh()->status);
        $this->assertEquals('Kamar sudah terisi untuk jadwal tersebut.', $this->bookingA->fresh()->rejection_reason);
    }

    /**
     * 8. Penolakan tanpa alasan ditolak oleh validasi backend.
     */
    public function test_08_rejection_requires_valid_reason(): void
    {
        $response = $this->actingAs($this->ownerA)->post(route('owner.bookings.reject', $this->bookingA->booking_code), [
            'rejection_reason' => '',
        ]);

        $response->assertSessionHasErrors('rejection_reason');
        $this->assertEquals('pending', $this->bookingA->fresh()->status);
    }

    /**
     * 9. Booking yang ditolak tidak dapat dibayarkan oleh customer.
     */
    public function test_09_rejected_booking_cannot_be_paid(): void
    {
        $this->bookingA->update([
            'status' => 'rejected',
            'rejection_reason' => 'Kamar penuh',
        ]);

        $response = $this->actingAs($this->customer)->get(route('member.booking.payment', [
            'slug' => $this->kosA->slug,
            'booking_code' => $this->bookingA->booking_code,
        ]));

        $response->assertRedirect(route('member.booking.show', $this->bookingA->booking_code));
        $response->assertSessionHas('error');
    }

    /**
     * 10. Booking yang sudah lunas/confirmed tidak dapat ditolak oleh owner.
     */
    public function test_10_confirmed_booking_cannot_be_rejected(): void
    {
        $this->bookingA->update(['status' => 'confirmed']);

        $response = $this->actingAs($this->ownerA)->post(route('owner.bookings.reject', $this->bookingA->booking_code), [
            'rejection_reason' => 'Batal sepihak',
        ]);

        $response->assertSessionHas('error');
        $this->assertEquals('confirmed', $this->bookingA->fresh()->status);
    }
}
