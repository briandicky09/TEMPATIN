<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MemberNavbarTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test navbar for guest displays login and cari kos.
     */
    public function test_guest_navbar_shows_login_and_search(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Masuk');
        $response->assertSee('Cari Kos');
        $response->assertDontSee('member-nav-items');
    }

    /**
     * Test member navbar displays horizontal menus, empty profile avatar, and dropdown.
     */
    public function test_member_navbar_displays_all_menus_and_empty_avatar(): void
    {
        $member = User::where('role', 'customer')->first();
        if (!$member) {
            $member = User::create([
                'name' => 'Reinald Oryza Test',
                'email' => 'reinald.test@example.com',
                'phone' => '081234567890',
                'password' => bcrypt('password123'),
                'role' => 'customer',
            ]);
        }

        $response = $this->actingAs($member)->get('/member');

        $response->assertStatus(200);
        // Menus from Image 2
        $response->assertSee('Cari Kos');
        $response->assertSee('Favorit');
        $response->assertSee('Chat');
        $response->assertSee('Notifikasi');
        $response->assertSee('Lainnya');
        // Profile dropdown items
        $response->assertSee('Edit Profil');
        $response->assertSee('Tagihan & Invoice');
        $response->assertSee('Keluar');
        // Notification popover
        $response->assertSee('memberNotificationPopover');
        $response->assertSee('Belum ada notifikasi...');
        // Empty profile avatar trigger
        $response->assertSee('member-avatar-btn');
        $response->assertSee('member-avatar-circle');
    }

    /**
     * Test favorit page is accessible for member.
     */
    public function test_member_can_access_favorit_page(): void
    {
        $member = User::where('role', 'customer')->first();
        if (!$member) {
            $member = User::create([
                'name' => 'Reinald Oryza Test',
                'email' => 'reinald.test@example.com',
                'phone' => '081234567890',
                'password' => bcrypt('password123'),
                'role' => 'customer',
            ]);
        }

        $response = $this->actingAs($member)->get('/member/favorit');
        $response->assertStatus(200);
        $response->assertSee('Kos Favorit');
    }

    /**
     * Test member can update their profile.
     */
    public function test_member_can_update_profile(): void
    {
        $member = User::where('role', 'customer')->first();
        if (!$member) {
            $member = User::create([
                'name' => 'Reinald Oryza Test',
                'email' => 'reinald.test@example.com',
                'phone' => '081234567890',
                'password' => bcrypt('password123'),
                'role' => 'customer',
            ]);
        }

        $response = $this->actingAs($member)->put('/member/profil', [
            'name' => 'Reinald Updated',
            'phone' => '089999999999',
        ]);

        $response->assertRedirect(route('member.profile'));
        $response->assertSessionHas('success');

        $member->refresh();
        $this->assertEquals('Reinald Updated', $member->name);
        $this->assertEquals('089999999999', $member->phone);
    }

    /**
     * Test toggle favorite via AJAX and display on favorit page.
     */
    public function test_member_can_toggle_favorite_and_see_in_favorit_page(): void
    {
        $member = User::where('role', 'customer')->first();
        if (!$member) {
            $member = User::create([
                'name' => 'Reinald Oryza Test',
                'email' => 'reinald.test@example.com',
                'phone' => '081234567890',
                'password' => bcrypt('password123'),
                'role' => 'customer',
            ]);
        }

        $kos = \App\Models\Kos::where('status', 'active')->first();
        if (!$kos) {
            $kos = \App\Models\Kos::create([
                'title' => 'Kos Test Favorit',
                'slug' => 'kos-test-favorit',
                'type' => 'Putri',
                'status' => 'active',
                'price' => 1000000,
                'city' => 'Jakarta',
                'owner_id' => $member->id,
            ]);
        }

        // Toggle add favorite
        $response = $this->actingAs($member)->postJson(route('kos.favorit.toggle'), [
            'slug' => $kos->slug,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_favorite' => true,
        ]);

        // Check favorit page displays it with session
        $pageResponse = $this->actingAs($member)
            ->withSession(['member_favorites' => [$kos->slug]])
            ->get('/member/favorit');
        $pageResponse->assertStatus(200);
        $pageResponse->assertSee($kos->title);
        $pageResponse->assertSee('ts-card-badge-type');
    }

    /**
     * Test member can upload profile photo and navbar shows the photo.
     */
    public function test_member_can_upload_avatar_and_navbar_shows_avatar_image(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $member = User::where('role', 'customer')->first();
        if (!$member) {
            $member = User::create([
                'name' => 'Reinald Oryza Test',
                'email' => 'reinald.test@example.com',
                'phone' => '081234567890',
                'password' => bcrypt('password123'),
                'role' => 'customer',
            ]);
        }

        $file = \Illuminate\Http\UploadedFile::fake()->create('my-photo.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($member)->put('/member/profil', [
            'name' => 'Reinald With Photo',
            'avatar' => $file,
        ]);

        $response->assertRedirect(route('member.profile'));
        $response->assertSessionHas('success');

        $member->refresh();
        $this->assertNotNull($member->avatar);
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($member->avatar);

        // Navbar now shows the uploaded image
        $navResponse = $this->actingAs($member)->get('/member');
        $navResponse->assertStatus(200);
        $navResponse->assertSee('navAvatarImg');
        $navResponse->assertSee($member->avatar);
    }
}


