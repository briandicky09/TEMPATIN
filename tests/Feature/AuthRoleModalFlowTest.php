<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthRoleModalFlowTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test modal role pilihan tampil di navbar guest.
     */
    public function test_homepage_navbar_contains_auth_role_modal_for_guest(): void
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('id="authRoleModal"', false);
        $response->assertSee('Masuk ke TEMPATIN');
        $response->assertSee('Saya ingin masuk sebagai');
        $response->assertSee('Pencari Kos');
        $response->assertSee('Pemilik Kos');
        $response->assertSee('data-target="#authRoleModal"', false);
    }

    /**
     * Test halaman login menerima parameter role pencari kos.
     */
    public function test_login_page_reflects_customer_role(): void
    {
        $response = $this->get(route('login', ['role' => 'customer']));

        $response->assertStatus(200);
        $response->assertSee('Masuk sebagai Pencari Kos');
        $response->assertSee(route('register', ['role' => 'customer']));
        $response->assertSee(route('login', ['role' => 'owner']));
    }

    /**
     * Test halaman login menerima parameter role pemilik kos.
     */
    public function test_login_page_reflects_owner_role(): void
    {
        $response = $this->get(route('login', ['role' => 'owner']));

        $response->assertStatus(200);
        $response->assertSee('Masuk sebagai Pemilik Kos');
        $response->assertSee(route('register', ['role' => 'owner']));
        $response->assertSee(route('login', ['role' => 'customer']));
    }

    /**
     * Test halaman register tidak lagi memiliki radio button pilihan role,
     * melainkan menggunakan hidden input role customer.
     */
    public function test_register_page_has_no_role_radio_buttons_and_sets_customer(): void
    {
        $response = $this->get(route('register', ['role' => 'customer']));

        $response->assertStatus(200);
        $response->assertSee('Daftar Akun Pencari Kos');
        // Tidak boleh ada input type="radio" untuk role
        $response->assertDontSee('type="radio" id="role-member"', false);
        $response->assertDontSee('type="radio" id="role-owner"', false);
        // Memiliki hidden input role dengan value customer
        $response->assertSee('<input type="hidden" name="role" id="reg-role" value="customer">', false);
        // Tidak ada metode daftar dengan Google di form daftar
        $response->assertDontSee('Daftar dengan Google');
        $response->assertDontSee('btn-google-register');
        // Memiliki placeholder sesuai gambar referensi
        $response->assertSee('Masukkan nama lengkap sesuai identitas');
        $response->assertSee('Isi dengan nomor handphone yang aktif');
        $response->assertSee('toggle-password-visibility');
    }

    /**
     * Test halaman register untuk pemilik kos tidak memiliki radio button
     * dan menggunakan hidden input role owner.
     */
    public function test_register_page_has_no_role_radio_buttons_and_sets_owner(): void
    {
        $response = $this->get(route('register', ['role' => 'owner']));

        $response->assertStatus(200);
        $response->assertSee('Daftar Akun Pemilik Kos');
        $response->assertDontSee('type="radio" id="role-member"', false);
        $response->assertDontSee('type="radio" id="role-owner"', false);
        $response->assertSee('<input type="hidden" name="role" id="reg-role" value="owner">', false);
    }

    /**
     * Test proses registrasi form dengan role tersembunyi berhasil membuat user customer.
     */
    public function test_registration_form_submission_with_hidden_role_customer(): void
    {
        $email = 'flow-customer-' . uniqid() . '@test.com';

        $response = $this->post(route('register'), [
            'nama' => 'Test Flow Customer',
            'handphone' => '081234567890',
            'email' => $email,
            'role' => 'customer',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'agree' => '1',
        ]);

        $response->assertRedirect(route('member.home'));
        $this->assertAuthenticated();

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals('customer', $user->role);
    }

    /**
     * Test proses registrasi form dengan role tersembunyi berhasil membuat user owner.
     */
    public function test_registration_form_submission_with_hidden_role_owner(): void
    {
        $email = 'flow-owner-' . uniqid() . '@test.com';

        $response = $this->post(route('register'), [
            'nama' => 'Test Flow Owner',
            'handphone' => '081234567899',
            'email' => $email,
            'role' => 'owner',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'agree' => '1',
        ]);

        $response->assertRedirect(route('owner.dashboard'));
        $this->assertAuthenticated();

        $user = User::where('email', $email)->first();
        $this->assertNotNull($user);
        $this->assertEquals('owner', $user->role);
    }
}
