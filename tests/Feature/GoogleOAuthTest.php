<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class GoogleOAuthTest extends TestCase
{
    use DatabaseTransactions;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Helper to mock Socialite Google driver.
     */
    protected function mockSocialiteUser(string $id, string $email, string $name = 'Google User', ?string $avatar = null, bool $verified = true): void
    {
        $socialiteUser = new SocialiteUser();
        $socialiteUser->id = $id;
        $socialiteUser->email = $email;
        $socialiteUser->name = $name;
        $socialiteUser->avatar = $avatar;
        $socialiteUser->user = [
            'id' => $id,
            'email' => $email,
            'name' => $name,
            'picture' => $avatar,
            'email_verified' => $verified,
        ];

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('user')->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);
    }

    /**
     * Test login page displays Google Login button.
     */
    public function test_login_page_displays_google_login_button(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Masuk dengan Google');
        $response->assertSee(route('auth.google', ['action' => 'login']));
    }

    /**
     * Test register page does NOT display Google method and has role context.
     */
    public function test_register_page_does_not_display_google_method(): void
    {
        $response = $this->get(route('register', ['role' => 'customer']));

        $response->assertStatus(200);
        $response->assertDontSee('Daftar dengan Google');
        $response->assertDontSee('btn-google-register');
        $response->assertSee('Daftar Akun Pencari Kos');
        $response->assertSee('name="role"', false);

        $responseOwner = $this->get(route('register', ['role' => 'owner']));
        $responseOwner->assertStatus(200);
        $responseOwner->assertDontSee('Daftar dengan Google');
        $responseOwner->assertSee('Daftar Akun Pemilik Kos');
    }

    /**
     * Test redirect to Google saves action and redirects.
     */
    public function test_redirect_to_google_for_login(): void
    {
        $response = $this->get(route('auth.google', ['action' => 'login']));

        // Should redirect to Google accounts URL
        $response->assertStatus(302);
        $this->assertStringContainsString('accounts.google.com', $response->headers->get('Location'));
        $this->assertEquals('login', session('google_oauth_action'));
    }

    /**
     * Test redirect to Google for registration saves selected role.
     */
    public function test_redirect_to_google_for_registration_saves_selected_role(): void
    {
        $response = $this->get(route('auth.google', [
            'action' => 'register',
            'role' => 'owner',
        ]));

        $response->assertStatus(302);
        $this->assertEquals('register', session('google_oauth_action'));
        $this->assertEquals('owner', session('google_oauth_role'));
    }



    /**
     * Test Google callback registers new customer and redirects to member dashboard.
     */
    public function test_google_callback_registers_new_customer_and_redirects_to_member_dashboard(): void
    {
        $uniqueId = 'google-' . uniqid();
        $email = 'customer-' . uniqid() . '@example.com';

        $this->mockSocialiteUser($uniqueId, $email, 'Budi Customer', 'https://example.com/avatar.jpg');

        $response = $this->withSession([
            'google_oauth_action' => 'register',
            'google_oauth_role' => 'customer',
        ])->get(route('auth.google.callback'));

        $response->assertRedirect(route('member.home'));
        $this->assertAuthenticated();

        $user = User::where('google_id', $uniqueId)->first();
        $this->assertNotNull($user);
        $this->assertEquals($email, $user->email);
        $this->assertEquals('customer', $user->role);
        $this->assertEquals('Budi Customer', $user->name);
        $this->assertEquals('https://example.com/avatar.jpg', $user->avatar);
        $this->assertNotNull($user->email_verified_at);
    }

    /**
     * Test Google callback registers new owner and redirects to owner dashboard.
     */
    public function test_google_callback_registers_new_owner_and_redirects_to_owner_dashboard(): void
    {
        $uniqueId = 'google-' . uniqid();
        $email = 'owner-' . uniqid() . '@example.com';

        $this->mockSocialiteUser($uniqueId, $email, 'Pak Pemilik', null);

        $response = $this->withSession([
            'google_oauth_action' => 'register',
            'google_oauth_role' => 'owner',
        ])->get(route('auth.google.callback'));

        $response->assertRedirect(route('owner.dashboard'));
        $this->assertAuthenticated();

        $user = User::where('google_id', $uniqueId)->first();
        $this->assertNotNull($user);
        $this->assertEquals($email, $user->email);
        $this->assertEquals('owner', $user->role);
    }

    /**
     * Test Google callback logs in existing user with google_id.
     */
    public function test_google_callback_logs_in_existing_google_user(): void
    {
        $uniqueId = 'google-' . uniqid();
        $email = 'existing-' . uniqid() . '@example.com';

        $user = User::create([
            'name' => 'Existing Customer',
            'email' => $email,
            'google_id' => $uniqueId,
            'role' => 'customer',
            'password' => bcrypt('password123'),
        ]);

        $this->mockSocialiteUser($uniqueId, $email, 'Existing Customer');

        $response = $this->withSession([
            'google_oauth_action' => 'login',
        ])->get(route('auth.google.callback'));

        $response->assertRedirect(route('member.home'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test Google callback does NOT link email already registered with regular password.
     */
    public function test_google_callback_does_not_link_regular_password_account(): void
    {
        $email = 'regular-' . uniqid() . '@example.com';

        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => $email,
            'password' => bcrypt('secretpassword'),
            'role' => 'customer',
            'google_id' => null,
        ]);

        $differentGoogleId = 'google-new-' . uniqid();
        $this->mockSocialiteUser($differentGoogleId, $email, 'Regular User');

        $response = $this->withSession([
            'google_oauth_action' => 'login',
        ])->get(route('auth.google.callback'));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
        $this->assertGuest();

        // User's google_id must NOT be altered
        $regularUser->refresh();
        $this->assertNull($regularUser->google_id);
    }

    /**
     * Test user attempting login via Google without an existing account is automatically registered and logged in.
     */
    public function test_unregistered_google_login_automatically_creates_account_and_logs_in(): void
    {
        $nonExistentGoogleId = 'google-unregistered-' . uniqid();
        $nonExistentEmail = 'unregistered-' . uniqid() . '@example.com';

        $this->mockSocialiteUser($nonExistentGoogleId, $nonExistentEmail, 'Unregistered Person');

        $response = $this->withSession([
            'google_oauth_action' => 'login',
            'google_oauth_role' => 'customer',
        ])->get(route('auth.google.callback'));

        $response->assertRedirect(route('member.home'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => $nonExistentEmail,
            'google_id' => $nonExistentGoogleId,
            'role' => 'customer',
        ]);
    }

    /**
     * Test user cancellation in Google OAuth redirects with error.
     */
    public function test_google_callback_handles_user_cancellation(): void
    {
        $response = $this->withSession([
            'google_oauth_action' => 'login',
        ])->get(route('auth.google.callback', ['error' => 'access_denied']));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('error');
        $this->assertGuest();
    }
}
