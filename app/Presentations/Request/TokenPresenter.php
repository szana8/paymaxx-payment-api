<?php

namespace App\Presentations\Request;

use Illuminate\Support\Facades\Log;
use App\Presentations\BasePresentationObject;

class TokenPresenter extends BasePresentationObject
{
    /**
     * Customer ID in the request.
     */
    protected string $id;

    protected string $paymentMethod;

    protected string $returnUrl;

    protected string $description;

    protected string $webhookUrl;

    protected PayerPresenter $payer;

    protected ThreeDSecurePresenter $threeDSecure;

    protected SepaDirectDebitPresenter $sepaDirectDebit;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->paymentMethod = $data['paymentMethod'];
        $this->returnUrl = $data['returnUrl'];
        $this->description = $data['description'];
        $this->webhookUrl = $data['webhookUrl'];

        Log::error('sd', $data);

        if (isset($data['payer'])) {
            $billingAddress = isset($data['payer']['billing']) ? new AddressPresenter($data['payer']['billing']) : null;
            $shippingAddress = isset($data['payer']['shipping']) ? new AddressPresenter($data['payer']['shipping']) : null;

            $this->payer = new PayerPresenter($data['payer'], $billingAddress, $shippingAddress);
        }

        if (isset($data['3DSecure'])) {
            $this->threeDSecure = new ThreeDSecurePresenter($data['3DSecure']);
        }

        if (isset($data['sepa-direct-debit'])) {
            $this->sepaDirectDebit = new SepaDirectDebitPresenter($data['sepa-direct-debit']);
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

    /**
     * @return SepaDirectDebitPresenter
     */
    public function getSepaDirectDebit(): SepaDirectDebitPresenter
    {
        return $this->sepaDirectDebit;
    }
}
