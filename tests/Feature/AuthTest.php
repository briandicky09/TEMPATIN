<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /*
    |--------------------------------------------------------------------------
    | 1. REGISTER TESTS (Kasus 1 - 7)
    |--------------------------------------------------------------------------
    */

    /**
     * Test 1: Register customer berhasil, terautentikasi, dan diarahkan ke /member.
     */
    public function test_01_register_customer_berhasil(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Budi Santoso',
            'handphone' => '081234567891',
            'email' => 'budi@example.com',
            'role' => 'member',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'agree' => '1',
        ]);

        $response->assertRedirect(route('member.home'));
        $this->assertAuthenticated();

        $user = User::where('email', 'budi@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('customer', $user->role);
    }

    /**
     * Test 2: Register owner berhasil, tersimpan dengan role owner, dan diarahkan ke /owner.
     */
    public function test_02_register_owner_berhasil_dan_diarahkan_ke_owner_area(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Pak Joko Pemilik',
            'handphone' => '081234567899',
            'email' => 'pakjoko@example.com',
            'role' => 'owner',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'agree' => '1',
        ]);

        $response->assertRedirect(route('owner.dashboard'));
        $this->assertAuthenticated();

        $user = User::where('email', 'pakjoko@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('owner', $user->role);
    }

    /**
     * Test 3: Email duplicate ditolak.
     */
    public function test_03_email_duplicate_ditolak(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Dewi Duplikat',
            'handphone' => '081234567890',
            'email' => 'dewi@email.com', // Sudah terdaftar di seeder
            'role' => 'member',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'agree' => '1',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test 4: Email tidak valid ditolak.
     */
    public function test_04_email_tidak_valid_ditolak(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Format Salah',
            'handphone' => '081234567890',
            'email' => 'bukan-sebuah-email',
            'role' => 'member',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'agree' => '1',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test 5: Password confirmation salah ditolak.
     */
    public function test_05_password_confirmation_salah_ditolak(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Password Beda',
            'handphone' => '081234567890',
            'email' => 'beda@example.com',
            'role' => 'member',
            'password' => 'password123',
            'password_confirmation' => 'berbeda456',
            'agree' => '1',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    /**
     * Test 6: Password tersimpan dalam bentuk hash di database.
     */
    public function test_06_password_tersimpan_dalam_bentuk_hash(): void
    {
        $this->post('/register', [
            'nama' => 'Uji Hash',
            'handphone' => '081999888777',
            'email' => 'ujihash@example.com',
            'role' => 'member',
            'password' => 'rahasia123',
            'password_confirmation' => 'rahasia123',
            'agree' => '1',
        ]);

        $user = User::where('email', 'ujihash@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNotEquals('rahasia123', $user->password);
        $this->assertTrue(Hash::check('rahasia123', $user->password));
    }

    /**
     * Test 7: Data phone masuk ke users.phone dari input handphone.
     */
    public function test_07_data_phone_masuk_ke_users_phone(): void
    {
        $phoneInput = '081298765432';

        $this->post('/register', [
            'nama' => 'Uji No HP',
            'handphone' => $phoneInput,
            'email' => 'ujinohp@example.com',
            'role' => 'member',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'agree' => '1',
        ]);

        $user = User::where('email', 'ujinohp@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals($phoneInput, $user->phone);
    }

    /*
    |--------------------------------------------------------------------------
    | 2. LOGIN TESTS (Kasus 8 - 12)
    |--------------------------------------------------------------------------
    */

    /**
     * Test 8: Login dengan email/password benar berhasil.
     */
    public function test_08_login_dengan_email_password_benar_berhasil(): void
    {
        $response = $this->post('/login', [
            'email' => 'dewi@email.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('member.home'));
    }

    /**
     * Test 9: Login dengan password salah gagal.
     */
    public function test_09_login_dengan_password_salah_gagal(): void
    {
        $response = $this->post('/login', [
            'email' => 'dewi@email.com',
            'password' => 'passwordsalah',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test 10: Login dengan email tidak terdaftar gagal.
     */
    public function test_10_login_dengan_email_tidak_terdaftar_gagal(): void
    {
        $response = $this->post('/login', [
            'email' => 'tidakada@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test 11: Session berhasil dibuat dan diregenerasi saat login.
     */
    public function test_11_session_berhasil_dibuat_saat_login(): void
    {
        $response = $this->post('/login', [
            'email' => 'dewi@email.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
        $this->assertNotNull(session()->getId());
    }

    /**
     * Test 12: User diarahkan sesuai role setelah login.
     */
    public function test_12_user_diarahkan_sesuai_role(): void
    {
        // Owner login
        $ownerResponse = $this->post('/login', [
            'email' => 'owner@tempatin.id',
            'password' => 'password123',
        ]);
        $ownerResponse->assertRedirect(route('owner.dashboard'));

        Auth::logout();

        // Customer login
        $customerResponse = $this->post('/login', [
            'email' => 'dewi@email.com',
            'password' => 'password123',
        ]);
        $customerResponse->assertRedirect(route('member.home'));
    }

    /*
    |--------------------------------------------------------------------------
    | 3. ROLE REDIRECT TESTS (Kasus 13 - 15)
    |--------------------------------------------------------------------------
    */

    /**
     * Test 13: Owner diarahkan ke area /owner.
     */
    public function test_13_owner_redirect_ke_area_owner(): void
    {
        $response = $this->post('/login', [
            'email' => 'owner@tempatin.id',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('owner.dashboard'));
        $this->assertStringContainsString('/owner', $response->headers->get('Location'));
    }

    /**
     * Test 14: Customer diarahkan ke area /member.
     */
    public function test_14_customer_redirect_ke_area_member(): void
    {
        $response = $this->post('/login', [
            'email' => 'dewi@email.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('member.home'));
        $this->assertStringContainsString('/member', $response->headers->get('Location'));
    }

    /**
     * Test 15: Tidak ada redirect ke /customer.
     */
    public function test_15_tidak_ada_redirect_ke_customer(): void
    {
        $response = $this->post('/login', [
            'email' => 'dewi@email.com',
            'password' => 'password123',
        ]);

        $targetUrl = $response->headers->get('Location');
        $this->assertStringNotContainsString('/customer', $targetUrl);
    }

    /*
    |--------------------------------------------------------------------------
    | 4. PROTECTED ROUTE TESTS (Kasus 16 - 18)
    |--------------------------------------------------------------------------
    */

    /**
     * Test 16: Guest tidak dapat mengakses area /owner/....
     */
    public function test_16_guest_tidak_dapat_mengakses_owner_area(): void
    {
        $responseDashboard = $this->get('/owner');
        $responseDashboard->assertRedirect(route('login'));

        $responseCreate = $this->get('/owner/kos/create');
        $responseCreate->assertRedirect(route('login'));
    }

    /**
     * Test 17: Guest tidak dapat mengakses area /member/....
     */
    public function test_17_guest_tidak_dapat_mengakses_member_area(): void
    {
        $responseHome = $this->get('/member');
        $responseHome->assertRedirect(route('login'));

        $responseProfile = $this->get('/member/profil');
        $responseProfile->assertRedirect(route('login'));
    }

    /**
     * Test 18: User yang sudah login dapat mengakses area yang sesuai.
     */
    public function test_18_user_yang_sudah_login_dapat_mengakses_area(): void
    {
        $owner = User::where('email', 'owner@tempatin.id')->first();
        $this->actingAs($owner);
        $ownerResponse = $this->get('/owner');
        $ownerResponse->assertStatus(200);

        $customer = User::where('email', 'dewi@email.com')->first();
        $this->actingAs($customer);
        $customerResponse = $this->get('/member/profil');
        $customerResponse->assertStatus(200);
    }

    /*
    |--------------------------------------------------------------------------
    | 5. LOGOUT TESTS (Kasus 19 - 20)
    |--------------------------------------------------------------------------
    */

    /**
     * Test 19: Logout berhasil menghapus session dan kredensial.
     */
    public function test_19_logout_berhasil(): void
    {
        $user = User::where('email', 'dewi@email.com')->first();
        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->post('/logout');

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    /**
     * Test 20: Setelah logout, halaman private tidak dapat diakses tanpa login.
     */
    public function test_20_setelah_logout_halaman_private_tidak_dapat_diakses(): void
    {
        $user = User::where('email', 'dewi@email.com')->first();
        $this->actingAs($user);

        // Lakukan logout
        $this->post('/logout');

        // Akses halaman private setelah logout
        $responseMember = $this->get('/member');
        $responseMember->assertRedirect(route('login'));

        $responseOwner = $this->get('/owner');
        $responseOwner->assertRedirect(route('login'));
    }

    /*
    |--------------------------------------------------------------------------
    | 6. GUEST MIDDLEWARE TESTS (Kasus Tambahan)
    |--------------------------------------------------------------------------
    */

    /**
     * Test 21: Owner terautentikasi yang mengakses /login diarahkan ke /owner.
     */
    public function test_21_owner_terautentikasi_mengakses_login_diarahkan_ke_owner_area(): void
    {
        $owner = User::where('email', 'owner@tempatin.id')->first();
        $this->actingAs($owner);

        $response = $this->get('/login');
        $response->assertRedirect(route('owner.dashboard'));
    }

    /**
     * Test 22: Customer terautentikasi yang mengakses /login diarahkan ke /member.
     */
    public function test_22_customer_terautentikasi_mengakses_login_diarahkan_ke_member_area(): void
    {
        $customer = User::where('email', 'dewi@email.com')->first();
        $this->actingAs($customer);

        $response = $this->get('/login');
        $response->assertRedirect(route('member.home'));
    }

    /**
     * Test 23: Input role yang tidak terdaftar ditolak oleh validasi.
     */
    public function test_23_role_tidak_valid_ditolak(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Role Palsu',
            'handphone' => '081234567890',
            'email' => 'palsu@example.com',
            'role' => 'admin_ilegal',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'agree' => '1',
        ]);

        $response->assertSessionHasErrors('role');
        $this->assertGuest();
    }
}

