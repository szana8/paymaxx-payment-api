<?php

namespace App\Services\Twikey;

use Illuminate\Support\Facades\Http;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\RequestException;
use App\Presentations\Request\TokenPresenter;
use App\Presentations\Response\FetchTokenResponse;
use App\Presentations\Response\CancelTokenResponse;
use App\Presentations\Response\CreateTokenResponse;
use App\Services\Contracts\AuthenticationInterface;
use App\Transformers\Twikey\FetchTokenRequestTransformer;
use App\Transformers\Twikey\CancelTokenRequestTransformer;
use App\Transformers\Twikey\CreateTokenRequestTransformer;

class TwikeyTokenService extends TwikeyService implements AuthenticationInterface
{
    /**
     * With twikey the token functionality called mandate.
     */
    public function create(TokenPresenter $tokenPresenter)
    {
        $token = $this->authenticate();

        // Make the Twikey specific request array
        $request = (new CreateTokenRequestTransformer($tokenPresenter))
            ->setContractTemplateId($this->contractTemplateId)
            ->setMethod($this->signMethod)
            ->transform();

        // Call the MiPay for the token creation with the endpoint
        // in the providers' configuration.
        $response = Http::withHeaders(['Authorization' => $token])
            ->asForm()
            ->post(config('providers.twikey.create_token_url'), $request);

        // If the provider fails for some reason throw the exception
        // to the gateway api.
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        // Else create a non provider specific standard response
        // for the gateway api.
        return (new CreateTokenResponse())
            ->setId($response->json('MndtId'))
            ->setPaymentUrl($response->json('url'))
            ->setOriginalResponse($response->json());
    }

    /**
     * Implementation of the fetch token logic.
     *
     * @throws AuthenticationException
     * @throws RequestException
     */
    public function fetch($paymentToken): FetchTokenResponse
    {
        // Provider authentication id needed and get the token for
        // the further requests.
        $token = $this->authenticate();

        // Make the Twikey specific request array
        $request = new FetchTokenRequestTransformer($paymentToken);

        // Call the MiPay for the fetch token with the endpoint
        // in the providers' configuration.
        $response = Http::withHeaders(['Authorization' => $token])
            ->get(config('providers.twikey.fetch_token_details'), $request->transform());

        // If the provider fails for some reason throw the exception
        // to the gateway api.
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        // Else create a non provider specific standard response
        // for the gateway api.
        return (new FetchTokenResponse())
            ->setId($response->json('Mndt')['Cdtr']['Id'])
            ->setStatus($response->header('X-STATE'))
            ->setExternalId($paymentToken)
            ->setOriginalResponse($response->json())
            ->setDetails(['mandateId' => $paymentToken]);
    }

    /**
     * Implementation of the token cancellation logic.
     */
    public function cancel(string $paymentToken)
    {
        // Provider authentication id needed and get the token for
        // the further requests.
        $token = $this->authenticate();

        // Make the Twikey specific request array
        $request = new CancelTokenRequestTransformer($paymentToken);

        // Call the MiPay for the fetch token with the endpoint
        // in the providers' configuration.
        $response = Http::withHeaders(['Authorization' => $token])
            ->get(config('providers.twikey.cancel_token'), $request->transform());

        // If the provider fails for some reason throw the exception
        // to the gateway api.
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        // Else create a non provider specific standard response
        // for the gateway api.
        return (new CancelTokenResponse())
            ->setStatus('successful')
            ->setOriginalResponse($response->json());
    }
}
