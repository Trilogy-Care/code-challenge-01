<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
    }

    protected function actingAsAdmin(): static
    {
        $this->actingAs(User::factory()->create([
            'email' => User::ADMIN_EMAIL,
        ]));

        return $this;
    }
}
