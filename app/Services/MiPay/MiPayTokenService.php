<?php

namespace App\Services\MiPay;

use App\Presentations\Request\TokenPresenter;
use App\Presentations\Response\CreateTokenResponse;
use App\Presentations\Response\FetchPaymentTokenResponse;
use App\Services\Contracts\AuthenticationInterface;
use App\Services\Contracts\TokenServiceInterface;
use App\Transformers\MiPay\CreateTokenTransformer;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
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

    /**
     * @param $paymentToken
     * @return FetchPaymentTokenResponse
     * @throws AuthenticationException
     * @throws RequestException
     */
    public function fetch($paymentToken): FetchPaymentTokenResponse
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
                ->setExternalId($response->json('cardToken'))
                ->setOriginalResponse($response->json());
        }

        throw $response->throw()->json();
    }

    /**
     * @return JsonResponse
     */
    public function cancel(): JsonResponse
    {
        return response()->json(['success' => true]);
    }
}
