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

    public function test_get_user_billing_query_returns_correct_results(): void
    {
        $user1 = User::factory()->create(['name' => 'User 1']);
        $user2 = User::factory()->create(['name' => 'User 2']);

        Bill::factory()->count(3)->submitted()->assignedToUser($user1)->create();
        Bill::factory()->count(2)->submitted()->assignedToUser($user2)->create();
        Bill::factory()->count(1)->approved()->assignedToUser($user2)->create();

        Bill::factory()->count(2)->submitted()->assignedToUser($user1)->softDeleted()->create();
        Bill::factory()->count(1)->submitted()->assignedToUser($user2)->softDeleted()->create();

        $results = $this->userBillingService->getUserBillingQuery()->get();

        $this->assertCount(2, $results);

        $this->assertEquals($user1->name, $results->first()->name);
        $this->assertEquals(3, $results->first()->total_bills);
        $this->assertEquals(3, $results->first()->total_submitted_bills);
        $this->assertEquals(0, $results->first()->total_approved_bills);

        $this->assertEquals($user2->name, $results->last()->name);
        $this->assertEquals(3, $results->last()->total_bills);
        $this->assertEquals(2, $results->last()->total_submitted_bills);
        $this->assertEquals(1, $results->last()->total_approved_bills);
    }
}
