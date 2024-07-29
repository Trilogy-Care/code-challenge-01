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
        $billData = [
            'reference' => 'Feature tests are cool'
        ];
        $response = $this->postJson('/api/bills', $billData);
        $response
            ->assertStatus(200);
    }
}
