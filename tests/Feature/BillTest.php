<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Bill;
use Tests\TestCase;

class BillTest extends TestCase
{
    /**
     * Test bills exist
     */
    public function test_bills_load(): void
    {
        Bill::factory(5)->create();
        $this->assertNotEmpty(Bill::all(), 'issue with Bill factory');
    }
}
