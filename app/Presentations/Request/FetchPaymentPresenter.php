<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;

class FetchPaymentPresenter extends BasePresentationObject
{
    protected array $request;

    protected string $externalId;

    /**
     * @param array $request
     * @param string $externalId
     */
    public function __construct(array $request, string $externalId)
    {
        $this->request = $request;
        $this->externalId = $externalId;
    }

    /**
     * @return array
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }
}
