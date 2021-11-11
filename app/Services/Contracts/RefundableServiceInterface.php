<?php

namespace App\Services\Contracts;

use App\Presentations\Request\PaymentRefundPresenter;
use App\Presentations\Response\CapturePaymentResponse;

interface RefundableServiceInterface
{
    public function refund(PaymentRefundPresenter $paymentRefundPresenter): CapturePaymentResponse;
}
