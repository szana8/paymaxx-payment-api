<?php

namespace App\Transformers\MiPay;

use App\Presentations\Request\TokenPresenter;

class CreateTokenTransformer
{
    protected TokenPresenter $tokenPresenter;

    public function __construct(TokenPresenter $tokenPresenter)
    {
        $this->tokenPresenter = $tokenPresenter;
        $this->tokenPresenter->getPayer()->setStatus('registration');
        $this->tokenPresenter->getPayer()->setChannel('app');
    }

    public function transform(): array
    {
        return [
            'id' => $this->tokenPresenter->getId(),
            'paymentMethod' => 'CC',
            'returnUrl' => $this->tokenPresenter->getReturnUrl(),
            'description' => $this->tokenPresenter->getDescription(),
            'webhookUrl' => $this->tokenPresenter->getWebhookUrl(),
            'payment' => [
                'currency' => $this->tokenPresenter->getThreeDSecure()->getTransaction()->getCurrency() ?? 'GBP',
                'amount' => $this->tokenPresenter->getThreeDSecure()->getTransaction()->getAmount() ?? 0,
            ],
            'customer' => (new CustomerMapper(
                $this->tokenPresenter->getPayer(),
                new AddressMapper(
                    $this->tokenPresenter->getPayer()->getBilling()->getStreet(),
                    $this->tokenPresenter->getPayer()->getBilling()->getCity(),
                    $this->tokenPresenter->getPayer()->getBilling()->getZip(),
                    '',
                    $this->tokenPresenter->getPayer()->getBilling()->getCountry()
                ),
                new AddressMapper(
                    $this->tokenPresenter->getPayer()->getShipping()->getStreet(),
                    $this->tokenPresenter->getPayer()->getShipping()->getCity(),
                    $this->tokenPresenter->getPayer()->getShipping()->getZip(),
                    '',
                    $this->tokenPresenter->getPayer()->getShipping()->getCountry()
                ),
            ))->toArray(),

        ];
    }
}
