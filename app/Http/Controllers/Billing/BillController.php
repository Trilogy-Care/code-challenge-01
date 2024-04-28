<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\BillStoreRequest;
use App\Http\Resources\Billing\BillResource;
use App\Models\Bill;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BillController extends Controller
{
    public function store(BillStoreRequest $request): JsonResponse
    {
        $bill = Bill::create($request->validated());

        return response()->json(
            BillResource::make($bill->load('billStage')),
            Response::HTTP_CREATED
        );
    }
}
