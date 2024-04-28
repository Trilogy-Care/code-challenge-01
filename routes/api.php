<?php

use App\Http\Controllers\Billing\BillController;
use App\Http\Controllers\Billing\BillingSummaryController;
use App\Http\Controllers\Billing\UserBillingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('billing-summary', BillingSummaryController::class)->only('index');

Route::apiResource('billing', UserBillingController::class)->only('index');

Route::apiResource('bills', BillController::class)->only('store');
