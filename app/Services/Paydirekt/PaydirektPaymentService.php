<?php

namespace App\Services\Paydirekt;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\RequestException;
use App\Presentations\Request\PaymentPresenter;
use App\Services\Contracts\AuthenticationInterface;
use App\Presentations\Response\FetchPaymentResponse;
use App\Presentations\Request\PaymentCapturePresenter;
use App\Presentations\Response\CapturePaymentResponse;
use App\Services\Contracts\CapturableServiceInterface;
use App\Services\Contracts\TransactionServiceInterface;
use App\Transformers\Paydirekt\CreateCaptureTransformer;
use App\Transformers\Paydirekt\CreateCheckoutTransformer;
use App\Presentations\Response\CreateOneOffPaymentResponse;

class PaydirektPaymentService implements AuthenticationInterface, TransactionServiceInterface, CapturableServiceInterface
{
    /**
     * Default time to live for the redis cache.
     */
    public const TTL = 3500;

    protected string $apiKey;

    protected string $apiSecret;

    /**
     * Merchant name for the redis key generation.
     */
    protected string $merchant;

    public function authenticate(): string
    {
        Log::debug('Paydirekt authentication for: '.$this->merchant);

        $cacheKey = sprintf(config('providers.paydirekt.redis_key'), \Str::snake($this->merchant));

        if (Cache::get($cacheKey)) {
            Log::debug('Get Paydirekt authentication from cache: '.$cacheKey);

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

    /**
     * @throws RequestException
     * @throws AuthenticationException
     */
    public function create(PaymentPresenter $paymentPresenter): CreateOneOffPaymentResponse
    {
        $token = $this->authenticate();

        $request = (new CreateCheckoutTransformer($paymentPresenter))->transform();
        Log::info('req: ', $request);

        $response = Http::withToken($token)
            ->post(config('providers.paydirekt.checkout'), $request);

        if ($response->failed()) {
            throw $response->throw()->json();
        }

        return (new CreateOneOffPaymentResponse())
            ->setId($paymentPresenter->getId())
            ->setExternalId($response->json('checkoutId'))
            ->setPaymentUrl($response->json('_links.approve.href'))
            ->setOriginalResponse($response->json());
    }

    /**
     * @throws RequestException
     * @throws AuthenticationException
     */
    public function capture(PaymentCapturePresenter $paymentPresenter): CapturePaymentResponse
    {
        $token = $this->authenticate();

        $request = (new CreateCaptureTransformer($paymentPresenter))->transform();

        $response = Http::withToken($token)
            ->post(sprintf(config('providers.paydirekt.capture'), $paymentPresenter->getExternalId()), $request);

        if ($response->failed()) {
            throw $response->throw()->json();
        }

        return (new CapturePaymentResponse())
            ->setId($paymentPresenter->getId())
            ->setExternalId($response->json('transactionId'))
            ->setOriginalResponse($response->json());
    }

    /**
     * @throws RequestException
     * @throws AuthenticationException
     */
    public function fetch(string $external_id): FetchPaymentResponse
    {
        $token = $this->authenticate();

        Log::info('url: ', [config('providers.paydirekt.checkout').'/'.$external_id]);
        $response = Http::withToken($token)
            ->get(config('providers.paydirekt.checkout').'/'.$external_id);

        if ($response->failed()) {
            throw $response->throw()->json();
        }

        return (new FetchPaymentResponse())
            ->setId($response->json('checkoutId'))
            ->setStatus($response->json('status'))
            ->setOriginalResponse($response->json())
            ->setDetails([]);
    }
}
