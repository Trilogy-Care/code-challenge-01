<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | CRUD Tests
    |--------------------------------------------------------------------------
    */

    public function test_it_can_create_users(): void
    {
        $data = User::factory()->raw();
        $data['password'] = 'password';

        $user = User::create($data);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $this->assertTrue(Hash::check($data['password'], $user->password));
    }

    public function test_it_can_update_users(): void
    {
        $originalData = User::factory()->raw();
        $updatedData = User::factory()->raw();
        $updatedData['password'] = 'new-password';

        $user = User::create($originalData);

        $user->update($updatedData);

        $this->assertDatabaseHas('users', [
            'name' => $updatedData['name'],
            'email' => $updatedData['email'],
        ]);

        $this->assertTrue(Hash::check($updatedData['password'], $user->password));

        $this->assertDatabaseMissing('users', [
            'name' => $originalData['name'],
            'email' => $originalData['email'],
        ]);
    }

    public function test_it_can_delete_users(): void
    {
        $user = User::factory()->create();

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship Tests
    |--------------------------------------------------------------------------
    */

    public function test_has_many_bills_relationship(): void
    {
        $user = User::factory()->hasBills(3)->create();

        $this->assertCount(3, $user->bills);
    }
}
