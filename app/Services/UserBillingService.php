<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\BillStage;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class UserBillingService extends Service
{
    const MAX_USER_BILLS = 3;

    public function getUnassignedBillsQuery(): EloquentBuilder
    {
        $submitted = BillStage::byLabel(BillStage::SUBMITTED)->first();

        return Bill::inStage($submitted)->whereDoesntHave('users');
    }

    public function getUsersWithoutMaxBillsQuery(): EloquentBuilder
    {
        return User::has('bills', '<', self::MAX_USER_BILLS);
    }

    public function getUserBillingQuery(): QueryBuilder
    {
        return DB::table('users')
            ->leftJoin('bill_user', 'users.id', '=', 'bill_user.user_id')
            ->leftJoin('bills', function ($join) {
                $join->on('bill_user.bill_id', '=', 'bills.id')
                    ->whereNull('bills.deleted_at');
            })
            ->leftJoin('bill_stages', 'bills.bill_stage_id', '=', 'bill_stages.id')
            ->select('users.name')
            ->selectRaw('COUNT(bills.id) as total_bills')
            ->selectRaw('SUM(CASE WHEN bill_stages.label = ? THEN 1 ELSE 0 END) as total_submitted_bills', [BillStage::SUBMITTED])
            ->selectRaw('SUM(CASE WHEN bill_stages.label = ? THEN 1 ELSE 0 END) as total_approved_bills', [BillStage::APPROVED])
            ->groupBy('users.id', 'users.name');
    }
}
