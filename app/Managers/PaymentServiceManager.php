<?php

namespace App\Managers;

use App\Services\MiPay\MiPayPaymentService;
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
}
