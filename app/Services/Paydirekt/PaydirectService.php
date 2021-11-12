<?php

namespace App\Services\Paydirekt;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\AuthenticationException;

abstract class PaydirectService
{
    /**
     * Default time to live for the redis cache.
     */
    public const TTL = 3500;

    /**
     * @var string
     */
    protected string $apiKey;

    /**
     * @var string
     */
    protected string $apiSecret;

    /**
     * Merchant name for the redis key generation.
     */
    protected string $merchant;

    public function authenticate(): string
    {
        Log::debug('Paydirekt authentication for: ' . $this->merchant);

        $cacheKey = sprintf(config('providers.paydirekt.redis_key'), \Str::snake($this->merchant));

        if (Cache::get($cacheKey)) {
            Log::debug('Get Paydirekt authentication from cache: ' . $cacheKey);

            return Cache::get($cacheKey);
        }

        $dateTime = Carbon::now('UTC');
        $nonce = strtr(base64_encode(random_bytes(48)), '+/', '-_');
        $requestId = Uuid::uuid4()->toString();

        $headers = [
            'X-Auth-Key' => $this->apiKey,
            'X-Auth-Code' => Hmac::signature(
                $requestId,
                $dateTime->format('YmdHis'),
                $this->apiKey,
                $this->apiSecret,
                $nonce
            ),
            'X-Request-ID' => $requestId,
            'X-Date' => $dateTime->format(Carbon::RFC7231),
            'Content-Type' => 'application/hal+json;charset=utf-8',
        ];

        $response = Http::withHeaders($headers)
            ->post(config('providers.paydirekt.get_access_token'), [
                'grantType' => 'api_key',
                'randomNonce' => $nonce,
            ]);

        if ($response->ok()) {
            Log::debug('Get access token from Paydirekt', $response->json());
            Cache::put($cacheKey, $response->json()['access_token'], self::TTL);

            return $response->json()['access_token'];
        }

        Log::error('Something happened during the Paydirekt authentication.', $response->json());
        Cache::forget($cacheKey);

        throw new AuthenticationException('Invalid credentials for Paydirekt access.');
    }

    /**
     * @param array $credentials
     * @return PaydirektPaymentService
     */
    public function withCredentials(array $credentials): self
    {
        $this->apiKey = $credentials['apiKey'];
        $this->apiSecret = $credentials['apiSecret'];
        $this->merchant = $credentials['merchant'];

        return $this;
    }
}
