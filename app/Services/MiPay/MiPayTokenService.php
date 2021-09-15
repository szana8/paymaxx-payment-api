<?php

namespace App\Services\MiPay;

use App\Presentations\Request\TokenPresenter;
use App\Presentations\Response\CreateTokenResponse;
use App\Presentations\Response\FetchPaymentTokenResponse;
use App\Services\TokenServiceInterface;
use App\Transformers\MiPay\CreateTokenTransformer;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MiPayTokenService extends MiPayService implements TokenServiceInterface
{
    /**
     * @throws AuthenticationException
     * @throws RequestException
     */
    public function create(TokenPresenter $tokenPresenter): CreateTokenResponse
    {
        $token = $this->authenticate();

        $request = (new CreateTokenTransformer($tokenPresenter))->transform();

        $response = Http::withToken($token)
            ->post(config('providers.mipay.create_token_url'), $request);


        if ($response->ok()) {
            if(!in_array($response->json('response')['ResponseCode'], ['0', '00'])) {
                throw new BadRequestHttpException(
                    $response->json('response')['Description'] . $response->json('response')['ErrorFields']
                );
            }

            return (new CreateTokenResponse())
                ->setId($response->json('ID'))
                ->setPaymentUrl($response->json('paymentURL'))
                ->setOriginalResponse($response->json());
        }

        throw $response->throw()->json();
    }

    public function fetch($paymentToken)
    {
        $token = $this->authenticate();

        $response = Http::withToken($token)
            ->get(config('providers.mipay.fetch_details') . '/' . $paymentToken);

        if ($response->ok()) {
            if(!in_array($response->json('responseCode'), ['0', '00'])) {
                throw new BadRequestHttpException(
                    'Error during the fetch:' . $response->json('description')
                );
            }

            return (new FetchPaymentTokenResponse())
                ->setId($response->json('id'))
                ->setStatus($response->json('status'))
                ->setOriginalResponse($response->json());
        }

        throw $response->throw()->json();
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
