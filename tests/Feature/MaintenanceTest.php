<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Kos;
use App\Models\MaintenanceReport;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MaintenanceTest extends TestCase
{
    use DatabaseTransactions;

    protected User $owner;
    protected User $otherOwner;
    protected User $tenant;
    protected User $stranger;
    protected Kos $kos;
    protected Room $room;
    protected Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->owner = User::create([
            'name' => 'Owner Maintenance',
            'email' => 'owner.maint@example.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'phone' => '081222221111',
        ]);

        $this->otherOwner = User::create([
            'name' => 'Other Owner Maint',
            'email' => 'other.maint@example.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'phone' => '081222223333',
        ]);

        $this->tenant = User::create([
            'name' => 'Penghuni Maint',
            'email' => 'tenant.maint@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'phone' => '081222225555',
        ]);

        $this->stranger = User::create([
            'name' => 'Orang Lain Maint',
            'email' => 'stranger.maint@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'phone' => '081222227777',
        ]);

        $this->kos = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Griya Sejahtera',
            'slug' => 'kos-griya-sejahtera',
            'type' => 'Campur',
            'price' => 1100000,
            'address' => 'Jl. Sejahtera 8',
            'city' => 'Semarang',
            'status' => 'active',
        ]);

        $this->room = Room::create([
            'kos_id' => $this->kos->id,
            'room_number' => '102',
            'floor' => 1,
            'status' => 'occupied',
        ]);

        $this->booking = Booking::create([
            'booking_code' => 'BK-MAINT-TEST',
            'customer_id' => $this->tenant->id,
            'kos_id' => $this->kos->id,
            'room_id' => $this->room->id,
            'tenant_name' => 'Penghuni Maint',
            'tenant_email' => 'tenant.maint@example.com',
            'tenant_phone' => '081222225555',
            'start_date' => now()->subDays(5)->format('Y-m-d'),
            'end_date' => now()->addDays(25)->format('Y-m-d'),
            'duration_months' => 1,
            'kos_price' => 1100000,
            'subtotal' => 1100000,
            'admin_fee' => 10000,
            'total_amount' => 1110000,
            'status' => 'active',
        ]);
    }

    public function test_active_tenant_can_submit_maintenance_ticket_with_photo(): void
    {
        $photo = UploadedFile::fake()->image('keran_bocor.jpg', 640, 480);

        $response = $this->actingAs($this->tenant)
            ->post(route('member.maintenance.store'), [
                'booking_id' => $this->booking->id,
                'title' => 'Keran Kamar Mandi Bocor',
                'description' => 'Air terus menetes meskipun keran sudah ditutup kencang.',
                'photo' => $photo,
            ]);

        $response->assertRedirect(route('member.maintenance.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('maintenance_reports', [
            'booking_id' => $this->booking->id,
            'customer_id' => $this->tenant->id,
            'kos_id' => $this->kos->id,
            'room_id' => $this->room->id,
            'title' => 'Keran Kamar Mandi Bocor',
            'status' => 'open',
        ]);

        // Owner receives notification
        $this->assertEquals(1, $this->owner->unreadNotifications()->count());
    }

    public function test_stranger_cannot_submit_report_for_another_tenants_booking(): void
    {
        $response = $this->actingAs($this->stranger)
            ->post(route('member.maintenance.store'), [
                'booking_id' => $this->booking->id,
                'title' => 'Coba Lapor Ilegal',
                'description' => 'Mencoba melaporkan booking milik orang lain.',
            ]);

        $response->assertStatus(403);
    }

    public function test_owner_can_view_and_update_ticket_status(): void
    {
        $report = MaintenanceReport::create([
            'booking_id' => $this->booking->id,
            'customer_id' => $this->tenant->id,
            'kos_id' => $this->kos->id,
            'room_id' => $this->room->id,
            'title' => 'Kunci Kamar Rusak',
            'description' => 'Gagang kunci pintu depan macet.',
            'status' => 'open',
        ]);

        $viewResponse = $this->actingAs($this->owner)
            ->get(route('owner.maintenance.index'));
        $viewResponse->assertOk();
        $viewResponse->assertSee('Kunci Kamar Rusak');

        // Owner sets status to in_progress with notes
        $updateResponse = $this->actingAs($this->owner)
            ->patch(route('owner.maintenance.updateStatus', $report->id), [
                'status' => 'in_progress',
                'owner_notes' => 'Tukang servis kunci akan datang sore ini pukul 15.00 WIB.',
            ]);

        $updateResponse->assertSessionHas('success');

        $report->refresh();
        $this->assertEquals('in_progress', $report->status);
        $this->assertEquals('Tukang servis kunci akan datang sore ini pukul 15.00 WIB.', $report->owner_notes);

        // Tenant receives notification
        $this->assertEquals(1, $this->tenant->unreadNotifications()->count());
    }

    public function test_other_owner_cannot_modify_maintenance_ticket(): void
    {
        $report = MaintenanceReport::create([
            'booking_id' => $this->booking->id,
            'customer_id' => $this->tenant->id,
            'kos_id' => $this->kos->id,
            'room_id' => $this->room->id,
            'title' => 'Lampu Kamar Putus',
            'description' => 'Lampu utama tidak menyala.',
            'status' => 'open',
        ]);

        $response = $this->actingAs($this->otherOwner)
            ->patch(route('owner.maintenance.updateStatus', $report->id), [
                'status' => 'resolved',
            ]);

        $response->assertStatus(403);
    }

    public function test_owner_can_view_active_tenants(): void
    {
        $response = $this->actingAs($this->owner)
            ->get(route('owner.penghuni.index'));

        $response->assertOk();
        $response->assertSee('Penghuni Maint');
        $response->assertSee('Kos Griya Sejahtera');
    }
}
