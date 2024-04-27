<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\BillStage;
use App\Services\BillingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BillingSummaryController extends Controller
{
    protected BillingService $billingService;

    public function __construct()
    {
        $this->billingService = BillingService::new();
    }

    public function index(Request $request)
    {
        Gate::authorize('view-billing-summary', $request->user());

        return response()->json([
            'total_submitted_bills' => $this->billingService->getBillsInStageQuery(BillStage::SUBMITTED)->count(),
            'total_assigned_bills' => $this->billingService->getBillsInStageQuery(BillStage::APPROVED)->count(),
            'total_on_hold_bills' => $this->billingService->getBillsInStageQuery(BillStage::ON_HOLD)->count(),
        ]);
    }
}
