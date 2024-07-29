<?php

namespace Tests\Feature\Command;

use App\Models\Bill;
use App\Models\BillStage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignBillTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test bill assignment
     */
    public function test_assign_1_bill_to_1_user(): void
    {
        $submitted = BillStage::where('label', 'Submitted')->first();
        $bill = Bill::factory()->create([
            'bill_stage_id' => $submitted->id
        ]);
        $user = User::factory()->create();
        $this->artisan('app:assign-bills-to-user', ['user' => $user->id]);
        $this->assertNotEmpty($user->bills, 'Failed to assign bill to user');
    }

    /**
     * Test bill assignment again
     */
    public function test_assign_3_bill_to_1_user(): void
    {
        $submitted = BillStage::where('label', 'Submitted')->first();
        $bills = Bill::factory(4)->create([
            'bill_stage_id' => $submitted->id
        ]);
        $user = User::factory()->create();
        $this->artisan('app:assign-bills-to-user', ['user' => $user->id])->assertExitCode(1);
//        $assigned_bills = $user->bills->toArray();
//        foreach ($bills as $bill) {
//            $this->assertTrue(in_array($bill->id, $assigned_bills), 'Failed to assign bill '.$bill->id.' to user');
//        }
    }

}
