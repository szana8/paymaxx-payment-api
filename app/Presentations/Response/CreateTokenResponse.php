<?php

namespace App\Presentations\Response;

use App\Presentations\BasePresentationObject;

class CreateTokenResponse extends BasePresentationObject
{
    protected string $id;

    protected string $paymentUrl;

    protected array $originalResponse;

    /**
     * @return array
     */
    public function getOriginalResponse(): array
    {
        return $this->originalResponse;
    }

    /**
     * @param array $originalResponse
     * @return CreateTokenResponse
     */
    public function setOriginalResponse(array $originalResponse): self
    {
        $this->originalResponse = $originalResponse;

        return $this;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return CreateTokenResponse
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
     * @return CreateTokenResponse
     */
    public function setPaymentUrl(string $paymentUrl): self
    {
        $this->paymentUrl = $paymentUrl;

        return $this;
    }
}
