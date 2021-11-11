<?php

namespace App\Transformers\Tikkie;

use App\Presentations\Request\PaymentRefundPresenter;

class CreateRefundTransformer
{
    protected PaymentRefundPresenter $paymentPresenter;

    public function __construct(PaymentRefundPresenter $paymentPresenter)
    {
        $this->paymentPresenter = $paymentPresenter;
    }

    public function transform(): array
    {
        $data = [
            'amountInCents' => $this->paymentPresenter->getTransaction()->getAmount(),
            'description' => $this->paymentPresenter->getTransaction()->getDescription(),
            'referenceId' => str_replace('-', '', $this->paymentPresenter->getId()),
        ];

        return $data;
    }
}
