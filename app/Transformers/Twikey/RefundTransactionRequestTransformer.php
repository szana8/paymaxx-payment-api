<?php

namespace App\Transformers\Twikey;

use App\Presentations\Request\PaymentRefundPresenter;

class RefundTransactionRequestTransformer
{
    protected PaymentRefundPresenter $paymentRefundPresenter;

    public function __construct(PaymentRefundPresenter $paymentRefundPresenter)
    {
        $this->paymentRefundPresenter = $paymentRefundPresenter;
    }

    public function transform(): array
    {
        return [
            'id' => $this->paymentRefundPresenter->getId(),
            'iban' => $this->paymentRefundPresenter->getIban(),
            'bic' => $this->paymentRefundPresenter->getBic(),
            'message' => $this->paymentRefundPresenter->getTransaction()->getDescription(),
            'amount' => $this->paymentRefundPresenter->getTransaction()->getAmount(),
        ];
    }
}
