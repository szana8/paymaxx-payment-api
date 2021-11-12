<?php

namespace App\Services\Twikey;

use Illuminate\Support\Facades\Http;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\RequestException;
use Symfony\Component\HttpFoundation\Response;
use App\Presentations\Request\PaymentPresenter;
use App\Services\Contracts\AuthenticationInterface;
use App\Presentations\Response\FetchPaymentResponse;
use App\Presentations\Request\PaymentRefundPresenter;
use App\Presentations\Response\RefundPaymentResponse;
use App\Services\Contracts\RefundableServiceInterface;
use App\Services\Contracts\ReversableServiceInterface;
use App\Presentations\Response\ReversalPaymentResponse;
use App\Services\Contracts\TransactionServiceInterface;
use App\Transformers\Twikey\CreatePaymentRequestTransformer;
use App\Presentations\Response\CreateTokenizedPaymentResponse;

class TwikeyPaymentService extends TwikeyService implements AuthenticationInterface, TransactionServiceInterface, RefundableServiceInterface, ReversableServiceInterface
{
    /**
     * Implement start transaction logic.
     *
     * @throws RequestException
     * @throws AuthenticationException
     */
    public function create(PaymentPresenter $paymentPresenter): CreateTokenizedPaymentResponse
    {
        // Provider authentication id needed and get the token for
        // the further requests.
        $token = $this->authenticate();

        // Make the Twikey specific request array
        $request = (new CreatePaymentRequestTransformer($paymentPresenter))->transform();

        // Call the Twikey the start the payment with an authorization
        // token.
        $response = Http::withHeaders(['Authorization' => $token])
            ->asForm()
            ->post(config('providers.twikey.start_payment'), $request);

        // If the provider fails for some reason throw the exception
        // to the gateway api.
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        // Else create a non provider specific standard response
        // for the gateway api.
        return (new CreateTokenizedPaymentResponse())
            ->setId($paymentPresenter->getId())
            ->setExternalId($response->json('Entries')[0]['id'])
            ->setStatus('pending')
            ->setOriginalResponse($response->json());
    }

    /**
     * @param string $external_id
     * @return FetchPaymentResponse
     * @throws AuthenticationException
     * @throws RequestException
     */
    public function fetch(string $external_id): FetchPaymentResponse
    {
        // Provider authentication id needed and get the token for
        // the further requests.
        $token = $this->authenticate();

        // Make the Twikey specific request array
        $request = (new CreatePaymentRequestTransformer($external_id))->transform();

        // Call the Twikey the start the payment with an authorization
        // token.
        $response = Http::withHeaders(['Authorization' => $token])
            ->asForm()
            ->post(config('providers.twikey.fetch_details'), $request);

        // If the provider fails for some reason throw the exception
        // to the gateway api.
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        // Else create a non provider specific standard response
        // for the gateway api.
        return (new FetchPaymentResponse())
            ->setId($response->json('Entries')[0]['id'])
            ->setStatus($response->json('status')[0]['state'])
            ->setOriginalResponse($response->json())
            ->setDetails([]);
    }

    public function refund(PaymentRefundPresenter $paymentRefundPresenter): RefundPaymentResponse
    {
        // Provider authentication id needed and get the token for
        // the further requests.
        $token = $this->authenticate();

        // Make the Twikey specific request array
        $request = (new CreatePaymentRequestTransformer($external_id))->transform();

        // Call the Twikey the start the payment with an authorization
        // token.
        $response = Http::withHeaders(['Authorization' => $token])
            ->asForm()
            ->post(config('providers.twikey.fetch_details'), $request);

        // If the provider fails for some reason throw the exception
        // to the gateway api.
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        // Else create a non provider specific standard response
        // for the gateway api.
        return (new FetchPaymentResponse())
            ->setId($response->json('Entries')[0]['id'])
            ->setStatus($response->json('status')[0]['state'])
            ->setOriginalResponse($response->json())
            ->setDetails([]);
    }

    public function reversal(): ReversalPaymentResponse
    {
        // TODO: Implement reversal() method.
    }
}
