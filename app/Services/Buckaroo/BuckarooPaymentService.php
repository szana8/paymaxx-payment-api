<?php

namespace App\Services\Buckaroo;

use App\Services\Contracts\AuthenticationInterface;
use App\Presentations\Request\FetchPaymentPresenter;
use App\Presentations\Request\CreatePaymentPresenter;
use App\Services\Contracts\TransactionServiceInterface;

class BuckarooPaymentService extends BuckarooService implements AuthenticationInterface, TransactionServiceInterface
{
    public function create(CreatePaymentPresenter $paymentPresenter)
    {
        return response()->json($paymentPresenter->toArray());
    }

    public function fetch(FetchPaymentPresenter $fetchPaymentPresenter)
    {
        // TODO: Implement fetch() method.
    }
}
