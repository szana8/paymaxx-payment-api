<?php

namespace App\Services\PayPal;

use App\Presentations\Request\TokenPresenter;
use App\Services\TokenServiceInterface;

class PayPalTokenService extends PayPalService implements TokenServiceInterface
{
    public function create(TokenPresenter $tokenPresenter)
    {
        throw new \Exception('Test exception', 500);
    }

    public function fetch()
    {
        // TODO: Implement fetch() method.
    }

    public function cancel()
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
