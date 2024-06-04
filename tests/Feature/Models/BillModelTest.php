<?php

use App\Models\Bill;
use App\Models\BillStage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->stage = BillStage::first();
    $this->bill = Bill::factory()->create([
        'bill_stage_id' => $this->stage->id,
    ]);
});

test('users relation functions', function () {
    $user = User::factory()->create();

    $this->bill->users()->attach($user->id);

    $this->assertDatabaseHas('bill_user', [
        'bill_id' => $this->bill->id,
        'user_id' => $user->id,
    ]);
});

test('stage relation functions', function () {
    $this->assertEquals($this->stage->id, $this->bill->stage->id);
});
