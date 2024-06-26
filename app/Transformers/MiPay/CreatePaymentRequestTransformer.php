<?php

namespace App\Transformers\MiPay;

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
        $this->paymentPresenter->getPayer()->setChannel('auto');

        $data = [
            'id' => $this->paymentPresenter->getId(),
            'paymentMethod' => 'CC',
            'description' => $this->paymentPresenter->getTransaction()->getDescription(),
            'payment' => [
                'currency' =>  $this->paymentPresenter->getTransaction()->getCurrency(),
                'amount' => $this->paymentPresenter->getTransaction()->getAmount(),
            ],
            'customer' => (new CustomerMapper(
                $this->paymentPresenter->getPayer(),
                new AddressMapper(
                    $this->paymentPresenter->getPayer()->getBilling()->getStreet(),
                    $this->paymentPresenter->getPayer()->getBilling()->getCity(),
                    $this->paymentPresenter->getPayer()->getBilling()->getZip(),
                    '',
                    $this->paymentPresenter->getPayer()->getBilling()->getCountry()
                ),
                new AddressMapper(
                    $this->paymentPresenter->getPayer()->getShipping()->getStreet(),
                    $this->paymentPresenter->getPayer()->getShipping()->getCity(),
                    $this->paymentPresenter->getPayer()->getShipping()->getZip(),
                    '',
                    $this->paymentPresenter->getPayer()->getShipping()->getCountry()
                ),
            ))->toArray(),
        ];

        if ($this->paymentPresenter->getPaymentToken()) {
            $data = array_merge($data, ['paymentToken' => $this->paymentPresenter->getPaymentToken()]);
        }

        if ($this->paymentPresenter->getReturnUrl()) {
            $data = array_merge($data, ['returnUrl' => $this->paymentPresenter->getReturnUrl()]);
            $data['customer']['channel'] = 'app';
        }

        return $data;
    }
}
