<?php

namespace Tests\Feature\Controllers;

use App\Models\Bill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserBillingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_the_user_billing_index_endpoint(): void
    {
        $this->getJson(route('billing.index'))
            ->assertForbidden();
    }

    public function test_user_billing_index_endpoint_returns_the_expected_json_payload(): void
    {
        Bill::factory()->count(3)->submitted()->assignedToUser()->create();
        Bill::factory()->count(2)->submitted()->assignedToUser()->create();
        Bill::factory()->count(1)->approved()->assignedToUser()->create();

        $this
            ->actingAsAdmin()
            ->getJson(route('billing.index'))
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
}
