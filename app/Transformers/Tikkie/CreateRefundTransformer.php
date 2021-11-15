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
            'amountInCents' => $this->paymentPresenter->getAmount(),
            'description' => $this->paymentPresenter->getDescription(),
            'referenceId' => str_replace('-', '', $this->paymentPresenter->getId()),
        ];

        return $data;
    }
}
