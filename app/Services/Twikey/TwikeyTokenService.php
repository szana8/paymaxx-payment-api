<?php

namespace App\Services\Twikey;

use Illuminate\Support\Facades\Http;
use App\Presentations\Request\TokenPresenter;
use App\Presentations\Response\CreateTokenResponse;
use App\Services\Contracts\AuthenticationInterface;
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
            ->setMethod('sofort')
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
}
