<?php

namespace App\Transformers\Twikey;

use App\Presentations\Request\PaymentPresenter;

class CreatePaymentRequestTransformer
{
    protected PaymentPresenter $paymentPresenter;

    public function __construct(PaymentPresenter $paymentPresenter)
    {
        $this->paymentPresenter = $paymentPresenter;
    }

    public function transform(): array
    {
        $data = [
            'mndtId' => $this->paymentPresenter->getPaymentToken(),
            'message' => $this->paymentPresenter->getTransaction()->getDescription(),
            'ref' => $this->paymentPresenter->getId(),
            'amount' => $this->paymentPresenter->getTransaction()->getAmount(),
        ];

        return $data;
    }
}
