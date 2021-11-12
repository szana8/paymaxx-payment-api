<?php

namespace App\Services\Contracts;

use App\Presentations\Request\FetchPaymentPresenter;
use App\Presentations\Request\CreatePaymentPresenter;

interface TransactionServiceInterface
{
    /**
     * Implementation of the transaction creation logic.
     */
    public function create(CreatePaymentPresenter $paymentPresenter);

    /**
     * Implementation of the fetch transaction logic.
     */
    public function fetch(FetchPaymentPresenter $fetchPaymentPresenter);
}
