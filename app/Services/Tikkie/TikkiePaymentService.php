<?php

namespace App\Services\Tikkie;

use App\Presentations\Request\PaymentCapturePresenter;
use App\Presentations\Request\PaymentPresenter;
use App\Presentations\Request\PaymentRefundPresenter;
use App\Presentations\Response\CapturePaymentResponse;
use App\Presentations\Response\CreateOneOffPaymentResponse;
use App\Presentations\Response\FetchPaymentResponse;
use App\Services\Contracts\AuthenticationInterface;
use App\Services\Contracts\TransactionServiceInterface;
use App\Transformers\Tikkie\CreateCaptureTransformer;
use App\Transformers\Tikkie\CreateCheckoutTransformer;
use App\Transformers\Tikkie\CreatePaymentTransformer;
use App\Transformers\Tikkie\CreateRefundTransformer;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TikkiePaymentService implements AuthenticationInterface, TransactionServiceInterface
{
    /**
     * Default time to live for the redis cache.
     */
    public const TTL = 3500;

    protected string $apiKey;
    protected string $xAppToken;
    /**
     * Merchant name for the redis key generation.
     */
    protected string $merchant;

    public function authenticate(): string
    {
        return $this->xAppToken;
    }

    /**
     * @param array $credentials
     * @return TikkiePaymentService
     */
    public function withCredentials(array $credentials): self
    {
        $this->apiKey = $credentials['apiKey'];
        $this->xAppToken = $credentials['xAppToken'];

        return $this;
    }

    /**
     * @throws RequestException
     * @throws AuthenticationException
     */
    public function create(PaymentPresenter $paymentPresenter): CreateOneOffPaymentResponse
    {
        $token = $this->authenticate();
        $headers = [
            'X-App-Token' => $token,
            'API-Key' => $this->apiKey,
        ];

        $request = (new CreateCheckoutTransformer($paymentPresenter))->transform();

        Log::info('req: ', $request);

        $response = Http::withHeaders($headers)
            ->post(config('providers.tikkie.url'), $request);

        if ($response->failed()) {
            throw $response->throw()->json();
        }

        return (new CreateOneOffPaymentResponse())
            ->setId($paymentPresenter->getId())
            ->setExternalId($response->json('paymentRequestToken'))
            ->setPaymentUrl($response->json('url'))
            ->setOriginalResponse($response->json());
    }

    /**
     * @throws RequestException
     * @throws AuthenticationException
     */
    public function refund(PaymentRefundPresenter $paymentPresenter): CapturePaymentResponse
    {
        $token = $this->authenticate();
        $headers = [
            'X-App-Token' => $token,
            'API-Key' => $this->apiKey,
        ];

        $request = (new CreateRefundTransformer($paymentPresenter))->transform();

        $response = Http::withHeaders($headers)
            ->post(sprintf(config('providers.tikkie.refund'), $paymentPresenter->getExternalId(), $paymentPresenter->getId()), $request);
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
        Log::info('url: ', [config('providers.tikkie.url') . '/' . $external_id]);
        $response = Http::withToken($token)
            ->get(config('providers.tikkie.url') . '/' . $external_id);
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        return (new FetchPaymentResponse())
            ->setId($response->json('checkoutId'))
            ->setStatus($response->json('status'))
            ->setOriginalResponse($response->json())
            ->setDetails([]);
    }

    public function cancel()
    {
        //
    }
}
