<?php

namespace App\Services\Contracts;

use App\Presentations\Request\TokenPresenter;
use App\Presentations\Response\CancelTokenResponse;
use App\Presentations\Response\CreateTokenResponse;
use App\Presentations\Response\FetchTokenResponse;

interface TokenServiceInterface
{
    public function create(TokenPresenter $tokenPresenter): CreateTokenResponse;

    public function fetch($paymentToken): FetchTokenResponse;

    public function cancel(string $paymentToken): CancelTokenResponse;
}
