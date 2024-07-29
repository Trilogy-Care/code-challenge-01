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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['bail', 'required', 'exists:users,id'],
            'date' => 'required|date',
        ]);

        $user = User::find($request->user_id);
        // obsoleted by exists validation rule
//        if (!$user) {
//            // Missing entity with ID could be either 400, 404, 412 or 422 and I'd use precadent from other code here
//            return response()->json([
//                'error' => 'No user found with id ['.$request->user_id.']',
//                'result' => 'fail'
//            ], 422);
//
//        }

        $bill_stage = BillStage::where('label', 'Submitted')->first();
        if (!$bill_stage) {
            // Missing bill stage - indicates migrations haven't run
            return response()->json([
                'error' => 'Missing billing stage',
                'result' => 'fail'
            ], 500);
        }

        // Create the bill
        $bill = Bill::create([
            'bill_reference' => $user->name,
            'bill_date' => $request->date,
            'submitted_at' => \Illuminate\Support\Carbon::now()->format('Y-m-d H:i:s'),
            'bill_stage_id' => $bill_stage->id
        ]);

        // Add it to the user - obsoleted. This should be done by the new command
//        $user->bills()->attach($bill);


        return response()->json([
            'bill_id' => $bill->id,
            'result' => 'success'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
