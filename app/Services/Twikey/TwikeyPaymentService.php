<?php

namespace App\Services\Twikey;

use Illuminate\Support\Facades\Http;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\RequestException;
use App\Services\Contracts\AuthenticationInterface;
use App\Presentations\Request\FetchPaymentPresenter;
use App\Presentations\Response\FetchPaymentResponse;
use App\Presentations\Request\CreatePaymentPresenter;
use App\Presentations\Request\PaymentRefundPresenter;
use App\Presentations\Response\RefundPaymentResponse;
use App\Services\Contracts\RefundableServiceInterface;
use App\Services\Contracts\ReversableServiceInterface;
use App\Presentations\Request\PaymentReversalPresenter;
use App\Presentations\Response\ReversalPaymentResponse;
use App\Services\Contracts\TransactionServiceInterface;
use App\Transformers\Twikey\FetchPaymentRequestTransformer;
use App\Transformers\Twikey\CreatePaymentRequestTransformer;
use App\Presentations\Response\CreateTokenizedPaymentResponse;
use App\Transformers\Twikey\RefundTransactionRequestTransformer;
use App\Transformers\Twikey\ReversalTransactionRequestTransformer;

class TwikeyPaymentService extends TwikeyService implements AuthenticationInterface, TransactionServiceInterface, RefundableServiceInterface, ReversableServiceInterface
{
    /**
     * Implement start transaction logic.
     *
     * @throws RequestException
     * @throws AuthenticationException
     */
    public function create(CreatePaymentPresenter $paymentPresenter): CreateTokenizedPaymentResponse
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
     * @param FetchPaymentPresenter $fetchPaymentPresenter
     * @return FetchPaymentResponse
     * @throws AuthenticationException
     * @throws RequestException
     */
    public function fetch(FetchPaymentPresenter $fetchPaymentPresenter): FetchPaymentResponse
    {
        // Provider authentication id needed and get the token for
        // the further requests.
        $token = $this->authenticate();

        // Make the Twikey specific request array
        $request = (new FetchPaymentRequestTransformer($fetchPaymentPresenter))->transform();

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

    /**
     * @throws AuthenticationException
     */
    public function refund(PaymentRefundPresenter $paymentRefundPresenter): RefundPaymentResponse
    {
        // Provider authentication id needed and get the token for
        // the further requests.
        $token = $this->authenticate();

        // Make the Twikey specific request array
        $request = (new RefundTransactionRequestTransformer($paymentRefundPresenter))->transform();

        // Call the Twikey the start the payment with an authorization
        // token.
        $response = Http::wixthHeaders(['Authorization' => $token])
            ->asForm()
            ->post(config('providers.twikey.refund_payment'), $request);

        // If the provider fails for some reason throw the exception
        // to the gateway api.
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        // Else create a non provider specific standard response
        // for the gateway api.
        return (new RefundPaymentResponse())
            ->setId($paymentRefundPresenter->getId())
            ->setExternalId($response->json('Entries')[0]['id'])
            ->setOriginalResponse($response->json());
    }

    /**
     * @throws AuthenticationException
     */
    public function reversal(PaymentReversalPresenter $paymentReversalPresenter): ReversalPaymentResponse
    {
        // Provider authentication id needed and get the token for
        // the further requests.
        $token = $this->authenticate();

        // Make the Twikey specific request array
        $request = (new ReversalTransactionRequestTransformer($paymentReversalPresenter))->transform();

        // Call the Twikey the start the payment with an authorization
        // token.
        $response = Http::wixthHeaders(['Authorization' => $token])
            ->asForm()
            ->delete(config('providers.twikey.reversal_payment'), $request);

        // If the provider fails for some reason throw the exception
        // to the gateway api.
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        // Else create a non provider specific standard response
        // for the gateway api.
        return new ReversalPaymentResponse();
    }
}
