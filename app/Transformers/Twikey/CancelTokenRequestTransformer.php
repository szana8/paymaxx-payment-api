<?php

namespace App\Transformers\Twikey;

class CancelTokenRequestTransformer
{
    protected string $token;

    protected string $reason = 'Delete by user';

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function transform(): array
    {
        return [
            'mndtId' => $this->token,
            'rsn' => $this->reason,
        ];
    }
}
