<?php

namespace App\Services\Contracts;

use App\Presentations\Request\PaymentPresenter;

interface TransactionServiceInterface
{
    /**
     * Implementation of the transaction creation logic.
     */
    public function create(PaymentPresenter $paymentPresenter);

    /**
     * Implementation of the fetch transaction logic.
     */
    public function fetch(string $external_id);
}
