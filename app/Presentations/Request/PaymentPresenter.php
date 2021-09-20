<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;

class PaymentPresenter extends BasePresentationObject
{
    protected string $id;

    protected string|null $paymentToken;

    protected string $paymentMethod;

    protected string|null $returnUrl;

    protected string|null $webhookUrl;

    protected TransactionPresenter $transaction;

    protected PayerPresenter $payer;

    protected ThreeDSecurePresenter $threeDSecure;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->paymentMethod = $data['paymentMethod'];
        $this->paymentToken = $data['paymentToken'] ?? null;
        $this->returnUrl = $data['returnUrl'] ?? null;
        $this->webhookUrl = $data['webhookUrl'] ?? null;

        $this->transaction = new TransactionPresenter(
            $data['transaction']['reference'],
            $data['transaction']['description'],
            $data['transaction']['amount'],
            $data['transaction']['currency'],
            $data['transaction']['lines'],
        );

        if (isset($data['payer'])) {
            $billingAddress = isset($data['payer']['billing']) ? new AddressPresenter($data['payer']['billing']) : null;
            $shippingAddress = isset($data['payer']['shipping']) ? new AddressPresenter($data['payer']['shipping']) : null;

            $this->payer = new PayerPresenter($data['payer'], $billingAddress, $shippingAddress);
        }

        if (isset($data['3DSecure'])) {
            $this->threeDSecure = new ThreeDSecurePresenter($data['3DSecure']);
        }
    }

    /**
     * @return mixed|string
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getPaymentToken(): string
    {
        return $this->paymentToken;
    }

    /**
     * @return mixed|string
     */
    public function getPaymentMethod(): mixed
    {
        return $this->paymentMethod;
    }

    /**
     * @return mixed|string
     */
    public function getReturnUrl(): mixed
    {
        return $this->returnUrl;
    }

    /**
     * @return mixed|string
     */
    public function getWebhookUrl(): mixed
    {
        return $this->webhookUrl;
    }

    /**
     * @return array
     */
    public function getTransaction(): TransactionPresenter
    {
        return $this->transaction;
    }

    /**
     * @return PayerPresenter
     */
    public function getPayer(): PayerPresenter
    {
        return $this->payer;
    }

    /**
     * @return ThreeDSecurePresenter
     */
    public function getThreeDSecure(): ThreeDSecurePresenter
    {
        return $this->threeDSecure;
    }
}
