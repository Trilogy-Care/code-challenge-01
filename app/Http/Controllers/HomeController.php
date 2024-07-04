<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Inertia\Inertia;

class HomeController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        $submitted_counts = Bill::withStage(Bill::STAGES['SUBMITTED'])->count();
        $approved_counts = Bill::withStage(Bill::STAGES['APPROVED'])->count();
        $on_hold_counts = Bill::withStage(Bill::STAGES['ON_HOLD'])->count();

        $users = User::withCount([
                'bills',
                'bills as submitted_count' => function($q) {
                    $q->where('bill_stage_id', Bill::STAGES['SUBMITTED']);
                },
                'bills as approved_count' => function($q) {
                    $q->where('bill_stage_id', Bill::STAGES['APPROVED']);
                }
            ])
            ->get();

        return Inertia::render('Home', compact(
            'users', 
            'submitted_counts', 
            'approved_counts', 
            'on_hold_counts'
        ));
    }
}
