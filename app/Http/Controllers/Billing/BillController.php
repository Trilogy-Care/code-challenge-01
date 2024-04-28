<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\BillStoreRequest;
use App\Http\Resources\Billing\BillResource;
use App\Models\Bill;
use App\Models\User;
use App\Services\UserBillingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class BillController extends Controller
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

    public function store(BillStoreRequest $request): JsonResponse
    {
        $bill = Bill::create($request->validated());

        return response()->json(
            BillResource::make($bill->load('billStage')),
            Response::HTTP_CREATED
        );
    }
}
