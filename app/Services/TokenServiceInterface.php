<?php

namespace App\Services;

use App\Presentations\CreateTokenResponse;
use App\Presentations\TokenPresenter;

interface TokenServiceInterface
{
    public function authenticate(): string;

    public function create(TokenPresenter $tokenPresenter): CreateTokenResponse;

    public function fetch();

    public function cancel();

    public function withCredentials(array $credentials) : self;
}
