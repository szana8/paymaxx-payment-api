<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Payment\PaymentManager\Facades\PaymentManager;

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

Route::post('v1/test', function() {
    return PaymentManager::driver('paypal')
        //->with(['test' => true])
        ->purchase();
});

Route::middleware([])->prefix('v1')->group(function () {



});
