<?php

namespace App\Services\Tikkie;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use App\Services\Contracts\AuthenticationInterface;
use App\Presentations\Request\FetchPaymentPresenter;
use App\Presentations\Response\FetchPaymentResponse;
use App\Transformers\Tikkie\CreateRefundTransformer;
use App\Presentations\Request\CreatePaymentPresenter;
use App\Presentations\Request\PaymentRefundPresenter;
use App\Presentations\Response\RefundPaymentResponse;
use App\Services\Contracts\RefundableServiceInterface;
use App\Services\Contracts\ReversableServiceInterface;
use App\Transformers\Tikkie\CreateCheckoutTransformer;
use App\Presentations\Request\PaymentReversalPresenter;
use App\Presentations\Response\ReversalPaymentResponse;
use App\Services\Contracts\TransactionServiceInterface;
use App\Presentations\Response\CreateOneOffPaymentResponse;

class TikkiePaymentService implements AuthenticationInterface, TransactionServiceInterface, RefundableServiceInterface, ReversableServiceInterface
{
    /**
     * Default time to live for the redis cache.
     */
    public const TTL = 3500;

    /**
     * Api key for the authentication.
     */
    protected string $apiKey;

    /**
     * Xapp token coming from Tikkie admin for the authentication.
     */
    protected string $xAppToken;

    /**
     * Merchant name for the redis key generation.
     */
    protected string $merchant;

    /**
     * Xapp token for the authentication.
     */
    public function authenticate(): string
    {
        return $this->xAppToken;
    }

    /**
     * Register the credentials for the authentication.
     */
    public function withCredentials(array $credentials): self
    {
        $this->apiKey = $credentials['apiKey'];
        $this->xAppToken = $credentials['xAppToken'];

        return $this;
    }

    /**
     * @throws RequestException
     */
    public function create(CreatePaymentPresenter $paymentPresenter): CreateOneOffPaymentResponse
    {
        $headers = [
            'X-App-Token' => $this->authenticate(),
            'API-Key' => $this->apiKey,
        ];

        $request = (new CreateCheckoutTransformer($paymentPresenter))->transform();

        $response = Http::withHeaders($headers)
            ->post(config('providers.tikkie.start_payment'), $request);

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
     */
    public function fetch(FetchPaymentPresenter $fetchPaymentPresenter): FetchPaymentResponse
    {
        $token = $this->authenticate();

        $response = Http::withToken($token)
            ->get(config('providers.tikkie.url') . '/' . $fetchPaymentPresenter->getExternalId());

        if ($response->failed()) {
            throw $response->throw()->json();
        }

        return (new FetchPaymentResponse())
            ->setId($response->json('checkoutId'))
            ->setStatus($response->json('status'))
            ->setOriginalResponse($response->json())
            ->setDetails([]);
    }

    /**
     * @throws RequestException
     */
    public function refund(PaymentRefundPresenter $paymentRefundPresenter): RefundPaymentResponse
    {
        $token = $this->authenticate();
        $headers = [
            'X-App-Token' => $token,
            'API-Key' => $this->apiKey,
        ];

        $request = (new CreateRefundTransformer($paymentRefundPresenter))->transform();

        $response = Http::withHeaders($headers)
            ->post(sprintf(
                config('providers.tikkie.refund'),
                $paymentRefundPresenter->getExternalId(),
                $paymentRefundPresenter->getId()
            ), $request);

        if ($response->failed()) {
            throw $response->throw()->json();
        }

        return (new RefundPaymentResponse())
            ->setId($paymentRefundPresenter->getId())
            ->setExternalId($response->json('transactionId'))
            ->setOriginalResponse($response->json());
    }

    public function reversal(PaymentReversalPresenter $paymentReversalPresenter): ReversalPaymentResponse
    {
        // TODO: Implement reversal() method.
        return new ReversalPaymentResponse();
    }
}
