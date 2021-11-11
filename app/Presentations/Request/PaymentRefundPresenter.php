<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;

class PaymentRefundPresenter extends BasePresentationObject
{
    /**
     * Customer ID in the request.
     */
    protected string $id;

    /**
     * Registered payment token string.
     */
    protected string|null $paymentToken;
    protected string|null $externalId;

    protected TransactionPresenter $transaction;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->externalId = $data['externalId'];
        $this->paymentToken = $data['paymentToken'] ?? null;

        $this->transaction = new TransactionPresenter(
            $data['transaction']['reference'],
            $data['transaction']['description'],
            $data['transaction']['amount'],
            $data['transaction']['currency'],
            $data['transaction']['lines'],
        );
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
    public function getPaymentToken(): string|null
    {
        return $this->paymentToken;
    }

    /**
     * @return mixed|string
     */
    public function getExternalId(): mixed
    {
        return $this->externalId;
    }

    /**
     * @return array
     */
    public function getTransaction(): TransactionPresenter
    {
        return $this->transaction;
    }
}
