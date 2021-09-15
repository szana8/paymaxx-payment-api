<?php

namespace App\Managers;

use App\Services\MiPay\MiPayTokenService;
use App\Services\PayPal\PayPalTokenService;
use Illuminate\Support\Manager;

class PaymentTokenServiceManager extends Manager
{
    public function getDefaultDriver()
    {
        return null;
    }

    public function createPaypalDriver(): PayPalTokenService
    {
        return new PayPalTokenService();
    }

    public function createMipayDriver(): MiPayTokenService
    {
        return new MiPayTokenService();
    }

}
