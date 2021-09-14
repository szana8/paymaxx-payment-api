<?php

namespace App\Services\PayPal;

use App\Services\TokenServiceInterface;

class PayPalTokenService implements TokenServiceInterface
{
    public function authenticate()
    {
        // Get authenticate credentials from gateway
        return 'a';
    }

    public function create()
    {
        // TODO: Implement create() method.
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
        // TODO: Implement withCredentials() method.
    }
}
