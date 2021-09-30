<?php

namespace App\Services\MiPay;

use Illuminate\Support\Facades\Http;
use App\Presentations\Request\PaymentPresenter;
use App\Services\Contracts\AuthenticationInterface;
use App\Presentations\Response\FetchPaymentResponse;
use App\Transformers\MiPay\CreatePaymentTransformer;
use App\Services\Contracts\TransactionServiceInterface;
use App\Presentations\Response\CreateOneOffPaymentResponse;
use App\Presentations\Response\CreateTokenizedPaymentResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MiPayPaymentService extends MiPayService implements AuthenticationInterface, TransactionServiceInterface
{
    public function create(PaymentPresenter $paymentPresenter)
    {
        $token = $this->authenticate();

        $request = (new CreatePaymentTransformer($paymentPresenter))->transform();

        $response = Http::withToken($token)
            ->post(config('providers.mipay.start_payment'), $request);

        if ($response->ok()) {
            if (! in_array($response->json('response')['ResponseCode'], ['0', '00'])) {
                throw new BadRequestHttpException(
                    $response->json('response')['Description'].$response->json('response')['ErrorFields']
                );
            }

            if ($request['returnUrl']) {
                return (new CreateOneOffPaymentResponse())
                ->setId($response->json('ID'))
                ->setPaymentUrl($response->json('paymentURL'))
                ->setOriginalResponse($response->json('response'));
            }

            return (new CreateTokenizedPaymentResponse())
                ->setId($response->json('ID'))
                ->setResponse($response->json('response'));
        }

        throw $response->throw()->json();
    }

    public function fetch(string $external_id)
    {
        $token = $this->authenticate();

        $response = Http::withToken($token)
            ->get(config('providers.mipay.fetch_details').'/'.$external_id);

        if ($response->failed()) {
            throw $response->throw()->json();
        }

        if (! in_array($response->json('responseCode'), ['0', '00'])) {
            throw new BadRequestHttpException(
                'Error during the fetch:'.$response->json('description')
            );
        }

        return (new FetchPaymentResponse())
            ->setId($response->json('id'))
            ->setStatus($response->json('status'))
            ->setOriginalResponse($response->json())
            ->setDetails($response->json('details'));
    }

    public function cancel()
    {
        //
    }
}
