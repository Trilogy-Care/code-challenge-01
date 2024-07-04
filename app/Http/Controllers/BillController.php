<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillRequest;
use App\Models\Bill;
use App\Models\BillStage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BillController extends Controller
{
    public function create()
    {
        $bill_stages = BillStage::orderBy('order')->get();
        
        return Inertia::render('Bills/Create', compact('bill_stages'));
    }

    public function store(StoreBillRequest $request)
    {
        $data = request()->only(
            'bill_reference',
            'bill_date',
            'bill_stage_id',
        );

        $data['bill_date'] = appCarbonParse($data['bill_date']);

        Bill::create($data);

        return redirect()->back()->with('message', 'Bill added successfully!');
    }
}
