<?php

namespace App\Transformers\Paydirekt;

use App\Presentations\Request\PaymentPresenter;

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
            'type' => 'ORDER_SECURED',
            'totalAmount' => round($this->paymentPresenter->getTransaction()->getAmount() / 100, 2),
            'orderAmount' => round($this->paymentPresenter->getTransaction()->getAmount() / 100, 2),
            'refundLimit' => 100,
            'currency' => $this->paymentPresenter->getTransaction()->getCurrency(),
            'merchantOrderReferenceNumber' => $this->paymentPresenter->getTransaction()->getReference(),
            'merchantInvoiceReferenceNumber' => $this->paymentPresenter->getId(),
            'merchantReconciliationReferenceNumber' => $this->paymentPresenter->getTransaction()->getReference(),
            'redirectUrlAfterSuccess' => $this->paymentPresenter->getReturnUrl(),
            'redirectUrlAfterCancellation' => $this->paymentPresenter->getReturnUrl(),
            'redirectUrlAfterRejection' => $this->paymentPresenter->getReturnUrl(),
            'callbackUrlStatusUpdates' => $this->paymentPresenter->getReturnUrl(),
            'sha256hashedEmailAddress' => base64_encode(
                hash('sha256', utf8_encode($this->paymentPresenter->getPayer()->getEmail()), true)
            ),
            'shoppingCartType' => 'DIGITAL',
            'shippingAddress' => [
                'emailAddress' => $this->paymentPresenter->getPayer()->getEmail(),
                'addresseeGivenName' => 'paydirekt',
                'addresseeLastName' => 'tester',
            ], // It's used for fraud protection with Blueshield
            'customerAuthorizationRequest' => [
                'scopes' => [
                    'PERFORM_CHECKOUT',
                ],
            ],
        ];

        return $data;
    }
}
