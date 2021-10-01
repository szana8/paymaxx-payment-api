<?php

namespace App\Presentations\Response;

use App\Presentations\BasePresentationObject;

class CreateTokenizedPaymentResponse extends BasePresentationObject
{
    protected string $id;

    protected string $externalId;

    protected string $status;

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
     * @return CreateTokenizedPaymentResponse
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
     * @return CreateTokenizedPaymentResponse
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
     * @return CreateTokenizedPaymentResponse
     */
    public function setOriginalResponse(array $originalResponse): self
    {
        $this->originalResponse = $originalResponse;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return CreateTokenizedPaymentResponse
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
