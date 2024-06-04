<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::query()->with('bills')->get();

        return response()->json($users->map(function (User $user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'total_bills_count' => $user->bills->count(),
                'submitted_bills_count' => $user->bills()->byStageLabel('submitted')->count(),
                'approved_bills_count' => $user->bills()->byStageLabel('approved')->count(),
            ];
        }));
    }
}
