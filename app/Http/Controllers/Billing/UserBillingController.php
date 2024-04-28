<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserBillingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class UserBillingController extends Controller
{
    protected UserBillingService $userBillingService;

    public function __construct()
    {
        $this->userBillingService = UserBillingService::new();
    }

    public function index(): JsonResponse
    {
        Gate::authorize('viewAny', User::class);

        $users = $this->userBillingService->getUserBillingQuery()->get();

        return response()->json($users);
    }
}
