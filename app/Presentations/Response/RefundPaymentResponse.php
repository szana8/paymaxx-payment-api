<?php

namespace App\Presentations\Response;

use App\Presentations\BasePresentationObject;

class RefundPaymentResponse extends BasePresentationObject
{
    /**
     * ID of the response.
     */
    protected string $id;

    /**
     * Transaction ID of the refund.
     */
    protected string $externalId;

    /**
     * Array of the response.
     */
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
     * @return RefundPaymentResponse
     */
    public function setId(string $id): self
    {
        $this->id = $id;

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
     * @return RefundPaymentResponse
     */
    public function setExternalId(string $externalId): self
    {
        $this->externalId = $externalId;

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
     * @return RefundPaymentResponse
     */
    public function setOriginalResponse(array $originalResponse): self
    {
        $this->originalResponse = $originalResponse;

        return $this;
    }
}
