<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;

class TokenPresenter extends BasePresentationObject
{
    protected string $id;

    protected string $paymentMethod;

    protected string $returnUrl;

    protected string $description;

    protected string $webhookUrl;

    protected PayerPresenter $payer;

    protected ThreeDSecurePresenter $threeDSecure;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->paymentMethod = $data['paymentMethod'];
        $this->returnUrl = $data['returnUrl'];
        $this->description = $data['description'];
        $this->webhookUrl = $data['webhookUrl'];

        if ($data['payer']) {
            $billingAddress = isset($data['payer']['billing']) ? new AddressPresenter($data['payer']['billing']) : null;
            $shippingAddress = isset($data['payer']['shipping']) ? new AddressPresenter($data['payer']['shipping']) : null;

            $this->payer = new PayerPresenter($data['payer'], $billingAddress, $shippingAddress);
        }

        if ($data['3DSecure']) {
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
    public function getDescription(): mixed
    {
        return $this->description;
    }

    /**
     * @return mixed|string
     */
    public function getWebhookUrl(): mixed
    {
        return $this->webhookUrl;
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
