<?php

namespace App\Services;

use App\Presentations\TokenPresenter;

interface TokenServiceInterface
{
    public function authenticate(): string;

    public function create(TokenPresenter $tokenPresenter);

    public function fetch();

    public function cancel();

    public function withCredentials(array $credentials) : self;
}
