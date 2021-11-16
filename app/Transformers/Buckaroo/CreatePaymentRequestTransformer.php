<?php

namespace App\Transformers\Buckaroo;

use App\Presentations\Request\CreatePaymentPresenter;

class CreatePaymentRequestTransformer
{
    protected CreatePaymentPresenter $paymentPresenter;

    public function __construct(CreatePaymentPresenter $paymentPresenter)
    {
        $this->paymentPresenter = $paymentPresenter;
    }

    public function transform(): array
    {
        $data = [
            'Currency' => $this->paymentPresenter->getTransaction()->getCurrency(),
            'AmountDebit' => $this->paymentPresenter->getTransaction()->getAmount(),
            'Invoice' => $this->paymentPresenter->getTransaction()->getReference(),
            'ReturnURL' => $this->paymentPresenter->getReturnUrl(),
            'PushURL' => $this->paymentPresenter->getWebhookUrl(),
            'PushURLFailure' => $this->paymentPresenter->getWebhookUrl(),
            'Services' => [
                'ServiceList' => [
                    [
                        'Action' => 'Pay',
                        'Name' => 'ideal',
                        'Parameters' => [
                            [
                                'Name' => 'issuer',
                                'Value' => $this->paymentPresenter->getIdeal()->getIssuerId(),
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $data;
    }
}
