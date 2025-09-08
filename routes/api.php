<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaxReturnController;
use App\Http\Controllers\Api\TaxCalculatorController;

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

// Tax Return API Routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Tax returns
    Route::get('/tax/returns', [TaxReturnController::class, 'index']);
    Route::post('/tax/returns', [TaxReturnController::class, 'store']);
    Route::get('/tax/returns/{taxReturn}', [TaxReturnController::class, 'show']);
    Route::post('/tax/returns/{taxReturn}/submit', [TaxReturnController::class, 'submit']);
    
    // TODO: Add more API endpoints for income sources, exemptions, payments, etc.
});

// Tax calculation API
Route::post('/tax/calculate', [TaxCalculatorController::class, 'calculate']);
