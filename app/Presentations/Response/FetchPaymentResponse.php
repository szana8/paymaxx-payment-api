<?php

namespace App\Presentations\Response;

use App\Presentations\BasePresentationObject;

class FetchPaymentResponse extends BasePresentationObject
{
    protected string $id;

    protected string $method;

    protected string $responseCode;

    protected string $status;

    protected array $originalResponse;

    protected array $details;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return FetchPaymentResponse
     */
    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return FetchPaymentResponse
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getResponseCode(): string
    {
        return $this->responseCode;
    }

    /**
     * @param string $responseCode
     * @return FetchPaymentResponse
     */
    public function setResponseCode(string $responseCode): self
    {
        $this->responseCode = $responseCode;

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
     * @return FetchPaymentResponse
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

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
     * @return FetchPaymentResponse
     */
    public function setOriginalResponse(array $originalResponse): self
    {
        $this->originalResponse = $originalResponse;

        return $this;
    }

    /**
     * @return array
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @param array $details
     * @return FetchPaymentResponse
     */
    public function setDetails(array $details): self
    {
        $this->details = $details;

        return $this;
    }
}
