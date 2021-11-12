<?php

namespace App\Services\PayPal;

use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;

abstract class PayPalService
{
    /**
     * Merchant Client ID for the authentication.
     */
    protected string $clientId;

    /**
     * Merchant Client Secret for the authentication.
     */
    protected string $clientSecret;

    /**
     * Merchant name for the redis key generation.
     */
    protected string $merchant;

    /**
     * @throws AuthenticationException
     */
    public function authenticate(): string
    {
        Log::debug('PayPal authentication for: ' . $this->merchant);

        throw new AuthenticationException('Invalid credentials for PayPal access.');
    }
}
