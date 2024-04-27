<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\BillStage;
use Illuminate\Database\Eloquent\Builder;

class BillingService extends Service
{
    public function getBillsInStageQuery(string $stageLabel): Builder
    {
        $stage = BillStage::byLabel($stageLabel)->firstOrFail();

        return Bill::inStage($stage);
    }
}
