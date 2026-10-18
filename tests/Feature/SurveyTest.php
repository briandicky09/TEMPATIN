<?php

namespace Tests\Feature;

use App\Models\Kos;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class SurveyTest extends TestCase
{
    use DatabaseTransactions;

    protected User $owner;
    protected User $otherOwner;
    protected User $customer;
    protected Kos $kos;

    protected function setUp(): void
    {
        parent::setUp();

        $this->owner = User::create([
            'name' => 'Owner Survey',
            'email' => 'owner.survey@example.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'phone' => '081211112222',
        ]);

        $this->otherOwner = User::create([
            'name' => 'Other Owner',
            'email' => 'other.survey@example.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'phone' => '081233334444',
        ]);

        $this->customer = User::create([
            'name' => 'Customer Survey',
            'email' => 'customer.survey@example.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
            'phone' => '081255556666',
        ]);

        $this->kos = Kos::create([
            'owner_id' => $this->owner->id,
            'title' => 'Kos Graha Asri',
            'slug' => 'kos-graha-asri',
            'type' => 'Campur',
            'price' => 1500000,
            'address' => 'Jl. Asri No 5',
            'city' => 'Bandung',
            'status' => 'active',
        ]);
    }

    public function test_customer_can_submit_valid_survey(): void
    {
        $response = $this->actingAs($this->customer)
            ->post(route('surveys.store', $this->kos->slug), [
                'survey_date' => now()->addDays(2)->format('Y-m-d'),
                'survey_time' => '10:00',
                'notes' => 'Ingin lihat sirkulasi udara kamar',
            ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('surveys', [
            'kos_id' => $this->kos->id,
            'customer_id' => $this->customer->id,
            'survey_time' => '10:00',
            'status' => 'pending',
            'notes' => 'Ingin lihat sirkulasi udara kamar',
        ]);

        // Owner receives notification
        $this->assertEquals(1, $this->owner->unreadNotifications()->count());
    }

    public function test_duplicate_pending_survey_is_prevented(): void
    {
        Survey::create([
            'kos_id' => $this->kos->id,
            'customer_id' => $this->customer->id,
            'survey_date' => now()->addDays(1)->format('Y-m-d'),
            'survey_time' => '14:00',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->customer)
            ->post(route('surveys.store', $this->kos->slug), [
                'survey_date' => now()->addDays(2)->format('Y-m-d'),
                'survey_time' => '15:00',
            ]);

        $response->assertSessionHas('warning');
        $this->assertEquals(1, Survey::where('customer_id', $this->customer->id)->count());
    }

    public function test_past_date_survey_is_rejected(): void
    {
        $response = $this->actingAs($this->customer)
            ->post(route('surveys.store', $this->kos->slug), [
                'survey_date' => now()->subDay()->format('Y-m-d'),
                'survey_time' => '10:00',
            ]);

        $response->assertSessionHasErrors(['survey_date']);
        $this->assertEquals(0, Survey::count());
    }

    public function test_owner_can_view_and_approve_survey(): void
    {
        $survey = Survey::create([
            'kos_id' => $this->kos->id,
            'customer_id' => $this->customer->id,
            'survey_date' => now()->addDays(2)->format('Y-m-d'),
            'survey_time' => '10:00',
            'status' => 'pending',
        ]);

        $viewResponse = $this->actingAs($this->owner)
            ->get(route('owner.surveys.index'));

        $viewResponse->assertOk();
        $viewResponse->assertSee($this->customer->name);

        $approveResponse = $this->actingAs($this->owner)
            ->patch(route('owner.surveys.updateStatus', $survey->id), [
                'status' => 'approved',
            ]);

        $approveResponse->assertSessionHas('success');
        $survey->refresh();
        $this->assertEquals('approved', $survey->status);

        // Customer receives approval notification
        $this->assertEquals(1, $this->customer->unreadNotifications()->count());
    }

    public function test_owner_can_reject_survey_with_reason(): void
    {
        $survey = Survey::create([
            'kos_id' => $this->kos->id,
            'customer_id' => $this->customer->id,
            'survey_date' => now()->addDays(2)->format('Y-m-d'),
            'survey_time' => '10:00',
            'status' => 'pending',
        ]);

        $rejectResponse = $this->actingAs($this->owner)
            ->patch(route('owner.surveys.updateStatus', $survey->id), [
                'status' => 'rejected',
                'rejection_reason' => 'Pemilik sedang di luar kota pada tanggal tersebut.',
            ]);

        $rejectResponse->assertSessionHas('success');
        $survey->refresh();
        $this->assertEquals('rejected', $survey->status);
        $this->assertEquals('Pemilik sedang di luar kota pada tanggal tersebut.', $survey->rejection_reason);

        // Customer receives notification
        $this->assertEquals(1, $this->customer->unreadNotifications()->count());
    }

    public function test_other_owner_cannot_modify_survey(): void
    {
        $survey = Survey::create([
            'kos_id' => $this->kos->id,
            'customer_id' => $this->customer->id,
            'survey_date' => now()->addDays(2)->format('Y-m-d'),
            'survey_time' => '10:00',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->otherOwner)
            ->patch(route('owner.surveys.updateStatus', $survey->id), [
                'status' => 'approved',
            ]);

        $response->assertStatus(403);
    }

    public function test_customer_can_cancel_pending_survey(): void
    {
        $survey = Survey::create([
            'kos_id' => $this->kos->id,
            'customer_id' => $this->customer->id,
            'survey_date' => now()->addDays(2)->format('Y-m-d'),
            'survey_time' => '10:00',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->customer)
            ->patch(route('member.surveys.cancel', $survey->id));

        $response->assertSessionHas('success');
        $survey->refresh();
        $this->assertEquals('cancelled', $survey->status);
    }
}
