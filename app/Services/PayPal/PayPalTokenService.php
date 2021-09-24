<?php

namespace App\Services\PayPal;

use App\Presentations\Request\TokenPresenter;
use App\Services\Contracts\TokenServiceInterface;
use App\Presentations\Response\FetchTokenResponse;
use App\Presentations\Response\CancelTokenResponse;
use App\Presentations\Response\CreateTokenResponse;

class PayPalTokenService extends PayPalService implements TokenServiceInterface
{
    public function create(TokenPresenter $tokenPresenter): CreateTokenResponse
    {
        throw new \Exception('Test exception', 500);
    }

    public function fetch($paymentToken): FetchTokenResponse
    {
        // TODO: Implement fetch() method.
    }

    public function cancel(string $paymentToken): CancelTokenResponse
    {
        // TODO: Implement cancel() method.
    }

    public function withCredentials(array $credentials): TokenServiceInterface
    {
        $this->clientId = $credentials['clientId'];
        $this->clientSecret = $credentials['clientSecret'];
        $this->merchant = $credentials['merchant'];

        return $this;
    }
}
