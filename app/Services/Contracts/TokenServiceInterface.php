<?php

namespace App\Services\Contracts;

use App\Presentations\Request\TokenPresenter;
use App\Presentations\Response\CreateTokenResponse;
use App\Presentations\Response\FetchPaymentTokenResponse;


interface TokenServiceInterface
{
    public function create(TokenPresenter $tokenPresenter): CreateTokenResponse;

    public function fetch($paymentToken): FetchPaymentTokenResponse;

    public function cancel();
}
