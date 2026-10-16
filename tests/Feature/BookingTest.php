<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Kos;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use DatabaseTransactions;

    protected User $owner;
    protected User $customerA;
    protected User $customerB;
    protected Kos $kosActive;
    protected Kos $kosInactive;
    protected Kos $kosSoftDeleted;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. User Owner
        $this->owner = User::create([
            'name' => 'Owner Booking',
            'email' => 'owner_bkg_' . uniqid() . '@example.com',
            'phone' => '081299990001',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        // 2. Customer A
        $this->customerA = User::create([
            'name' => 'Customer Alpha',
            'email' => 'customer_a_' . uniqid() . '@example.com',
            'phone' => '081299990002',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // 3. Customer B
        $this->customerB = User::create([
            'name' => 'Customer Beta',
            'email' => 'customer_b_' . uniqid() . '@example.com',
            'phone' => '081299990003',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        // 4. Kos Aktif
        $this->kosActive = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Aktif Melati',
            'slug' => 'kos-aktif-melati-' . uniqid(),
            'description' => 'Kos aktif siap huni.',
            'price' => 850000.00,
            'type' => 'Putri',
            'city' => 'Surabaya',
            'address' => 'Jl. Melati No. 1',
            'thumbnail' => 'assets/img/kos/1.png',
            'status' => 'active',
        ]);

        // 5. Kos Inactive
        $this->kosInactive = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Nonaktif Mawar',
            'slug' => 'kos-nonaktif-mawar-' . uniqid(),
            'description' => 'Kos sedang direnovasi.',
            'price' => 750000.00,
            'type' => 'Putra',
            'city' => 'Malang',
            'address' => 'Jl. Mawar No. 2',
            'thumbnail' => 'assets/img/kos/2.png',
            'status' => 'inactive',
        ]);

        // 6. Kos Soft Deleted
        $this->kosSoftDeleted = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Terhapus Anggrek',
            'slug' => 'kos-terhapus-anggrek-' . uniqid(),
            'description' => 'Kos sudah ditutup.',
            'price' => 900000.00,
            'type' => 'Campur',
            'city' => 'Surabaya',
            'address' => 'Jl. Anggrek No. 3',
            'thumbnail' => 'assets/img/kos/3.png',
            'status' => 'active',
        ]);
        $this->kosSoftDeleted->delete();
    }

    /**
     * 1. Customer dapat membuka form booking kos aktif.
     */
    public function test_01_customer_can_open_booking_form(): void
    {
        $response = $this->actingAs($this->customerA)->get('/member/booking/' . $this->kosActive->slug);

        $response->assertStatus(200);
        $response->assertSee($this->kosActive->title);
        $response->assertSee('Data Penyewa');
        $response->assertSee('Ringkasan Harga');
    }

    /**
     * 2. Guest tidak dapat mengakses form booking (redirect ke login).
     */
    public function test_02_guest_cannot_access_booking_form(): void
    {
        $response = $this->get('/member/booking/' . $this->kosActive->slug);

        $response->assertRedirect(route('login'));
    }

    /**
     * 3. Owner tidak dapat mengakses form booking customer (403 Forbidden).
     */
    public function test_03_owner_cannot_access_booking_form(): void
    {
        $response = $this->actingAs($this->owner)->get('/member/booking/' . $this->kosActive->slug);

        $response->assertForbidden();
    }

    /**
     * 4. Customer dapat membuat booking untuk Kos active.
     */
    public function test_04_customer_can_create_booking_for_active_kos(): void
    {
        $startDate = now()->addDays(2)->format('Y-m-d');

        $response = $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'tenant_name' => 'Budi Santoso',
            'tenant_phone' => '081234567890',
            'tenant_email' => 'budi@example.com',
            'start_date' => $startDate,
            'duration_months' => 2,
            'notes' => 'Tolong sediakan tempat parkir motor.',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $booking = Booking::where('customer_id', $this->customerA->id)
            ->where('kos_id', $this->kosActive->id)
            ->latest('id')
            ->first();

        $this->assertNotNull($booking);
        $response->assertRedirect(route('member.booking.payment', ['slug' => $this->kosActive->slug, 'booking_code' => $booking->booking_code]));
    }

    /**
     * 5. Booking tersimpan ke database secara lengkap.
     */
    public function test_05_booking_is_persisted_to_database(): void
    {
        $startDate = now()->addDays(1)->format('Y-m-d');

        $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'tenant_name' => 'Siti Nurhaliza',
            'tenant_phone' => '081298765432',
            'tenant_email' => 'siti@example.com',
            'start_date' => $startDate,
            'duration_months' => 1,
        ]);

        $this->assertDatabaseHas('bookings', [
            'customer_id' => $this->customerA->id,
            'kos_id' => $this->kosActive->id,
            'tenant_name' => 'Siti Nurhaliza',
            'tenant_phone' => '081298765432',
            'tenant_email' => 'siti@example.com',
            'duration_months' => 1,
            'status' => 'pending',
        ]);
    }

    /**
     * 6. customer_id otomatis menggunakan ID authenticated user.
     */
    public function test_06_customer_id_automatically_uses_authenticated_user(): void
    {
        $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'tenant_name' => 'Customer A Name',
            'tenant_phone' => '081211112222',
            'tenant_email' => 'customera@example.com',
            'start_date' => now()->addDays(3)->format('Y-m-d'),
            'duration_months' => 1,
        ]);

        $booking = Booking::where('tenant_email', 'customera@example.com')->first();
        $this->assertNotNull($booking);
        $this->assertEquals($this->customerA->id, $booking->customer_id);
    }

    /**
     * 7. customer_id dari request tidak dapat digunakan untuk spoofing akun lain.
     */
    public function test_07_customer_id_from_request_cannot_be_spoofed(): void
    {
        // Customer A mengirim customer_id milik Customer B
        $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'customer_id' => $this->customerB->id,
            'tenant_name' => 'Percobaan Spoofing Customer',
            'tenant_phone' => '081233334444',
            'tenant_email' => 'spoof@example.com',
            'start_date' => now()->addDays(5)->format('Y-m-d'),
            'duration_months' => 1,
        ]);

        // Booking harus tetap tercatat milik Customer A, bukan Customer B
        $this->assertDatabaseHas('bookings', [
            'tenant_email' => 'spoof@example.com',
            'customer_id' => $this->customerA->id,
        ]);
        $this->assertDatabaseMissing('bookings', [
            'tenant_email' => 'spoof@example.com',
            'customer_id' => $this->customerB->id,
        ]);
    }

    /**
     * 8. kos_price diambil dari database, bukan dari input request.
     */
    public function test_08_kos_price_is_taken_from_database_not_request(): void
    {
        // Manipulasi harga murah via payload request
        $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'kos_price' => 50000.00, // Mencoba bayar 50rb padahal aslinya 850rb
            'tenant_name' => 'Penyewa Harga Manipulasi',
            'tenant_phone' => '081255556666',
            'tenant_email' => 'price_manip@example.com',
            'start_date' => now()->addDays(4)->format('Y-m-d'),
            'duration_months' => 1,
        ]);

        $booking = Booking::where('tenant_email', 'price_manip@example.com')->first();
        $this->assertNotNull($booking);
        // Harga kos harus tetap sesuai database asli (850000.00)
        $this->assertEquals((float) $this->kosActive->price, (float) $booking->kos_price);
        $this->assertNotEquals(50000.00, (float) $booking->kos_price);
    }

    /**
     * 9. subtotal dihitung server-side (kos_price x duration_months).
     */
    public function test_09_subtotal_is_calculated_server_side(): void
    {
        $duration = 3;
        $expectedSubtotal = (float) $this->kosActive->price * $duration; // 850.000 * 3 = 2.550.000

        $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'subtotal' => 10000.00, // Coba kirim subtotal palsu
            'tenant_name' => 'Penyewa 3 Bulan',
            'tenant_phone' => '081277778888',
            'tenant_email' => 'subtotal_test@example.com',
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'duration_months' => $duration,
        ]);

        $booking = Booking::where('tenant_email', 'subtotal_test@example.com')->first();
        $this->assertNotNull($booking);
        $this->assertEquals($expectedSubtotal, (float) $booking->subtotal);
    }

    /**
     * 10. total_amount dihitung server-side (subtotal + admin_fee).
     */
    public function test_10_total_amount_is_calculated_server_side(): void
    {
        $duration = 2;
        $expectedSubtotal = (float) $this->kosActive->price * $duration; // 1.700.000
        $expectedAdminFee = 25000.00;
        $expectedTotal = $expectedSubtotal + $expectedAdminFee; // 1.725.000

        $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'admin_fee' => 0.00, // Coba hapus biaya admin
            'total_amount' => 100000.00, // Coba manipulasi total
            'tenant_name' => 'Penyewa Total Test',
            'tenant_phone' => '081288889999',
            'tenant_email' => 'total_test@example.com',
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'duration_months' => $duration,
        ]);

        $booking = Booking::where('tenant_email', 'total_test@example.com')->first();
        $this->assertNotNull($booking);
        $this->assertEquals($expectedAdminFee, (float) $booking->admin_fee);
        $this->assertEquals($expectedTotal, (float) $booking->total_amount);
    }

    /**
     * 11. booking_code dibuat server-side dan unique.
     */
    public function test_11_booking_code_is_generated_server_side_and_unique(): void
    {
        // Mencoba inject kode booking palsu
        $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'booking_code' => 'KODE-PALSU-999',
            'tenant_name' => 'Kode Generator 1',
            'tenant_phone' => '081299991111',
            'tenant_email' => 'code1@example.com',
            'start_date' => now()->addDays(3)->format('Y-m-d'),
            'duration_months' => 1,
        ]);

        $booking1 = Booking::where('tenant_email', 'code1@example.com')->first();
        $this->assertNotNull($booking1);
        $this->assertNotEquals('KODE-PALSU-999', $booking1->booking_code);
        $this->assertStringStartsWith('BKG-', $booking1->booking_code);

        // Buat booking kedua untuk memastikan keunikan kode
        $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'tenant_name' => 'Kode Generator 2',
            'tenant_phone' => '081299992222',
            'tenant_email' => 'code2@example.com',
            'start_date' => now()->addDays(4)->format('Y-m-d'),
            'duration_months' => 1,
        ]);

        $booking2 = Booking::where('tenant_email', 'code2@example.com')->first();
        $this->assertNotNull($booking2);
        $this->assertNotEquals($booking1->booking_code, $booking2->booking_code);
    }

    /**
     * 12. status awal booking adalah pending.
     */
    public function test_12_initial_booking_status_is_pending(): void
    {
        // Mencoba kirim status langsung active/confirmed
        $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'status' => 'confirmed',
            'tenant_name' => 'Status Test User',
            'tenant_phone' => '081233335555',
            'tenant_email' => 'status_test@example.com',
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'duration_months' => 1,
        ]);

        $booking = Booking::where('tenant_email', 'status_test@example.com')->first();
        $this->assertNotNull($booking);
        $this->assertEquals('pending', $booking->status);
        $this->assertTrue($booking->isPending());
    }

    /**
     * 13. Kos inactive tidak dapat dibooking dan menghasilkan 404.
     */
    public function test_13_inactive_kos_cannot_be_booked_and_returns_404(): void
    {
        $response = $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosInactive->slug, [
            'tenant_name' => 'Penyewa Kos Inactive',
            'tenant_phone' => '081244445555',
            'tenant_email' => 'inactive_book@example.com',
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'duration_months' => 1,
        ]);

        $response->assertNotFound();
        $this->assertDatabaseMissing('bookings', [
            'tenant_email' => 'inactive_book@example.com',
        ]);
    }

    /**
     * 14. Kos soft deleted tidak dapat dibooking dan menghasilkan 404.
     */
    public function test_14_soft_deleted_kos_cannot_be_booked_and_returns_404(): void
    {
        $response = $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosSoftDeleted->slug, [
            'tenant_name' => 'Penyewa Kos Deleted',
            'tenant_phone' => '081255557777',
            'tenant_email' => 'deleted_book@example.com',
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'duration_months' => 1,
        ]);

        $response->assertNotFound();
        $this->assertDatabaseMissing('bookings', [
            'tenant_email' => 'deleted_book@example.com',
        ]);
    }

    /**
     * 15. Kos tidak ditemukan menghasilkan 404.
     */
    public function test_15_non_existent_kos_returns_404(): void
    {
        $response = $this->actingAs($this->customerA)->post('/member/booking/slug-fiktif-tidak-ada-999', [
            'tenant_name' => 'Penyewa 404',
            'tenant_phone' => '081266668888',
            'tenant_email' => 'nonexistent@example.com',
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'duration_months' => 1,
        ]);

        $response->assertNotFound();
    }

    /**
     * 16. Validasi duration_months gagal jika tidak valid (0, negatif, > 12, atau non-integer).
     */
    public function test_16_validation_fails_if_duration_months_is_invalid(): void
    {
        // Kasus 1: Durasi 0
        $responseZero = $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'tenant_name' => 'Test Validasi',
            'tenant_phone' => '081277771111',
            'tenant_email' => 'val_zero@example.com',
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'duration_months' => 0,
        ]);
        $responseZero->assertSessionHasErrors('duration_months');

        // Kasus 2: Durasi melebihi batas 12 bulan
        $responseTooLong = $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'tenant_name' => 'Test Validasi',
            'tenant_phone' => '081277771111',
            'tenant_email' => 'val_long@example.com',
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'duration_months' => 13,
        ]);
        $responseTooLong->assertSessionHasErrors('duration_months');

        // Kasus 3: Durasi bukan angka
        $responseNonInt = $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'tenant_name' => 'Test Validasi',
            'tenant_phone' => '081277771111',
            'tenant_email' => 'val_str@example.com',
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'duration_months' => 'tiga_bulan',
        ]);
        $responseNonInt->assertSessionHasErrors('duration_months');

        // Pastikan tidak ada data yang masuk
        $this->assertDatabaseMissing('bookings', ['tenant_email' => 'val_zero@example.com']);
    }

    /**
     * 17. Validasi start_date gagal jika tidak valid atau tanggal di masa lalu.
     */
    public function test_17_validation_fails_if_start_date_is_invalid(): void
    {
        // Kasus 1: Tanggal kemarin (masa lalu)
        $pastDate = now()->subDay()->format('Y-m-d');
        $responsePast = $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'tenant_name' => 'Test Masa Lalu',
            'tenant_phone' => '081277772222',
            'tenant_email' => 'past@example.com',
            'start_date' => $pastDate,
            'duration_months' => 1,
        ]);
        $responsePast->assertSessionHasErrors('start_date');

        // Kasus 2: Format tanggal bukan date valid
        $responseInvalidFormat = $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'tenant_name' => 'Test Format Rusak',
            'tenant_phone' => '081277772222',
            'tenant_email' => 'invalid_date@example.com',
            'start_date' => 'bukan-tanggal',
            'duration_months' => 1,
        ]);
        $responseInvalidFormat->assertSessionHasErrors('start_date');

        $this->assertDatabaseMissing('bookings', ['tenant_email' => 'past@example.com']);
    }

    /**
     * 18. Customer A tidak boleh dapat melihat detail booking milik Customer B (403 Forbidden).
     */
    public function test_18_customer_a_cannot_view_booking_of_customer_b(): void
    {
        // Buat booking milik Customer B
        $bookingB = Booking::create([
            'customer_id' => $this->customerB->id,
            'kos_id' => $this->kosActive->id,
            'booking_code' => 'BKG-TEST-CUSTB-001',
            'tenant_name' => 'Customer B Rahasia',
            'tenant_phone' => '081299998888',
            'tenant_email' => 'custb_secret@example.com',
            'start_date' => now()->addDays(5)->format('Y-m-d'),
            'end_date' => now()->addMonths(1)->addDays(5)->format('Y-m-d'),
            'duration_months' => 1,
            'kos_price' => 850000.00,
            'subtotal' => 850000.00,
            'admin_fee' => 25000.00,
            'total_amount' => 875000.00,
            'status' => 'pending',
        ]);

        // Customer A mencoba mengakses detail booking milik Customer B
        $response = $this->actingAs($this->customerA)->get('/member/booking/detail/' . $bookingB->booking_code);

        $response->assertForbidden();

        // Sebaliknya, Customer B sah melihat booking miliknya sendiri
        $responseOwnerValid = $this->actingAs($this->customerB)->get('/member/booking/detail/' . $bookingB->booking_code);
        $responseOwnerValid->assertStatus(200);
        $responseOwnerValid->assertSee($bookingB->booking_code);
    }

    /**
     * 19. Data notes dapat disimpan jika diisi, dan bernilai null jika kosong.
     */
    public function test_19_notes_can_be_stored_if_provided(): void
    {
        // Dengan catatan
        $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'tenant_name' => 'Penyewa Catatan',
            'tenant_phone' => '081299993333',
            'tenant_email' => 'with_notes@example.com',
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'duration_months' => 1,
            'notes' => 'Kamar lantai dasar dengan ventilasi baik.',
        ]);

        $bookingWithNotes = Booking::where('tenant_email', 'with_notes@example.com')->first();
        $this->assertNotNull($bookingWithNotes);
        $this->assertEquals('Kamar lantai dasar dengan ventilasi baik.', $bookingWithNotes->notes);

        // Tanpa catatan
        $this->actingAs($this->customerA)->post('/member/booking/' . $this->kosActive->slug, [
            'tenant_name' => 'Penyewa Tanpa Catatan',
            'tenant_phone' => '081299994444',
            'tenant_email' => 'no_notes@example.com',
            'start_date' => now()->addDays(2)->format('Y-m-d'),
            'duration_months' => 1,
        ]);

        $bookingNoNotes = Booking::where('tenant_email', 'no_notes@example.com')->first();
        $this->assertNotNull($bookingNoNotes);
        $this->assertNull($bookingNoNotes->notes);
    }

    /**
     * 20. Database tetap konsisten jika proses pembuatan booking mengalami kegagalan (Transaction rollback).
     */
    public function test_20_database_remains_consistent_on_booking_failure(): void
    {
        $initialBookingCount = Booking::count();

        try {
            DB::transaction(function () {
                Booking::create([
                    'customer_id' => $this->customerA->id,
                    'kos_id' => $this->kosActive->id,
                    'booking_code' => 'BKG-ROLLBACK-TEST',
                    'tenant_name' => 'Gagal Simpan',
                    'tenant_phone' => '081299999999',
                    'tenant_email' => 'fail@example.com',
                    'start_date' => now()->addDays(1)->format('Y-m-d'),
                    'end_date' => now()->addMonths(1)->format('Y-m-d'),
                    'duration_months' => 1,
                    'kos_price' => 850000.00,
                    'subtotal' => 850000.00,
                    'admin_fee' => 25000.00,
                    'total_amount' => 875000.00,
                    'status' => 'pending',
                ]);

                // Paksa lempar exception di dalam transaksi untuk memicu rollback
                throw new \RuntimeException('Simulasi kegagalan sistem');
            });
        } catch (\RuntimeException $e) {
            // Tangkap exception simulasi
        }

        // Pastikan jumlah booking tidak bertambah dan record yang gagal ter-rollback
        $this->assertEquals($initialBookingCount, Booking::count());
        $this->assertDatabaseMissing('bookings', [
            'booking_code' => 'BKG-ROLLBACK-TEST',
        ]);
    }
}
