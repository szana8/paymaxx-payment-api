<?php

namespace App\Services\Contracts;

use App\Presentations\Request\TokenPresenter;
use App\Presentations\Response\FetchTokenResponse;
use App\Presentations\Response\CancelTokenResponse;
use App\Presentations\Response\CreateTokenResponse;

interface TokenServiceInterface
{
    /**
     * Implementation of the token creation logic.
     */
    public function create(TokenPresenter $tokenPresenter): CreateTokenResponse;

    /**
     * Implementation of the fetch token logic.
     */
    public function fetch($paymentToken): FetchTokenResponse;

    /**
     * Implementation of the token cancellation logic.
     */
    public function cancel(string $paymentToken): CancelTokenResponse;
}
