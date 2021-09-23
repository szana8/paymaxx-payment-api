<?php

namespace App\Services\MiPay;

use App\Presentations\Request\PaymentPresenter;
use App\Presentations\Response\CancelTokenResponse;
use App\Presentations\Response\CreateTokenResponse;
use App\Services\Contracts\AuthenticationInterface;
use App\Services\Contracts\TransactionServiceInterface;
use App\Transformers\MiPay\CreatePaymentTransformer;
use Illuminate\Support\Facades\Http;
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

    public function fetch()
    {
        // TODO: Implement fetch() method.
    }

    public function cancel()
    {
        //
    }
}
