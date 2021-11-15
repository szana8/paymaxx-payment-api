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

    protected string|null $iban;

    protected string|null $bic;

    protected int|null $amount;

    protected string|null $description;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->externalId = $data['externalId'];
        $this->paymentToken = $data['paymentToken'] ?? null;
        $this->amount = $data['amount'] ?? null;
        $this->description = $data['description'] ?? null;
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
     * @return string|null
     */
    public function getIban(): ?string
    {
        return $this->iban;
    }

    /**
     * @return string|null
     */
    public function getBic(): ?string
    {
        return $this->bic;
    }

    /**
     * @return mixed|string|null
     */
    public function getDescription(): mixed
    {
        return $this->description;
    }

    /**
     * @return int|mixed|null
     */
    public function getAmount(): mixed
    {
        return $this->amount;
    }
}
