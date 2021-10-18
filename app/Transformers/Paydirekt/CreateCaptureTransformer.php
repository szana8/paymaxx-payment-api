<?php

namespace App\Transformers\Paydirekt;

use App\Presentations\Request\PaymentCapturePresenter;

class CreateCaptureTransformer
{
    protected PaymentCapturePresenter $paymentPresenter;

    public function __construct(PaymentCapturePresenter $paymentPresenter)
    {
        $this->paymentPresenter = $paymentPresenter;
    }

    public function transform(): array
    {
        $data = [
            'finalCapture' => true,
            'amount' => round($this->paymentPresenter->getTransaction()->getAmount() / 100, 2),
            'merchantCaptureReferenceNumber' => $this->paymentPresenter->getTransaction()->getReference(),
            'merchantReconciliationReferenceNumber' => $this->paymentPresenter->getTransaction()->getReference(),
            'captureInvoiceReferenceNumber' => $this->paymentPresenter->getId(),
        ];

        return $data;
    }
}
