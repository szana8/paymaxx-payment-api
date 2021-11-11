<?php

namespace App\Services\Twikey;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\AuthenticationException;

abstract class TwikeyService
{
    /**
     * Merchant Api Token for the authentication.
     */
    protected string $apiToken;

    /**
     * Merchant Contract Template ID for the authentication.
     */
    protected string $contractTemplateId;

    /**
     * Merchant name for the redis key generation.
     */
    protected string $merchant;

    /**
     * Sign method for twikey.
     */
    protected string $signMethod;

    /**
     * Default time to live for the redis cache.
     */
    public const TTL = 3500;

    /**
     * Common authenticate function for all the methods.
     */
    public function authenticate(): string
    {
        Log::debug('Twikey authentication for: '.$this->merchant);

        $cacheKey = sprintf(config('providers.twikey.redis_key'), \Str::snake($this->merchant));

        if (Cache::get($cacheKey)) {
            Log::debug('Get Twikey authentication from cache: '.$cacheKey);

            return Cache::get($cacheKey);
        }

        $response = Http::asForm()->post(config('providers.twikey.get_access_token'), [
            'apiToken' => $this->apiToken,
        ]);

        if ($response->ok()) {
            if ($response->json('error')) {
                Log::error('Something happened during the Twikey authentication.', $response->json());
                Cache::forget($cacheKey);

                throw new AuthenticationException('Invalid credentials for Twikey access.');
            }

            Log::debug('Get access token from Twikey', $response->json());
            Cache::put($cacheKey, $response->json('Authorization'), self::TTL);

            return $response->json('Authorization');
        }

        Log::error('Something happened during the Twikey authentication.', $response->json());
        Cache::forget($cacheKey);

        throw new AuthenticationException('Invalid credentials for Twikey access.');
    }

    /**
     * @param array $credentials
     * @return TwikeyService
     */
    public function withCredentials(array $credentials): self
    {
        $this->apiToken = $credentials['apiToken'];
        $this->contractTemplateId = $credentials['contractTemplateId'];
        $this->merchant = $credentials['merchant'];
        $this->signMethod = $credentials['signMethod'];

        return $this;
    }
}
