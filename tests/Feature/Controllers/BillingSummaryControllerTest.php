<?php

namespace Tests\Feature\Controllers;

use Database\Factories\BillFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillingSummaryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthorised_users_cannot_access_the_billing_summary_index_endpoint(): void
    {
        $response = $this->get(route('billing-summary.index'));

        $response->assertForbidden();
    }

    public function test_billing_summary_index_endpoint_returns_the_expected_json_attributes(): void
    {
        BillFactory::new()->count(5)->submitted()->create();
        BillFactory::new()->count(3)->approved()->create();
        BillFactory::new()->count(2)->onHold()->create();

        $response = $this
            ->actingAsAdmin()
            ->getJson(route('billing-summary.index'));

        $response->assertJson([
            'total_submitted_bills' => 5,
            'total_approved_bills' => 3,
            'total_on_hold_bills' => 2,
        ]);
    }
}
