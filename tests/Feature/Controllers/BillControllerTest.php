<?php

use App\Models\Bill;
use App\Models\BillStage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    User::factory(10)->create();
    Bill::factory(50)->create();

    foreach (Bill::all() as $bill) {
        $bill->users()->attach([rand(1, 10)]);
    }
});

it('can get all bills', function () {
    $this->get(route('bills.index'))
        ->assertOk()
        ->assertJsonPath('count', Bill::count());
});

it('can filter bills by stage label', function () {
    $draftBillStageId = BillStage::where('label', 'Draft')->first()->id;

    $this->get(route('bills.index', [
        'label' => 'draft',
    ]))
        ->assertOk()
        ->assertJsonPath('count', Bill::where('bill_stage_id', $draftBillStageId)->count());
});

it('can create a bill', function () {
    $this->post(route('bills.store'), [
        'bill_reference' => 'REF-123',
        'bill_date' => now()->toISOString(),
    ])
        ->assertCreated()
        ->assertJsonStructure([
            'id',
            'bill_reference',
            'bill_date',
            'submitted_at',
            'approved_at',
            'on_hold_at',
            'bill_stage_id',
            'created_at',
            'updated_at',
        ]);
});
