<?php

namespace App\Transformers\Twikey;

use App\Presentations\Request\PaymentReversalPresenter;

class ReversalTransactionRequestTransformer
{
    protected PaymentReversalPresenter $paymentReversalPresenter;

    public function __construct(PaymentReversalPresenter $paymentReversalPresenter)
    {
        $this->paymentReversalPresenter = $paymentReversalPresenter;
    }

    public function transform(): array
    {
        return [
            'id' => $this->paymentReversalPresenter->getId(),
            'ref' => $this->paymentReversalPresenter->getReference(),
        ];
    }
}
