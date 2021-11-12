<?php

namespace App\Services\Contracts;

use App\Presentations\Request\PaymentRefundPresenter;
use App\Presentations\Response\RefundPaymentResponse;

interface RefundableServiceInterface
{
    public function refund(PaymentRefundPresenter $paymentRefundPresenter): RefundPaymentResponse;
}
