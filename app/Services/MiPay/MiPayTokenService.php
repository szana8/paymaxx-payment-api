<?php

namespace App\Services\MiPay;

use App\Presentations\Request\TokenPresenter;
use App\Presentations\Response\CreateTokenResponse;
use App\Services\TokenServiceInterface;
use App\Transformers\MiPay\CreateTokenTransformer;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Http;

class MiPayTokenService extends MiPayService implements TokenServiceInterface
{
    /**
     * @throws AuthenticationException
     */
    public function create(TokenPresenter $tokenPresenter)
    {
        $token = $this->authenticate();

        $request = (new CreateTokenTransformer($tokenPresenter))->transform();

        $response = Http::withToken($token)
            ->post(config('providers.mipay.create_token_url') , $request);

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
