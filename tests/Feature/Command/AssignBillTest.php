<?php

namespace Tests\Feature\Command;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignBillTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test bills exist
     */
    public function test_assign_1_bill_to_1_user(): void
    {
        $bill = Bill::factory()->create();
        $user = User::factory()->create();
        $this->artisan('app:assign-bills-to-user', ['user' => $user->id]);
        $this->assertEquals($bill->id, $user->bills->first()->id, 'Failed to assign bill to user');
    }

}
