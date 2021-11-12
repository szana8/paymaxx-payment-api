<?php

namespace App\Services\Contracts;

use App\Presentations\Request\PaymentCapturePresenter;
use App\Presentations\Response\CapturePaymentResponse;

interface CapturableServiceInterface
{
    public function capture(PaymentCapturePresenter $paymentPresenter): CapturePaymentResponse;
}
