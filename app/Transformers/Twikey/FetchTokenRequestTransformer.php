<?php

namespace App\Transformers\Twikey;

class FetchTokenRequestTransformer
{
    protected string $token;

    protected bool $force = true;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function transform(): array
    {
        return [
            'mndtId' => $this->token,
            'force' => $this->force,
        ];
    }
}
