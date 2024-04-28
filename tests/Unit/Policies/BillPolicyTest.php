<?php

namespace Unit\Policies;

use App\Models\Bill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_admins_can_crud_bills(): void
    {
        $admin = $this->createAdminUser();

        $bill = Bill::factory()->create();

        $actions = [
            'viewAny' => Bill::class,
            'view' => $bill,
            'create' => Bill::class,
            'update' => $bill,
            'delete' => $bill,
            'restore' => $bill,
            'forceDelete' => $bill,
        ];

        foreach ($actions as $action => $model) {
            $this->assertTrue($admin->can($action, $model));
        }
    }
}
