<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Bill;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test bills exist
     */
    public function test_bills_load(): void
    {
        Bill::factory(5)->create();
        $this->assertNotEmpty(Bill::all(), 'issue with Bill factory');
    }

    public function test_bill_create_api(): void
    {
        $user = User::factory()->create();
        $billData = [
            'date' => Carbon::now(),
            'user_id' => $user->id,
        ];
        $response = $this->postJson('/api/bills', $billData);
        $response
            ->assertStatus(200);
    }

    public function test_user_bill_limit(): void
    {
        // create a new test user
        $user = User::factory()->create();
        $this->postJson('/api/bills', $this->getBillData($user))->assertStatus(200);
        $this->postJson('/api/bills', $this->getBillData($user))->assertStatus(200);
        $this->postJson('/api/bills', $this->getBillData($user))->assertStatus(200);
        // 4th bill attached should fail
        $this->postJson('/api/bills', $this->getBillData($user))->assertInvalid('user_id');

    }

    private function getBillData($user) {
        // generate bill data each time to change the date
        return [
            'date' => Carbon::now(),
            'user_id' => $user->id,
        ];
    }
}
