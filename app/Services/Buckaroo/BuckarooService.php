<?php

namespace App\Services\Buckaroo;

abstract class BuckarooService
{
    public function authenticate(): string
    {
        return '';
    }

    public function withCredentials(array $credentials)
    {
        //
    }
}
