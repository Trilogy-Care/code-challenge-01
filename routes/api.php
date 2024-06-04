<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\UserController;
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

Route::get('/bills', [BillController::class, 'index'])->name('bills.index');
Route::post('/bills', [BillController::class, 'store'])->name('bills.store');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
