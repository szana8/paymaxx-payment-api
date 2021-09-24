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
    Route::resource('tokens', \App\Http\Controllers\v1\PaymentTokenController::class);

    Route::resource('payments', \App\Http\Controllers\v1\PaymentController::class);
});
