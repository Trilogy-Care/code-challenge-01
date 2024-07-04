<?php

namespace Tests\Feature;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;
use Tests\TestCase;

class AssignBillsCommandTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * 4 SUBMITTED bills needs to assigned
     */
    public function test_bills_assignment()
    {
        User::factory(5)->create();
        Bill::factory(6)->create([
            'bill_stage_id' => Bill::STAGES['DRAFT']
        ]);
        Bill::factory(4)->create([
            'bill_stage_id' => Bill::STAGES['SUBMITTED']
        ]);

        $this->assertDatabaseEmpty('bill_user'); // no bill assigned yet

        $this->artisan('app:assign-bills');

        $this->assertDatabaseCount('bill_user', 4); // assert that 4 "SUBMITTED" bills are assigned

        $assign = DB::table('bill_user')
            ->where('user_id', 1)
            ->get();
        $this->assertCount(3, $assign); // expected to have 3 bills are assigned to user 1

        $assign = DB::table('bill_user')
            ->where('user_id', 2)
            ->get();
        $this->assertCount(1, $assign); // expected to have 1 bill are assigned to user 2

        $assign = DB::table('bill_user')
            ->whereNotIn('user_id', [1, 2])
            ->get();
        $this->assertCount(0, $assign); // expected that the other users don't have any bill assigned
    }
}
