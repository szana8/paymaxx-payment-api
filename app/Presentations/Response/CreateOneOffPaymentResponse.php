<?php

namespace App\Presentations\Response;

use App\Presentations\BasePresentationObject;

class CreateOneOffPaymentResponse extends BasePresentationObject
{
    protected string $id;

    protected string $paymentUrl;

    protected array $response;

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
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * @param array $response
     * @return CreateOneOffPaymentResponse
     */
    public function setResponse(array $response): self
    {
        $this->response = $response;

        return $this;
    }
}
