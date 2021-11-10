<?php

namespace App\Transformers\Tikkie;

use App\Presentations\Request\PaymentPresenter;
use Illuminate\Support\Carbon;

class CreateCheckoutTransformer
{
    protected PaymentPresenter $paymentPresenter;

    public function __construct(PaymentPresenter $paymentPresenter)
    {
        $this->paymentPresenter = $paymentPresenter;
    }

    public function transform(): array
    {
        $data = [
            'amountInCents' => $this->paymentPresenter->getTransaction()->getAmount(),
            'description' => $this->paymentPresenter->getTransaction()->getDescription(),
            'expiryDate' => Carbon::now()->addDay()->toDateString(),
            'referenceId' => str_replace('-', '', $this->paymentPresenter->getId()),
        ];

        return $data;
    }
}
