<?php

namespace App\Presentations\Request;

use App\Presentations\BasePresentationObject;

class ThreeDSecureTransactionPresenter extends BasePresentationObject
{
    protected string $currency;

    protected int $amount;

    /**
     * @param string $currency
     * @param int $amount
     */
    public function __construct(string $currency, int $amount)
    {
        $this->currency = $currency;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}
