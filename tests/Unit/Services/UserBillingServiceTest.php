<?php

namespace Unit\Services;

use App\Models\Bill;
use App\Models\User;
use App\Services\UserBillingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserBillingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserBillingService $userBillingService;

    public function setUp(): void
    {
        parent::setUp();

        $this->userBillingService = UserBillingService::new();
    }

    public function test_get_unassigned_bills_query_returns_correct_results(): void
    {
        Bill::factory()->count(5)->submitted()->create();
        Bill::factory()->count(5)->submitted()->assignedToUser()->create();

        $results = $this->userBillingService->getUnassignedBillsQuery()->get();

        $this->assertCount(5, $results);
    }

    public function test_get_users_without_max_bills_query_returns_correct_results(): void
    {
        User::factory()->count(3)->create();

        $maxedOutUser = User::factory()->create();

        Bill::factory()->count(3)->submitted()->assignedToUser($maxedOutUser)->create();

        $results = $this->userBillingService->getUsersWithoutMaxBillsQuery()->get();

        $this->assertCount(3, $results);

        $this->assertNotContains($maxedOutUser->id, $results->pluck('id'));
    }
}
