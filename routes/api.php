<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware([])->group(function () {
    Route::apiResource('tokens', \App\Http\Controllers\v1\PaymentTokenController::class);

    Route::apiResource('payments', \App\Http\Controllers\v1\PaymentController::class);
    Route::post('payments/{payment}/capture', [\App\Http\Controllers\v1\PaymentController::class, 'capture']);
    Route::post('payments/{payment}/refund', [\App\Http\Controllers\v1\PaymentController::class, 'refund']);
});
