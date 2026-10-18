<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\TempatinNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DatabaseNotificationTest extends TestCase
{
    use DatabaseTransactions;

    private User $customerA;
    private User $customerB;
    private User $owner;

    protected function setUp(): void
    {
        parent::setUp();

        $this->customerA = User::create([
            'name' => 'Customer Notif A',
            'email' => 'cust_notif_a_' . uniqid() . '@example.com',
            'phone' => '081288880001',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->customerB = User::create([
            'name' => 'Customer Notif B',
            'email' => 'cust_notif_b_' . uniqid() . '@example.com',
            'phone' => '081288880002',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $this->owner = User::create([
            'name' => 'Owner Notif',
            'email' => 'owner_notif_' . uniqid() . '@example.com',
            'phone' => '081288880003',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);
    }

    public function test_01_user_receives_database_notification()
    {
        $this->customerA->notify(new TempatinNotification(
            'Pembayaran Berhasil Dikonfirmasi',
            'Pembayaran sewa Anda telah berhasil diverifikasi oleh sistem Midtrans.',
            route('member.invoice.index'),
            'payment',
            'fa-check-circle'
        ));

        $this->assertEquals(1, $this->customerA->unreadNotifications()->count());
        $notification = $this->customerA->notifications()->first();
        $this->assertEquals('Pembayaran Berhasil Dikonfirmasi', $notification->data['title']);
    }

    public function test_02_customer_only_sees_own_notifications()
    {
        $this->customerA->notify(new TempatinNotification(
            'Pesan Khusus Customer A',
            'Pemberitahuan privat customer A.',
            '/member/notifikasi'
        ));

        $this->customerB->notify(new TempatinNotification(
            'Pesan Khusus Customer B',
            'Pemberitahuan privat customer B.',
            '/member/notifikasi'
        ));

        $responseA = $this->actingAs($this->customerA)->get(route('member.notifikasi'));
        $responseA->assertStatus(200);
        $responseA->assertSee('Pesan Khusus Customer A');
        $responseA->assertDontSee('Pesan Khusus Customer B');
    }

    public function test_03_viewing_notification_page_marks_as_read()
    {
        $this->customerA->notify(new TempatinNotification(
            'Tagihan Sewa Baru',
            'Invoice tagihan sewa baru telah diterbitkan.',
            '/member/notifikasi'
        ));

        $this->assertEquals(1, $this->customerA->unreadNotifications()->count());

        $this->actingAs($this->customerA)->get(route('member.notifikasi'));

        $this->customerA->refresh();
        $this->assertEquals(0, $this->customerA->unreadNotifications()->count());
    }

    public function test_04_owner_views_owner_notifications()
    {
        $this->owner->notify(new TempatinNotification(
            'Booking Baru Masuk',
            'Penyewa baru telah mengajukan booking.',
            route('owner.bookings.index')
        ));

        $response = $this->actingAs($this->owner)->get(route('owner.notifikasi'));
        $response->assertStatus(200);
        $response->assertSee('Booking Baru Masuk');

        $this->owner->refresh();
        $this->assertEquals(0, $this->owner->unreadNotifications()->count());
    }
}
