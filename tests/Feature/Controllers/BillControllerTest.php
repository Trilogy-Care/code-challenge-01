<?php

namespace Tests\Feature\Controllers;

use App\Http\Resources\Billing\BillResource;
use App\Models\Bill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_the_user_billing_index_endpoint(): void
    {
        $this->getJson(route('bills.index'))
            ->assertForbidden();
    }

    public function test_user_billing_index_endpoint_returns_the_expected_json_payload(): void
    {
        Bill::factory()->count(3)->submitted()->assignedToUser()->create();
        Bill::factory()->count(2)->submitted()->assignedToUser()->create();
        Bill::factory()->count(1)->approved()->assignedToUser()->create();

        $this
            ->actingAsAdmin()
            ->getJson(route('bills.index'))
            ->assertOk()
            ->assertJsonStructure([
                '*' => [
                    'name',
                    'total_bills',
                    'total_submitted_bills',
                    'total_approved_bills',
                ],
            ]);
    }

    public function test_guests_cannot_create_bills(): void
    {
        $this->postJson(route('bills.store'), [])
            ->assertForbidden();
    }

    public function test_admin_can_create_bills(): void
    {
        $data = Bill::factory()->raw();

        $this
            ->actingAsAdmin()
            ->postJson(route('bills.store'), $data)
            ->assertCreated()
            ->assertJsonStructure(array_keys(BillResource::make(Bill::with('billStage')->latest()->first())->resolve()));

        $this->assertDatabaseHas('bills', $data);
    }
}
