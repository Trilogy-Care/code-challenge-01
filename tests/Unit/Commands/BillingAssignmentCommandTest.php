<?php

namespace Tests\Unit\Commands;

use App\Models\Bill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillingAssignmentCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_billing_assignment_command_correctly_assigns_bills_to_users(): void
    {
        $unassignedBills = Bill::factory()->count(5)->create();
        $assignedBills = Bill::factory()->count(5)->assignedTouser()->create();

        $this->artisan('bills:assign')
            ->expectsOutput('5 bills have been assigned to users.')
            ->assertExitCode(0);

        $this->assertDatabaseCount('bills', 10);
    }
}
