<?php

namespace Unit\Policies;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admins_can_crud_users(): void
    {
        $admin = $this->createAdminUser();

        $user = User::factory()->create();

        $actions = [
            'viewAny' => User::class,
            'view' => $user,
            'create' => User::class,
            'update' => $user,
            'delete' => $user,
            'restore' => $user,
            'forceDelete' => $user,
        ];

        foreach ($actions as $action => $model) {
            $this->assertTrue($admin->can($action, $model));
        }
    }
}
