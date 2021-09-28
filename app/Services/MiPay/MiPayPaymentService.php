<?php

namespace App\Services\MiPay;

use Illuminate\Support\Facades\Http;
use App\Presentations\Request\PaymentPresenter;
use App\Services\Contracts\AuthenticationInterface;
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
                ->setResponse($response->json('response'));
            }

            return (new CreateTokenizedPaymentResponse())
                ->setId($response->json('ID'))
                ->setResponse($response->json('response'));
        }

        throw $response->throw()->json();
    }

    public function fetch()
    {
        // TODO: Implement fetch() method.
    }

    public function cancel()
    {
        //
    }
}
