<?php

namespace Tests\Feature;

use App\Models\Conversation;
use App\Models\Kos;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ChatTest extends TestCase
{
    use DatabaseTransactions;

    protected User $owner;
    protected User $customer;
    protected User $stranger;
    protected Kos $kos;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Kos',
            'email' => 'owner.chat@example.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'phone' => '081299998888',
        ]);

        $this->customer = User::create([
            'name' => 'Calon Penyewa',
            'email' => 'customer.chat@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'phone' => '081277776666',
        ]);

        $this->stranger = User::create([
            'name' => 'Orang Lain',
            'email' => 'stranger.chat@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'phone' => '081255554444',
        ]);

        $this->kos = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Permata Hijau',
            'slug' => 'kos-permata-hijau',
            'type' => 'Campur',
            'price' => 1200000,
            'address' => 'Jl. Hijau Indah No 10',
            'city' => 'Jakarta Selatan',
            'status' => 'active',
        ]);
    }

    public function test_customer_can_start_chat_from_kos_detail(): void
    {
        $response = $this->actingAs($this->customer)
            ->post(route('chat.start', $this->kos->slug), [
                'message' => 'Halo apakah kamar kos ini masih ada yang kosong?',
            ]);

        $conversation = Conversation::first();
        $this->assertNotNull($conversation);
        $this->assertEquals($this->kos->id, $conversation->kos_id);
        $this->assertEquals($this->customer->id, $conversation->customer_id);
        $this->assertEquals($this->owner->id, $conversation->owner_id);

        $response->assertRedirect(route('chat.show', $conversation));

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'sender_id' => $this->customer->id,
            'message' => 'Halo apakah kamar kos ini masih ada yang kosong?',
        ]);

        // Verify notification sent to owner
        $this->assertEquals(1, $this->owner->unreadNotifications()->count());
        $this->assertStringContainsString('Pesan Baru', $this->owner->notifications()->first()->data['title']);
    }

    public function test_owner_can_view_conversation_and_reply(): void
    {
        $conversation = Conversation::create([
            'kos_id' => $this->kos->id,
            'customer_id' => $this->customer->id,
            'owner_id' => $this->owner->id,
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $this->customer->id,
            'message' => 'Pertanyaan awal dari calon penyewa',
        ]);

        $response = $this->actingAs($this->owner)
            ->get(route('chat.show', $conversation));

        $response->assertOk();
        $response->assertSee('Pertanyaan awal dari calon penyewa');

        // Owner sends reply
        $replyResponse = $this->actingAs($this->owner)
            ->post(route('chat.send', $conversation), [
                'message' => 'Halo masih ada 2 kamar kosong di lantai 1.',
            ]);

        $replyResponse->assertRedirect(route('chat.show', $conversation));

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $conversation->id,
            'sender_id' => $this->owner->id,
            'message' => 'Halo masih ada 2 kamar kosong di lantai 1.',
        ]);

        // Customer receives notification
        $this->assertEquals(1, $this->customer->unreadNotifications()->count());
        $this->assertStringContainsString('Pesan Baru', $this->customer->notifications()->first()->data['title']);
    }

    public function test_stranger_cannot_access_private_conversation(): void
    {
        $conversation = Conversation::create([
            'kos_id' => $this->kos->id,
            'customer_id' => $this->customer->id,
            'owner_id' => $this->owner->id,
        ]);

        $response = $this->actingAs($this->stranger)
            ->get(route('chat.show', $conversation));

        $response->assertStatus(403);
    }

    public function test_guest_is_redirected_to_login_when_starting_chat(): void
    {
        $response = $this->post(route('chat.start', $this->kos->slug), [
            'message' => 'Halo dari tamu',
        ]);

        $response->assertRedirect(route('login'));
    }
}
