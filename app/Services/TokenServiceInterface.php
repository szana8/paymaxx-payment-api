<?php

namespace App\Services;

use App\Presentations\Request\TokenPresenter;


interface TokenServiceInterface
{
    public function authenticate(): string;

    public function create(TokenPresenter $tokenPresenter);

    public function fetch($paymentToken);

    public function cancel();

    public function withCredentials(array $credentials) : self;
}
