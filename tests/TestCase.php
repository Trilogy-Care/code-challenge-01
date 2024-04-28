<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');
    }

    protected function createAdminUser(): AuthUser{
        return User::factory()->create([
            'email' => User::ADMIN_EMAIL,
        ]);
    }

    protected function actingAsAdmin(): static
    {
        $this->actingAs($this->createAdminUser());

        return $this;
    }
}
