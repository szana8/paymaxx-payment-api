<?php

namespace App\Managers;

use App\Services\MiPay\MiPayTokenService;
use App\Services\PayPal\PayPalTokenService;
use Illuminate\Support\Manager;
use JetBrains\PhpStorm\Pure;

class PaymentTokenServiceManager extends Manager
{
    /**
     * Have to have a valid driver. Can't use just a default one.
     * @return null
     */
    public function getDefaultDriver()
    {
        return null;
    }

    /**
     * Driver for PayPal token actions, like create fetch
     * cancel, etc.
     *
     * @return PayPalTokenService
     */
    public function createPaypalDriver(): PayPalTokenService
    {
        return new PayPalTokenService();
    }

    /**
     * Driver for MiPay token actions.
     *
     * @return MiPayTokenService
     */
    public function createMipayDriver(): MiPayTokenService
    {
        return new MiPayTokenService();
    }

}
