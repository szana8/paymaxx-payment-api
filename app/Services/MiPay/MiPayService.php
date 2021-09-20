<?php

namespace App\Services\MiPay;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

abstract class MiPayService
{
    /**
     * Merchant Client ID for the authentication.
     */
    protected string $clientId;

    /**
     * Merchant Client Secret for the authentication.
     */
    protected string $clientSecret;

    /**
     * Merchant name for the redis key generation.
     */
    protected string $merchant;

    /**
     * Default time to live for the redis cache
     */
    const TTL = 3500;

    /**
     * @throws AuthenticationException
     */
    public function authenticate(): string
    {
        Log::debug('MiPay authentication for: ' . $this->merchant);

        $cacheKey = sprintf(config('providers.mipay.redis_key'), \Str::snake($this->merchant));

        if (Cache::get($cacheKey)) {
            Log::debug('Get MiPay authentication from cache: ' . $cacheKey);
            return Cache::get($cacheKey);
        }

        $response = Http::post(config('providers.mipay.get_access_token'), [
            'clientID' => $this->clientId,
            'clientSecret' => $this->clientSecret,
        ]);

        if ($response->ok()) {
            if ($response->json('error')) {
                Log::error('Something happened during the MiPay authentication.', $response->json());
                Cache::forget($cacheKey);

                throw new AuthenticationException('Invalid credentials for MiPay access.');
            }

            Log::debug('Get access token from MiPay', $response->json());
            Cache::put($cacheKey, $response->json()['accessToken'], self::TTL);
            return $response->json()['accessToken'];
        }

        Log::error('Something happened during the MiPay authentication.', $response->json());
        Cache::forget($cacheKey);

        throw new AuthenticationException('Invalid credentials for MiPay access.');
    }

    /**
     * @param array $credentials
     * @return MiPayTokenService
     */
    public function withCredentials(array $credentials): self
    {
        $this->clientId = $credentials['clientId'];
        $this->clientSecret = $credentials['clientSecret'];
        $this->merchant = $credentials['merchant'];

        return $this;
    }
}
