<?php

use App\Models\Bill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('bills model functions', function () {
    $bill = Bill::factory()->create();

    $this->user->bills()->attach($bill->id);

    $this->assertDatabaseHas('bill_user', [
        'bill_id' => $bill->id,
        'user_id' => $this->user->id,
    ]);
});
