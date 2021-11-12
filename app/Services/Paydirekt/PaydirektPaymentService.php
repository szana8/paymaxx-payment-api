<?php

namespace App\Services\Paydirekt;

use Illuminate\Support\Facades\Http;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\RequestException;
use App\Services\Contracts\AuthenticationInterface;
use App\Presentations\Request\FetchPaymentPresenter;
use App\Presentations\Response\FetchPaymentResponse;
use App\Presentations\Request\CreatePaymentPresenter;
use App\Presentations\Request\PaymentCapturePresenter;
use App\Presentations\Response\CapturePaymentResponse;
use App\Services\Contracts\CapturableServiceInterface;
use App\Services\Contracts\TransactionServiceInterface;
use App\Transformers\Paydirekt\CreateCaptureTransformer;
use App\Transformers\Paydirekt\CreateCheckoutTransformer;
use App\Presentations\Response\CreateOneOffPaymentResponse;

class PaydirektPaymentService extends PaydirectService implements AuthenticationInterface, TransactionServiceInterface, CapturableServiceInterface
{
    /**
     * @throws RequestException
     * @throws AuthenticationException
     */
    public function create(CreatePaymentPresenter $paymentPresenter): CreateOneOffPaymentResponse
    {
        $token = $this->authenticate();

        $request = (new CreateCheckoutTransformer($paymentPresenter))->transform();

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
    public function fetch(FetchPaymentPresenter $fetchPaymentPresenter): FetchPaymentResponse
    {
        $token = $this->authenticate();

        $response = Http::withToken($token)
            ->get(config('providers.paydirekt.checkout') . '/' . $fetchPaymentPresenter->getExternalId());

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
