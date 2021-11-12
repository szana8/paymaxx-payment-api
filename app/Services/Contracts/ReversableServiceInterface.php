<?php

namespace App\Services\Contracts;

use App\Presentations\Request\PaymentReversalPresenter;
use App\Presentations\Response\ReversalPaymentResponse;

interface ReversableServiceInterface
{
    public function reversal(PaymentReversalPresenter $paymentReversalPresenter): ReversalPaymentResponse;
}
