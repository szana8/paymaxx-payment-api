<?php

namespace App\Managers;

use Illuminate\Support\Manager;
use App\Services\MiPay\MiPayTokenService;
use App\Services\PayPal\PayPalTokenService;

class PaymentTokenServiceManager extends Manager
{
    /**
     * Have to have a valid driver. Can't use just a default one.
     */
    public function getDefaultDriver()
    {
        return null;
    }

    /**
     * Driver for PayPal token actions, like create fetch
     * cancel, etc.
     */
    public function createPaypalDriver(): PayPalTokenService
    {
        return new PayPalTokenService();
    }

    /**
     * Driver for MiPay token provider specific actions.
     */
    public function createMipayDriver(): MiPayTokenService
    {
        return new MiPayTokenService();
    }
}
