<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ContentPagesTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test promo page loads successfully with verified vouchers and image.
     */
    public function test_promo_page_renders_successfully(): void
    {
        $response = $this->get('/promo');

        $response->assertStatus(200);
        $response->assertSee('Hemat Lebih Banyak untuk Hunian Kos Impianmu');
        $response->assertSee('KOSBARU20');
        $response->assertSee('FREEADMIN');
        $response->assertSee('SEMESTERAN500');
        $response->assertSee('promo-hero.jpg');
    }

    /**
     * Test artikel page loads successfully with articles, guide checklists and image.
     */
    public function test_artikel_page_renders_successfully(): void
    {
        $response = $this->get('/artikel');

        $response->assertStatus(200);
        $response->assertSee('Wawasan & Panduan Memilih Hunian Ideal');
        $response->assertSee('Cara Memilih Kos yang Aman');
        $response->assertSee('artikel-survey.jpg');
        $response->assertSee('artikel-budget.jpg');
    }

    /**
     * Test tentang kami page loads successfully with brand narrative and community image.
     */
    public function test_about_page_renders_successfully(): void
    {
        $response = $this->get('/tentang');

        $response->assertStatus(200);
        $response->assertSee('Mendefinisikan Ulang Pengalaman Mencari Kos di Indonesia');
        $response->assertSee('Transparansi Total');
        $response->assertSee('Verifikasi Lapangan');
        $response->assertSee('tentang-hero.jpg');
    }

    /**
     * Test pusat bantuan page loads successfully with help categories, FAQs, and concierge image.
     */
    public function test_contact_page_renders_successfully(): void
    {
        $response = $this->get('/kontak');

        $response->assertStatus(200);
        $response->assertSee('Kami Siap Membantu Kenyamanan Tinggalmu');
        $response->assertSee('bantuan-support.jpg');
        $response->assertSee('Pencarian & Survei');
        $response->assertSee('hello@tempatin.id');
    }

    /**
     * Test landing page is functional and protected.
     */
    public function test_landing_page_renders_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('TEMPATIN');
    }

    /**
     * Test member routes for content pages.
     */
    public function test_member_content_pages_render_successfully(): void
    {
        $member = User::where('role', 'customer')->first();
        if (!$member) {
            $member = User::create([
                'name' => 'Member Tester',
                'email' => 'member.tester@example.com',
                'phone' => '081234567891',
                'password' => bcrypt('password123'),
                'role' => 'customer',
            ]);
        }

        $this->actingAs($member)->get('/member/promo')->assertStatus(200);
        $this->actingAs($member)->get('/member/artikel')->assertStatus(200);
        $this->actingAs($member)->get('/member/tentang')->assertStatus(200);
        $this->actingAs($member)->get('/member/kontak')->assertStatus(200);
    }
}
