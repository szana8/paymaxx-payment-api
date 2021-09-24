<?php

namespace App\Transformers\MiPay;

use App\Presentations\Request\PaymentPresenter;

class CreatePaymentTransformer
{
    protected PaymentPresenter $paymentPresenter;

    public function __construct(PaymentPresenter $paymentPresenter)
    {
        $this->paymentPresenter = $paymentPresenter;
    }

    public function transform(): array
    {
        $data = [
            'id' => $this->paymentPresenter->getId(),
            'paymentMethod' => 'CC',
            'paymentToken' => $this->paymentPresenter->getPaymentToken(),
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

        if ($this->paymentPresenter->getReturnUrl()) {
            $data = array_merge($data, ['returnUrl' => $this->paymentPresenter->getReturnUrl()]);
        }

        return $data;
    }
}
