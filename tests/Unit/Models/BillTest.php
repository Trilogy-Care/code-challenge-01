<?php

namespace Tests\Unit\Models;

use App\Models\Bill;
use App\Models\BillStage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | CRUD Tests
    |--------------------------------------------------------------------------
    */

    public function test_it_can_create_bills(): void
    {
        $data = Bill::factory()->raw();

        Bill::create($data);

        $this->assertDatabaseHas('bills', $data);
    }

    public function test_it_can_update_bills(): void
    {
        $originalBill = Bill::factory()->raw();
        $updatedBill = Bill::factory()->raw();

        $bill = Bill::create($originalBill);

        $bill->update($updatedBill);

        $this->assertDatabaseHas('bills', $updatedBill);
        $this->assertDatabaseMissing('bills', $originalBill);
    }

    public function test_it_can_soft_delete_bills(): void
    {
        $bill = Bill::factory()->create();

        $bill->delete();

        $this->assertSoftDeleted($bill);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship Tests
    |--------------------------------------------------------------------------
    */

    public function test_belongs_to_bill_stage_relationship(): void
    {
        $bill = Bill::factory()->create();
        $stage = BillStage::byLabel(BillStage::DRAFT)->firstOrFail();

        $bill->billStage()->associate($stage)->save();

        $this->assertEquals($stage->id, $bill->billStage->id);

        $this->assertDatabaseHas('bills', [
            'id' => $bill->id,
            'bill_stage_id' => $stage->id,
        ]);
    }

    public function test_belongs_to_many_users_relationship(): void
    {
        $bill = Bill::factory()->create();
        $users = User::factory()->count(3)->create();

        $bill->users()->attach($users);

        $this->assertCount(3, $bill->users);

        $this->assertDatabaseHas('bill_user', [
            'bill_id' => $bill->id,
            'user_id' => $users->first()->id,
        ]);
    }
}
