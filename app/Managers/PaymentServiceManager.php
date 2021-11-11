<?php

namespace App\Managers;

use App\Services\MiPay\MiPayPaymentService;
use App\Services\Paydirekt\PaydirektPaymentService;
use App\Services\Tikkie\TikkiePaymentService;
use App\Services\Twikey\TwikeyPaymentService;
use Illuminate\Support\Manager;

class PaymentServiceManager extends Manager
{
    public function getDefaultDriver()
    {
        return null;
    }

    public function createMipayDriver(): MiPayPaymentService
    {
        return new MiPayPaymentService();
    }

    public function createPaydirektDriver(): PaydirektPaymentService
    {
        return new PaydirektPaymentService();
    }

    public function createTikkieDriver(): TikkiePaymentService
    {
        return new TikkiePaymentService();
    }

    public function createTwikeyDriver(): TwikeyPaymentService
    {
        return new TwikeyPaymentService();
    }
}
