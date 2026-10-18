<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Kos;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminPlatformTest extends TestCase
{
    use DatabaseTransactions;

    protected User $admin;
    protected User $owner;
    protected User $customer;
    protected Kos $kos;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@tempatin.id',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $this->owner = User::create([
            'name' => 'Mitra Owner',
            'email' => 'owner.admin.test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'phone' => '081234500001',
        ]);

        $this->customer = User::create([
            'name' => 'Calon Penyewa',
            'email' => 'customer.admin.test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'phone' => '081234500002',
        ]);

        $this->kos = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Admin Test',
            'slug' => 'kos-admin-test',
            'type' => 'Campur',
            'price' => 1250000,
            'address' => 'Jl. Gatot Subroto 10',
            'city' => 'Jakarta Selatan',
            'status' => 'active',
        ]);
    }

    public function test_superadmin_can_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Ringkasan Eksekutif Platform');
        $response->assertSee('Total Penyewa');
    }

    public function test_customer_and_owner_are_forbidden_from_admin_dashboard(): void
    {
        // Customer forbidden
        $responseCustomer = $this->actingAs($this->customer)
            ->get(route('admin.dashboard'));
        $responseCustomer->assertStatus(403);

        // Owner forbidden
        $responseOwner = $this->actingAs($this->owner)
            ->get(route('admin.dashboard'));
        $responseOwner->assertStatus(403);

        // Guest redirected
        auth()->logout();
        $responseGuest = $this->get(route('admin.dashboard'));
        $responseGuest->assertRedirect(route('login'));
    }

    public function test_admin_can_moderate_kos_listing_status(): void
    {
        $this->assertEquals('active', $this->kos->status);

        $response = $this->actingAs($this->admin)
            ->patch(route('admin.kos.updateStatus', $this->kos->slug), [
                'status' => 'inactive',
            ]);

        $response->assertSessionHas('success');
        $this->kos->refresh();
        $this->assertEquals('inactive', $this->kos->status);
    }

    public function test_admin_can_view_users_list(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index'));

        $response->assertOk();
        $response->assertSee($this->customer->email);
        $response->assertSee($this->owner->email);
    }

    public function test_admin_can_view_bookings_audit(): void
    {
        $booking = Booking::create([
            'booking_code' => 'BK-ADMIN-AUDIT',
            'customer_id' => $this->customer->id,
            'kos_id' => $this->kos->id,
            'tenant_name' => 'Calon Penyewa',
            'tenant_email' => 'customer.admin.test@example.com',
            'tenant_phone' => '081234500002',
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'end_date' => now()->addDays(32)->format('Y-m-d'),
            'duration_months' => 1,
            'kos_price' => 1250000,
            'subtotal' => 1250000,
            'admin_fee' => 10000,
            'total_amount' => 1260000,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($this->admin)
            ->get(route('admin.bookings.index'));

        $response->assertOk();
        $response->assertSee('BK-ADMIN-AUDIT');
        $response->assertSee('1.260.000');
    }

    public function test_admin_can_moderate_and_delete_reviews(): void
    {
        $review = Review::create([
            'kos_id' => $this->kos->id,
            'user_id' => $this->customer->id,
            'reviewer_name' => 'Calon Penyewa',
            'rating' => 1,
            'comment' => 'Spam komentar tidak pantas yang harus dihapus admin.',
        ]);

        $viewResponse = $this->actingAs($this->admin)
            ->get(route('admin.reviews.index'));
        $viewResponse->assertOk();
        $viewResponse->assertSee('Spam komentar tidak pantas yang harus dihapus admin.');

        // Delete review
        $deleteResponse = $this->actingAs($this->admin)
            ->delete(route('admin.reviews.destroy', $review->id));

        $deleteResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }
}
