<?php

use App\Models\Bill;
use App\Models\BillStage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    User::factory()->create();
    Bill::factory(50)->create();

    foreach (Bill::all() as $bill) {
        $bill->users()->attach(1);
    }
});

it('returns users with bill counts', function () {
    $user = User::find(1);

    $submittedBillStageId = BillStage::where('label', 'Submitted')->first()->id;
    $approvedBillStageId = BillStage::where('label', 'Approved')->first()->id;

    $this->get(route('users.index'))
        ->assertJsonCount(1)
        ->assertJsonFragment([
            'id' => $user->id,
            'name' => $user->name,
            'total_bills_count' => 50,
            'submitted_bills_count' => Bill::where('bill_stage_id', $submittedBillStageId)->count(),
            'approved_bills_count' => Bill::where('bill_stage_id', $approvedBillStageId)->count(),
        ]);
});
