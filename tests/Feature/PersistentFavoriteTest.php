<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PersistentFavoriteTest extends TestCase
{
    use DatabaseTransactions;

    private User $customer;
    private User $owner;
    private Kos $kos;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Fav Test',
            'email' => 'owner_fav_' . uniqid() . '@example.com',
            'phone' => '081277770001',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->customer = User::create([
            'name' => 'Customer Fav Test',
            'email' => 'cust_fav_' . uniqid() . '@example.com',
            'phone' => '081277770002',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->kos = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Favorit Indah ' . uniqid(),
            'slug' => 'kos-fav-indah-' . uniqid(),
            'type' => 'Putri',
            'price' => 1200000,
            'address' => 'Jl. Mawar No. 5',
            'city' => 'Yogyakarta',
            'description' => 'Kos putri nyaman dekat kampus',
            'rooms' => 8,
            'status' => 'active',
        ]);
    }

    public function test_01_customer_toggle_adds_to_database_favorites()
    {
        $response = $this->actingAs($this->customer)
            ->postJson(route('kos.favorit.toggle'), [
                'slug' => $this->kos->slug,
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_favorite' => true,
        ]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $this->customer->id,
            'kos_id' => $this->kos->id,
        ]);
    }

    public function test_02_customer_toggle_again_removes_from_database_favorites()
    {
        Favorite::create([
            'user_id' => $this->customer->id,
            'kos_id' => $this->kos->id,
        ]);

        $response = $this->actingAs($this->customer)
            ->postJson(route('kos.favorit.toggle'), [
                'slug' => $this->kos->slug,
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_favorite' => false,
        ]);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $this->customer->id,
            'kos_id' => $this->kos->id,
        ]);
    }

    public function test_03_favorited_kos_appears_on_member_favorit_page_from_database()
    {
        Favorite::create([
            'user_id' => $this->customer->id,
            'kos_id' => $this->kos->id,
        ]);

        // Akses tanpa session pre-fill
        $response = $this->actingAs($this->customer)
            ->get(route('member.favorit'));

        $response->assertStatus(200);
        $response->assertSee($this->kos->title);
    }
}
