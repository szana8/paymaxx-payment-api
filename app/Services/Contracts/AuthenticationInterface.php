<?php

namespace App\Services\Contracts;

interface AuthenticationInterface
{
    /**
     * Merchant authentication implementation in the provider side.
     */
    public function authenticate(): string;

    /**
     * Register the credentials for the authentication.
     */
    public function withCredentials(array $credentials): self;
}
