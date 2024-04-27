<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\BillStage;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserBillingService extends Service
{
    const MAX_USER_BILLS = 3;

    public function getUnassignedBillsQuery(): Builder
    {
        $submitted = BillStage::byLabel(BillStage::SUBMITTED)->first();

        return Bill::inStage($submitted)->whereDoesntHave('users');
    }

    public function getUsersWithoutMaxBillsQuery(): Builder
    {
        return User::has('bills', '<', self::MAX_USER_BILLS);
    }
}
