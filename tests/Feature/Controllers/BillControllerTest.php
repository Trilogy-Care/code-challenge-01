<?php

namespace Tests\Feature\Controllers;

use App\Http\Resources\Billing\BillResource;
use App\Models\Bill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BillControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_create_bills(): void
    {
        $this->postJson(route('bills.store'), [])
            ->assertForbidden();
    }

    public function test_admin_can_create_bills(): void
    {
        $data = Bill::factory()->raw();

        $this
            ->actingAsAdmin()
            ->postJson(route('bills.store'), $data)
            ->assertCreated()
            ->assertJsonStructure(array_keys(BillResource::make(Bill::with('billStage')->latest()->first())->resolve()));

        $this->assertDatabaseHas('bills', $data);
    }
}
