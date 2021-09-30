<?php

namespace App\Services\MiPay;

use Illuminate\Support\Facades\Http;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\RequestException;
use App\Presentations\Request\TokenPresenter;
use App\Services\Contracts\TokenServiceInterface;
use App\Presentations\Response\FetchTokenResponse;
use App\Transformers\MiPay\CreateTokenTransformer;
use App\Presentations\Response\CancelTokenResponse;
use App\Presentations\Response\CreateTokenResponse;
use App\Services\Contracts\AuthenticationInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MiPayTokenService extends MiPayService implements TokenServiceInterface, AuthenticationInterface
{
    /**
     * Implementation of the token creation logic.
     *
     * @throws AuthenticationException
     * @throws RequestException
     */
    public function create(TokenPresenter $tokenPresenter): CreateTokenResponse
    {
        // Provider authentication id needed and get the token for
        // the further requests.
        $token = $this->authenticate();

        // Make the MiPay specific request array
        $request = (new CreateTokenTransformer($tokenPresenter))->transform();

        // Call the MiPay for the token creation with the endpoint
        // in the providers' configuration.
        $response = Http::withToken($token)
            ->post(config('providers.mipay.create_token_url'), $request);

        // If the provider fails for some reason throw the exception
        // to the gateway api.
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        // If it not fails it can be happened the transaction
        // not created on MiPay side. In this section handle
        // the MiPay specific errors.
        if (! in_array($response->json('response')['ResponseCode'], self::SUCCESS_CODES)) {
            throw new BadRequestHttpException(
                $response->json('response')['Description'].$response->json('response')['ErrorFields']
            );
        }

        // Else create a non provider specific standard response
        // for the gateway api.
        return (new CreateTokenResponse())
            ->setId($response->json('ID'))
            ->setPaymentUrl($response->json('paymentURL'))
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

        // Call the MiPay for the fetch token with the endpoint
        // in the providers' configuration.
        $response = Http::withToken($token)
            ->get(config('providers.mipay.fetch_details').'/'.$paymentToken);

        // If the provider fails for some reason throw the exception
        // to the gateway api.
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        // If it not fails it can be happened the transaction
        // not created on MiPay side. In this section handle
        // the MiPay specific errors.
        if (! in_array($response->json('responseCode'), self::SUCCESS_CODES)) {
            throw new BadRequestHttpException(
                'Error during the fetch: '.$response->json('description')
            );
        }

        // Else create a non provider specific standard response
        // for the gateway api.
        return (new FetchTokenResponse())
            ->setId($response->json('id'))
            ->setStatus($response->json('status'))
            ->setExternalId($response->json('cardToken'))
            ->setOriginalResponse($response->json())
            ->setDetails($response->json('details'));
    }

    /**
     * Implementation of the token cancellation logic.
     */
    public function cancel(string $paymentToken): CancelTokenResponse
    {
        return (new CancelTokenResponse())
            ->setStatus('successful')
            ->setOriginalResponse([]);
    }
}
