<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\Kos;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class KosSearchFilterTest extends TestCase
{
    use DatabaseTransactions;

    private User $owner;
    private Facility $wifi;
    private Facility $ac;
    private Kos $kosMurah;
    private Kos $kosMahal;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Search',
            'email' => 'owner_search_' . uniqid() . '@example.com',
            'phone' => '081255550001',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'email_verified_at' => now(),
        ]);

        $this->wifi = Facility::create(['name' => 'WiFi Cepat ' . uniqid(), 'slug' => 'wifi-' . uniqid()]);
        $this->ac = Facility::create(['name' => 'AC Dingin ' . uniqid(), 'slug' => 'ac-' . uniqid()]);

        $this->kosMurah = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Murah Bersahaja ' . uniqid(),
            'slug' => 'kos-murah-' . uniqid(),
            'type' => 'Campur',
            'price' => 800000,
            'address' => 'Jl. Murah No. 1',
            'city' => 'Yogyakarta',
            'description' => 'Kos hemat fasilitas WiFi',
            'rooms' => 5,
            'status' => 'active',
        ]);
        $this->kosMurah->facilities()->sync([$this->wifi->id]);

        $this->kosMahal = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Mewah Eksklusif ' . uniqid(),
            'slug' => 'kos-mewah-' . uniqid(),
            'type' => 'Eksklusif',
            'price' => 2500000,
            'address' => 'Jl. Mewah No. 99',
            'city' => 'Jakarta Selatan',
            'description' => 'Kos premium fasilitas AC',
            'rooms' => 10,
            'status' => 'active',
        ]);
        $this->kosMahal->facilities()->sync([$this->ac->id]);
    }

    public function test_01_filter_by_facility_works()
    {
        $response = $this->get(route('kos.index', [
            'facilities' => [$this->ac->id],
        ]));

        $response->assertStatus(200);
        $response->assertSee($this->kosMahal->title);
        $response->assertDontSee($this->kosMurah->title);
    }

    public function test_02_filter_by_price_range_works()
    {
        $response = $this->get(route('kos.index', [
            'min_price' => 500000,
            'max_price' => 1000000,
        ]));

        $response->assertStatus(200);
        $response->assertSee($this->kosMurah->title);
        $response->assertDontSee($this->kosMahal->title);
    }

    public function test_03_sort_by_price_asc_and_desc()
    {
        // Ascending
        $resAsc = $this->get(route('kos.index', ['sort' => 'price_asc']));
        $resAsc->assertStatus(200);

        // Descending
        $resDesc = $this->get(route('kos.index', ['sort' => 'price_desc']));
        $resDesc->assertStatus(200);
    }

    public function test_04_pagination_limits_to_nine_items_per_page()
    {
        // Pastikan route /kos terpaginasi
        $response = $this->get(route('kos.index'));
        $response->assertStatus(200);
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $response->viewData('listKos'));
        $this->assertEquals(9, $response->viewData('listKos')->perPage());
    }
}
