<?php

namespace App\Transformers\Twikey;

use App\Presentations\Request\TokenPresenter;

class CreateTokenRequestTransformer
{
    protected TokenPresenter $tokenPresenter;

    protected string $contractTemplateId;

    protected string $method;

    public function __construct(TokenPresenter $tokenPresenter)
    {
        $this->tokenPresenter = $tokenPresenter;
    }

    public function transform(): array
    {
        return [
            'check' => false,
            'token' => $this->tokenPresenter->getId(),
            'ct' => $this->getContractTemplateId(),
            'method' => $this->getMethod(),
            'bic' => $this->tokenPresenter->getSepaDirectDebit()->getBic(),
        ];
    }

    /**
     * @return string
     */
    public function getContractTemplateId(): string
    {
        return $this->contractTemplateId;
    }

    /**
     * @param string $contractTemplateId
     * @return CreateTokenRequestTransformer
     */
    public function setContractTemplateId(string $contractTemplateId): self
    {
        $this->contractTemplateId = $contractTemplateId;

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
     * @return CreateTokenRequestTransformer
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }
}
