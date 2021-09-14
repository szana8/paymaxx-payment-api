<?php

namespace App\Managers;

use App\Services\MiPay\MiPayTokenService;
use Illuminate\Support\Manager;

class PaymentTokenServiceManager extends Manager
{
    public function getDefaultDriver()
    {
        return null;
    }

    public function createMipayDriver(): MiPayTokenService
    {
        return new MiPayTokenService();
    }

}
