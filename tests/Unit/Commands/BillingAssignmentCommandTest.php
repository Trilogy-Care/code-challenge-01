<?php

namespace Tests\Unit\Commands;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillingAssignmentCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_billing_assignment_command_correctly_assigns_bills_to_users(): void
    {
        $usersToAssignBills = User::factory()->count(3)->create();

        $unassignedBills = Bill::factory()->count(10)->submitted()->create();

        $maxedOutUser = User::factory()->create();

        Bill::factory()->count(3)->assignedToUser($maxedOutUser)->create();

        $this->assertDatabaseCount('bills', 13);

        $this->artisan('bills:assign')
            ->expectsOutput('9 bills have been assigned to users.')
            ->assertExitCode(0);

        $this->artisan('bills:assign')
            ->expectsOutput('No users available to assign bills to.')
            ->assertExitCode(0);

        $unassignedBills->each(function (Bill $bill) use ($usersToAssignBills) {
            $bill->users->each(function (User $user) use ($usersToAssignBills) {
                $this->assertContains($user->id, $usersToAssignBills->pluck('id'));
            });
        });

        $unassignedBills->each(function (Bill $bill) use ($maxedOutUser) {
            $this->assertNotContains($maxedOutUser->id, $bill->users->pluck('id'));
        });
    }
}
