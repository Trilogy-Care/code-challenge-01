<?php

namespace Unit\Services;

use App\Models\Bill;
use App\Models\BillStage;
use App\Services\BillingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_bills_in_stage_query_returns_correct_results(): void
    {
        $billingService = BillingService::new();

        Bill::factory()->count(5)->submitted()->create();
        Bill::factory()->count(3)->approved()->create();
        Bill::factory()->count(7)->onHold()->create();

        $submittedResults = $billingService->getBillsInStageQuery(BillStage::SUBMITTED)->get();
        $approvedResults = $billingService->getBillsInStageQuery(BillStage::APPROVED)->get();
        $onHoldResults = $billingService->getBillsInStageQuery(BillStage::ON_HOLD)->get();

        $this->assertCount(5, $submittedResults);
        $this->assertCount(3, $approvedResults);
        $this->assertCount(7, $onHoldResults);
    }
}
