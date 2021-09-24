<?php

namespace App\Services\Contracts;

use App\Presentations\Request\PaymentPresenter;

interface TransactionServiceInterface
{
    public function create(PaymentPresenter $paymentPresenter);

    public function fetch();

    public function cancel();
}
