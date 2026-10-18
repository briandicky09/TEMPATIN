<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Kos;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class OwnerRoomTest extends TestCase
{
    use DatabaseTransactions;

    private User $owner;
    private User $otherOwner;
    private User $customer;
    private Kos $kos;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Room Test',
            'email' => 'owner_room_' . uniqid() . '@example.com',
            'phone' => '081233330001',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->otherOwner = User::create([
            'name' => 'Other Owner Room',
            'email' => 'other_owner_room_' . uniqid() . '@example.com',
            'phone' => '081233330002',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->customer = User::create([
            'name' => 'Customer Room Test',
            'email' => 'customer_room_' . uniqid() . '@example.com',
            'phone' => '081233330003',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->kos = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Melati Harmoni ' . uniqid(),
            'slug' => 'kos-melati-harmoni-' . uniqid(),
            'type' => 'Campur',
            'price' => 1500000,
            'address' => 'Jl. Harmoni No. 10',
            'city' => 'Jakarta Selatan',
            'description' => 'Kos nyaman di Jakarta Selatan',
            'rooms' => 10,
            'status' => 'active',
        ]);
    }

    public function test_01_owner_can_view_room_inventory()
    {
        $response = $this->actingAs($this->owner)
            ->get(route('owner.kos.rooms.index', $this->kos->slug));

        $response->assertStatus(200);
        $response->assertSee('Inventaris Kamar');
        $response->assertSee($this->kos->title);
    }

    public function test_02_owner_can_add_room()
    {
        $response = $this->actingAs($this->owner)
            ->post(route('owner.kos.rooms.store', $this->kos->slug), [
                'room_number' => '101',
                'floor' => 'Lantai 1',
                'room_type' => 'Deluxe AC',
                'price_override' => 1750000,
                'status' => 'available',
                'description' => 'Dekat pintu masuk',
            ]);

        $response->assertRedirect(route('owner.kos.rooms.index', $this->kos->slug));
        $this->assertDatabaseHas('rooms', [
            'kos_id' => $this->kos->id,
            'room_number' => '101',
            'floor' => 'Lantai 1',
            'room_type' => 'Deluxe AC',
            'price_override' => 1750000,
            'status' => 'available',
        ]);
    }

    public function test_03_duplicate_room_number_on_same_kos_is_rejected()
    {
        Room::create([
            'kos_id' => $this->kos->id,
            'room_number' => '101',
            'status' => 'available',
        ]);

        $response = $this->actingAs($this->owner)
            ->post(route('owner.kos.rooms.store', $this->kos->slug), [
                'room_number' => '101',
                'status' => 'available',
            ]);

        $response->assertSessionHasErrors('room_number');
        $this->assertEquals(1, Room::where('kos_id', $this->kos->id)->where('room_number', '101')->count());
    }

    public function test_04_owner_can_update_room()
    {
        $room = Room::create([
            'kos_id' => $this->kos->id,
            'room_number' => '102',
            'status' => 'available',
        ]);

        $response = $this->actingAs($this->owner)
            ->put(route('owner.kos.rooms.update', [$this->kos->slug, $room->id]), [
                'room_number' => '102-A',
                'status' => 'occupied',
                'floor' => 'Lantai 1',
                'room_type' => 'Standar',
            ]);

        $response->assertRedirect(route('owner.kos.rooms.index', $this->kos->slug));
        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'room_number' => '102-A',
            'status' => 'occupied',
        ]);
    }

    public function test_05_owner_can_delete_room()
    {
        $room = Room::create([
            'kos_id' => $this->kos->id,
            'room_number' => '103',
            'status' => 'available',
        ]);

        $response = $this->actingAs($this->owner)
            ->delete(route('owner.kos.rooms.destroy', [$this->kos->slug, $room->id]));

        $response->assertRedirect(route('owner.kos.rooms.index', $this->kos->slug));
        $this->assertDatabaseMissing('rooms', ['id' => $room->id]);
    }

    public function test_06_room_with_active_booking_cannot_be_deleted()
    {
        $room = Room::create([
            'kos_id' => $this->kos->id,
            'room_number' => '104',
            'status' => 'occupied',
        ]);

        Booking::create([
            'customer_id' => $this->customer->id,
            'kos_id' => $this->kos->id,
            'room_id' => $room->id,
            'booking_code' => Booking::generateBookingCode(),
            'tenant_name' => $this->customer->name,
            'tenant_phone' => $this->customer->phone,
            'tenant_email' => $this->customer->email,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'duration_months' => 1,
            'kos_price' => 1500000.00,
            'subtotal' => 1500000.00,
            'admin_fee' => 25000.00,
            'total_amount' => 1525000.00,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($this->owner)
            ->delete(route('owner.kos.rooms.destroy', [$this->kos->slug, $room->id]));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('rooms', ['id' => $room->id]);
    }

    public function test_07_owner_a_cannot_manage_rooms_of_owner_b()
    {
        $response = $this->actingAs($this->otherOwner)
            ->get(route('owner.kos.rooms.index', $this->kos->slug));

        $response->assertStatus(403);
    }

    public function test_08_customer_cannot_access_owner_rooms()
    {
        $response = $this->actingAs($this->customer)
            ->get(route('owner.kos.rooms.index', $this->kos->slug));

        $response->assertStatus(403);
    }
}
