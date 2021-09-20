<?php

namespace App\Services\Contracts;

interface AuthenticationInterface
{
    public function authenticate(): string;

    public function withCredentials(array $credentials);
}
