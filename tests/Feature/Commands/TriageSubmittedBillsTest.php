<?php

use App\Models\Bill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Console\Command\Command;

uses(RefreshDatabase::class);

it('successfully assigns all outstanding submitted bills', function () {
    User::factory(10)->create();
    Bill::factory(30)->create([
        'bill_stage_id' => 2,
    ]);

    $this->artisan('app:triage-submitted-bills')
        ->expectsOutput('All unassigned submitted bills have been assigned.')
        ->assertExitCode(COMMAND::SUCCESS);

    expect(Bill::doesntHave('users')->count())->toBe(0);
});

it('one outstanding bill is not assigned', function () {
    User::factory(10)->create();
    Bill::factory(35)->create([
        'bill_stage_id' => 2,
    ]);

    $this->artisan('app:triage-submitted-bills')
        ->expectsOutput('5 bills could not be assigned as the maximum amount of bills assigned to each user has been reached.')
        ->assertExitCode(COMMAND::SUCCESS);

    expect(Bill::doesntHave('users')->count())->toBe(5);
});
