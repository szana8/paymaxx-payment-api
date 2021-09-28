<?php

namespace App\Presentations\Response;

use App\Presentations\BasePresentationObject;

class CreateTokenizedPaymentResponse extends BasePresentationObject
{
    protected string $id;

    protected string $payment;

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
    public function getPayment(): string
    {
        return $this->payment;
    }

    /**
     * @param string $payment
     * @return CreateTokenizedPaymentResponse
     */
    public function setPayment(string $payment): self
    {
        $this->payment = $payment;

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
     * @return CreateTokenizedPaymentResponse
     */
    public function setResponse(array $response): self
    {
        $this->response = $response;

        return $this;
    }
}
