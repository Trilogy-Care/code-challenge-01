<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $bills = Bill::query();

        $request->whenHas('label', function ($label) use ($bills) {
            $bills->byStageLabel($label);
        });

        return response()->json(['count' => $bills->count()]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'bill_reference' => 'required|string',
            'bill_date' => 'required|date',
        ]);

        $bill = Bill::make($validated);
        $bill->submitted_at = now();
        // hard coding 2 (submitted) for the sake of performance on creation,
        // but ideally would find the submitted id via query
        $bill->bill_stage_id = 2;

        $bill->save();

        return response()->json($bill->refresh(), 201);
    }
}
