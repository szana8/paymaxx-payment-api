<?php

namespace App\Transformers\Paydirekt;

use App\Presentations\Request\PaymentPresenter;

class CreateCaptureTransformer
{
    protected PaymentPresenter $paymentPresenter;

    public function __construct(PaymentPresenter $paymentPresenter)
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
