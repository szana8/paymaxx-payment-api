<?php

namespace App\Services\Twikey;

use Illuminate\Support\Facades\Http;
use App\Exceptions\NoProviderImplementation;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Client\RequestException;
use Symfony\Component\HttpFoundation\Response;
use App\Presentations\Request\PaymentPresenter;
use App\Services\Contracts\AuthenticationInterface;
use App\Services\Contracts\TransactionServiceInterface;
use App\Transformers\Twikey\CreatePaymentRequestTransformer;
use App\Presentations\Response\CreateTokenizedPaymentResponse;

class TwikeyPaymentService extends TwikeyService implements AuthenticationInterface, TransactionServiceInterface
{
    /**
     * @throws RequestException
     * @throws AuthenticationException
     */
    public function create(PaymentPresenter $paymentPresenter): CreateTokenizedPaymentResponse
    {
        $token = $this->authenticate();

        $request = (new CreatePaymentRequestTransformer($paymentPresenter))->transform();

        $response = Http::withHeaders(['Authorization' => $token])
            ->asForm()
            ->post(config('providers.twikey.start_payment'), $request);

        // If the provider fails for some reason throw the exception
        // to the gateway api.
        if ($response->failed()) {
            throw $response->throw()->json();
        }

        return (new CreateTokenizedPaymentResponse())
            ->setId($paymentPresenter->getId())
            ->setExternalId($response->json('Entries')[0]['id'])
            ->setStatus('pending')
            ->setOriginalResponse($response->json());
    }

    /**
     * @throws NoProviderImplementation
     */
    public function fetch(string $external_id)
    {
        throw new NoProviderImplementation('There is no provider implementation for this functionality.', Response::HTTP_BAD_REQUEST);
    }

    public function cancel()
    {
        // TODO: Implement cancel() method.
    }
}
