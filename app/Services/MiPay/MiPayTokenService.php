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
     * @throws AuthenticationException
     * @throws RequestException
     */
    public function create(TokenPresenter $tokenPresenter): CreateTokenResponse
    {
        $token = $this->authenticate();
        $request = (new CreateTokenTransformer($tokenPresenter))->transform();
        $response = Http::withToken($token)
            ->post(config('providers.mipay.create_token_urls'), $request);

        if ($response->failed()) {
            throw $response->throw()->json();
        }

        if (! in_array($response->json('response')['ResponseCode'], ['0', '00'])) {
            throw new BadRequestHttpException(
                $response->json('response')['Description'].$response->json('response')['ErrorFields']
            );
        }

        return (new CreateTokenResponse())
            ->setId($response->json('ID'))
            ->setPaymentUrl($response->json('paymentURL'))
            ->setOriginalResponse($response->json());
    }

    /**
     * @param $paymentToken
     * @return FetchTokenResponse
     * @throws AuthenticationException
     * @throws RequestException
     */
    public function fetch($paymentToken): FetchTokenResponse
    {
        $token = $this->authenticate();
        $response = Http::withToken($token)
            ->get(config('providers.mipay.fetch_details').'/'.$paymentToken);

        if ($response->failed()) {
            throw $response->throw()->json();
        }

        if (! in_array($response->json('responseCode'), ['0', '00'])) {
            throw new BadRequestHttpException(
                'Error during the fetch:'.$response->json('description')
            );
        }

        return (new FetchTokenResponse())
            ->setId($response->json('id'))
            ->setStatus($response->json('status'))
            ->setExternalId($response->json('cardToken'))
            ->setOriginalResponse($response->json())
            ->setDetails($response->json('details'));
    }

    /**
     * @return CancelTokenResponse
     */
    public function cancel(string $paymentToken): CancelTokenResponse
    {
        return (new CancelTokenResponse())
            ->setStatus('successful')
            ->setOriginalResponse(['test' => 'serezsd a testem']);
    }
}
