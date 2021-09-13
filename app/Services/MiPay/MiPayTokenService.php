<?php

namespace App\Services\MiPay;

use App\Presentations\CreateTokenResponse;
use App\Presentations\TokenPresenter;
use App\Services\TokenServiceInterface;
use App\Transformers\MiPay\CreateTokenTransformer;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MiPayTokenService implements TokenServiceInterface
{
    protected string $clientId;

    protected string $clientSecret;

    protected string $merchant;

    /**
     * @throws AuthenticationException
     */
    public function authenticate(): string
    {
        $cacheKey = config('providers.mipay.redis_key_prefix')
                    . $this->merchant
                    . '_access_token';

        if (Cache::get($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $response = Http::post(config('providers.mipay.url') . '/GetAccessToken', [
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

    /**
     * @throws AuthenticationException
     */
    public function create(TokenPresenter $tokenPresenter): CreateTokenResponse
    {
        $token = $this->authenticate();

        $request = (new CreateTokenTransformer($tokenPresenter))->transform();

        $response = Http::withToken($token)
            ->post(config('providers.mipay.url') . '/CreatePaymentToken', $request);

        if ($response->ok()) {
            return (new CreateTokenResponse())
                ->setId($response->json('ID'))
                ->setPaymentUrl($response->json('paymentURL'))
                ->setOriginalResponse($response->json());
        }

        throw $response->throw()->json();
    }

    public function fetch()
    {
        // TODO: Implement fetch() method.
    }

    public function cancel()
    {
        // TODO: Implement cancel() method.
    }

    public function withCredentials(array $credentials): TokenServiceInterface
    {
        $this->clientId = $credentials['clientId'];
        $this->clientSecret = $credentials['clientSecret'];
        $this->merchant = $credentials['merchant'];

        return $this;
    }
}
