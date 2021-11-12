<?php

namespace App\Transformers\Twikey;

use App\Presentations\Request\FetchPaymentPresenter;

class FetchPaymentRequestTransformer
{
    protected FetchPaymentPresenter $fetchPaymentPresenter;

    /**
     * @param FetchPaymentPresenter $fetchPaymentPresenter
     */
    public function __construct(FetchPaymentPresenter $fetchPaymentPresenter)
    {
        $this->fetchPaymentPresenter = $fetchPaymentPresenter;
    }

    public function transform(): array
    {
        return [];
    }
}
