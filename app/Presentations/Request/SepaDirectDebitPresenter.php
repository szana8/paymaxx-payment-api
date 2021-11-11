<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;

class SepaDirectDebitPresenter extends BasePresentationObject
{
    protected string $bic;

    public function __construct(array $data)
    {
        $this->bic = $data['bic'];
    }

    /**
     * @return string
     */
    public function getBic(): string
    {
        return $this->bic;
    }
}
