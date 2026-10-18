<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Kos;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VerifiedReviewTest extends TestCase
{
    use DatabaseTransactions;

    private User $ownerA;
    private User $ownerB;
    private User $customerVerified;
    private User $customerUnverified;
    private Kos $kosA;
    private Kos $kosB;
    private Booking $booking;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ownerA = User::create([
            'name' => 'Owner Alpha',
            'email' => 'owner_alpha_' . uniqid() . '@example.com',
            'phone' => '081211110001',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->ownerB = User::create([
            'name' => 'Owner Beta',
            'email' => 'owner_beta_' . uniqid() . '@example.com',
            'phone' => '081211110002',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->customerVerified = User::create([
            'name' => 'Customer Verified',
            'email' => 'cust_verified_' . uniqid() . '@example.com',
            'phone' => '081211110003',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->customerUnverified = User::create([
            'name' => 'Customer Unverified',
            'email' => 'cust_unverified_' . uniqid() . '@example.com',
            'phone' => '081211110004',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->kosA = Kos::create([
            'owner_id' => $this->ownerA->id,
            'title' => 'Kos Alpha Residence ' . uniqid(),
            'slug' => 'kos-alpha-res-' . uniqid(),
            'type' => 'Campur',
            'price' => 1500000,
            'address' => 'Jl. Alpha No. 1',
            'city' => 'Jakarta Selatan',
            'description' => 'Kos Alpha Nyaman',
            'rooms' => 10,
            'status' => 'active',
        ]);

        $this->kosB = Kos::create([
            'owner_id' => $this->ownerB->id,
            'title' => 'Kos Beta Residence ' . uniqid(),
            'slug' => 'kos-beta-res-' . uniqid(),
            'type' => 'Putri',
            'price' => 1800000,
            'address' => 'Jl. Beta No. 2',
            'city' => 'Bandung',
            'description' => 'Kos Beta Nyaman',
            'rooms' => 8,
            'status' => 'active',
        ]);

        $this->booking = Booking::create([
            'customer_id' => $this->customerVerified->id,
            'kos_id' => $this->kosA->id,
            'booking_code' => Booking::generateBookingCode(),
            'tenant_name' => $this->customerVerified->name,
            'tenant_phone' => $this->customerVerified->phone,
            'tenant_email' => $this->customerVerified->email,
            'start_date' => now()->toDateString(),
            'end_date' => now()->addMonth()->toDateString(),
            'duration_months' => 1,
            'kos_price' => 1500000.00,
            'subtotal' => 1500000.00,
            'admin_fee' => 25000.00,
            'total_amount' => 1525000.00,
            'status' => 'confirmed',
        ]);
    }

    public function test_01_guest_cannot_post_review()
    {
        $response = $this->post(route('kos.review.store', $this->kosA->slug), [
            'rating' => 5,
            'comment' => 'Kos sangat bersih dan nyaman.',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_02_customer_without_lease_cannot_post_review()
    {
        $response = $this->actingAs($this->customerUnverified)
            ->post(route('kos.review.store', $this->kosA->slug), [
                'rating' => 5,
                'comment' => 'Saya belum pernah sewa tapi mau ulas.',
            ]);

        $response->assertSessionHas('review_error');
        $this->assertDatabaseMissing('reviews', [
            'user_id' => $this->customerUnverified->id,
            'kos_id' => $this->kosA->id,
        ]);
    }

    public function test_03_verified_tenant_can_post_review()
    {
        $response = $this->actingAs($this->customerVerified)
            ->post(route('kos.review.store', $this->kosA->slug), [
                'rating' => 5,
                'comment' => 'Pengalaman tinggal di Kos Alpha sangat memuaskan, fasilitas lengkap.',
            ]);

        $response->assertSessionHas('review_success');
        $this->assertDatabaseHas('reviews', [
            'user_id' => $this->customerVerified->id,
            'kos_id' => $this->kosA->id,
            'booking_id' => $this->booking->id,
            'reviewer_name' => $this->customerVerified->name,
            'is_verified_tenant' => true,
            'rating' => 5,
        ]);
    }

    public function test_04_tenant_cannot_submit_duplicate_review_for_same_kos()
    {
        Review::create([
            'kos_id' => $this->kosA->id,
            'user_id' => $this->customerVerified->id,
            'booking_id' => $this->booking->id,
            'reviewer_name' => $this->customerVerified->name,
            'is_verified_tenant' => true,
            'rating' => 5,
            'comment' => 'Ulasan pertama.',
        ]);

        $response = $this->actingAs($this->customerVerified)
            ->post(route('kos.review.store', $this->kosA->slug), [
                'rating' => 4,
                'comment' => 'Mencoba ulasan kedua kalinya.',
            ]);

        $response->assertSessionHas('review_error');
        $this->assertEquals(1, Review::where('kos_id', $this->kosA->id)->where('user_id', $this->customerVerified->id)->count());
    }

    public function test_05_owner_can_view_reviews_page()
    {
        Review::create([
            'kos_id' => $this->kosA->id,
            'user_id' => $this->customerVerified->id,
            'booking_id' => $this->booking->id,
            'reviewer_name' => $this->customerVerified->name,
            'is_verified_tenant' => true,
            'rating' => 5,
            'comment' => 'Ulasan kos alpha.',
        ]);

        $response = $this->actingAs($this->ownerA)
            ->get(route('owner.kos.penilaian'));

        $response->assertStatus(200);
        $response->assertSee('Penilaian');
        $response->assertSee($this->kosA->title);
    }

    public function test_06_owner_can_reply_to_review_on_their_kos()
    {
        $review = Review::create([
            'kos_id' => $this->kosA->id,
            'user_id' => $this->customerVerified->id,
            'booking_id' => $this->booking->id,
            'reviewer_name' => $this->customerVerified->name,
            'is_verified_tenant' => true,
            'rating' => 5,
            'comment' => 'Kamar sangat bersih dan rapi.',
        ]);

        $response = $this->actingAs($this->ownerA)
            ->post(route('owner.kos.reviews.reply', $review->id), [
                'reply' => 'Terima kasih atas ulasannya kak, senang bisa melayani.',
            ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('reviews', [
            'id' => $review->id,
            'reply' => 'Terima kasih atas ulasannya kak, senang bisa melayani.',
        ]);
    }

    public function test_07_owner_a_cannot_reply_to_review_on_owner_b_kos()
    {
        $review = Review::create([
            'kos_id' => $this->kosB->id,
            'user_id' => $this->customerVerified->id,
            'reviewer_name' => $this->customerVerified->name,
            'is_verified_tenant' => true,
            'rating' => 4,
            'comment' => 'Ulasan di kos beta.',
        ]);

        $response = $this->actingAs($this->ownerA)
            ->post(route('owner.kos.reviews.reply', $review->id), [
                'reply' => 'Balasan tidak sah dari owner lain.',
            ]);

        $response->assertStatus(403);
    }
}
