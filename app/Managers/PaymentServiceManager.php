<?php

namespace App\Managers;

use Illuminate\Support\Manager;
use App\Services\MiPay\MiPayPaymentService;

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
}
