<?php

namespace App\Services\MiPay;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

abstract class MiPayService
{
    protected string $clientId;

    protected string $clientSecret;

    protected string $merchant;

    /**
     * @throws AuthenticationException
     */
    public function authenticate(): string
    {
        $cacheKey = sprintf(config('providers.mipay.redis_key'),  $this->merchant);

        if (Cache::get($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = Http::post(config('providers.mipay.get_access_token'), [
            'clientID' => $this->clientId,
            'clientSecret' => $this->clientSecret,
        ]);

        if ($response->ok()) {
            Cache::put($cacheKey, $response->json()['accessToken'], 3500);
            return $response->json()['accessToken'];
        }

        Cache::forget($cacheKey);

        throw new AuthenticationException('Invalid credentials for MiPay access.');
    }
}
