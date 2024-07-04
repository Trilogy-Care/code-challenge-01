<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::post('/', [BillController::class, 'store'])->name('bills.store');

Route::group([
        'controller' => BillController::class, 
        'prefix' => 'bills',
    ], function () {
        Route::get('/create', 'create')->name('bills.create');
        Route::post('/', 'store')->name('bills.store');
    }
);