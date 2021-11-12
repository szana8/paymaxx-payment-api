<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;

class PaymentReversalPresenter extends BasePresentationObject
{
    protected string $id;

    protected string $reference;

    protected string $externalId;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->reference = $data['reference'];
        $this->externalId = $data['externalId'];
    }

    /**
     * @return mixed|string
     */
    public function getId(): mixed
    {
        return $this->id;
    }

    /**
     * @return mixed|string
     */
    public function getReference(): mixed
    {
        return $this->reference;
    }

    /**
     * @return mixed|string
     */
    public function getExternalId(): mixed
    {
        return $this->externalId;
    }
}
