<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use DatabaseTransactions;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'Reset Test User',
            'email' => 'reset_test_' . uniqid() . '@example.com',
            'phone' => '081299990001',
            'password' => Hash::make('oldpassword123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }

    public function test_01_guest_can_view_forgot_password_page()
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertSee('Lupa Kata Sandi?');
        $response->assertSee('Kirim Tautan Reset Sandi');
    }

    public function test_02_email_is_required_for_reset_link()
    {
        $response = $this->post(route('password.email'), [
            'email' => '',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_03_valid_user_can_request_password_reset_link()
    {
        $response = $this->post(route('password.email'), [
            'email' => $this->user->email,
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => $this->user->email,
        ]);
    }

    public function test_04_user_can_view_reset_password_page_with_token()
    {
        $token = Password::createToken($this->user);

        $response = $this->get(route('password.reset', [
            'token' => $token,
            'email' => $this->user->email,
        ]));

        $response->assertStatus(200);
        $response->assertSee('Buat Kata Sandi Baru');
        $response->assertSee($this->user->email);
    }

    public function test_05_user_can_reset_password_with_valid_token()
    {
        $token = Password::createToken($this->user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $this->user->email,
            'password' => 'newpassword1234',
            'password_confirmation' => 'newpassword1234',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');

        // Verifikasi password baru dapat digunakan untuk login
        $this->user->refresh();
        $this->assertTrue(Hash::check('newpassword1234', $this->user->password));
    }

    public function test_06_password_must_be_confirmed_and_min_8_chars()
    {
        $token = Password::createToken($this->user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $this->user->email,
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_07_invalid_token_is_rejected()
    {
        $response = $this->post(route('password.update'), [
            'token' => 'invalid-token-12345',
            'email' => $this->user->email,
            'password' => 'newpassword1234',
            'password_confirmation' => 'newpassword1234',
        ]);

        $response->assertSessionHasErrors('email');
    }
}
