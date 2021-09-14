<?php

namespace App\Transformers\MiPay;

use Illuminate\Support\Collection;

class CreateTokenResponseTransformer
{
    protected array $httpResponse;

    public function __construct(string $httpResponse)
    {
        $this->httpResponse = json_decode($httpResponse, true);
    }

    /**
     * @return Collection
     */
    public function transform(): Collection
    {
        return collect([
            'id' => $this->httpResponse['ID'],
            'paymentUrl' => $this->httpResponse['paymentURL'],
            'originalResponse' => $this->httpResponse
        ]);
    }
}
