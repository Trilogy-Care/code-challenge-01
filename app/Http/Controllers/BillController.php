<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillStage;
use App\Models\User;
use App\Rules\UserBillLimit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BillController extends Controller
{

    /**
     * Store a newly created resource in storage.
     * Create a new bill - not assigned to any user in Draft stage
     */
    public function store(Request $request)
    {
        $request->validate([
            'reference' => 'required|max:255',
        ]);

        $bill_stage = BillStage::where('label', 'Draft')->first();
        // Create the bill
        $bill = Bill::create([
            'bill_reference' => $request->reference,
            'bill_date' => Carbon::now(),
            'bill_stage_id' => $bill_stage->id
        ]);

        return response()->json([
            'bill_id' => $bill->id,
            'result' => 'success'
        ]);

    }
}
