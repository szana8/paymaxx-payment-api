<?php

namespace App\Presentations\Response;

use App\Presentations\BasePresentationObject;

class CreateOneOffPaymentResponse extends BasePresentationObject
{
    protected string $id;

    protected string $paymentUrl;

    protected string $externalId;

    protected array $originalResponse;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CreateOneOffPaymentResponse
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getPaymentUrl(): string
    {
        return $this->paymentUrl;
    }

    /**
     * @param string $paymentUrl
     * @return CreateOneOffPaymentResponse
     */
    public function setPaymentUrl(string $paymentUrl): self
    {
        $this->paymentUrl = $paymentUrl;

        return $this;
    }

    /**
     * @return array
     */
    public function getOriginalResponse(): array
    {
        return $this->originalResponse;
    }

    /**
     * @param array $originalResponse
     * @return CreateOneOffPaymentResponse
     */
    public function setOriginalResponse(array $originalResponse): self
    {
        $this->originalResponse = $originalResponse;

        return $this;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }

    /**
     * @param string $externalId
     * @return CreateOneOffPaymentResponse
     */
    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }
}
