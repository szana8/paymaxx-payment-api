<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;

class IdealPresenter extends BasePresentationObject
{
    protected string $issuerId;

    public function __construct(array $data)
    {
        $this->issuerId = $data['issuerId'];
    }

    /**
     * @return string
     */
    public function getIssuerId(): string
    {
        return $this->issuerId;
    }
}
