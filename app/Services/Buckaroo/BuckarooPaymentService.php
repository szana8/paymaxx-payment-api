<?php

namespace App\Services\Buckaroo;

use Illuminate\Support\Facades\Http;
use App\Presentations\Request\FetchPaymentPresenter;
use App\Presentations\Request\CreatePaymentPresenter;
use App\Services\Contracts\TransactionServiceInterface;
use App\Transformers\Buckaroo\CreatePaymentRequestTransformer;

class BuckarooPaymentService extends BuckarooService implements TransactionServiceInterface
{
    public function create(CreatePaymentPresenter $paymentPresenter)
    {
        $hmac = $this->authenticate($paymentPresenter);

        $request = new CreatePaymentRequestTransformer($paymentPresenter);

        $response = Http::withHeaders([
            'Authorization' => $hmac,
            'Content-Type' => 'application/json',
        ])->post(config('providers.buckaroo.url'), $request->transform());

        return $response->body();
    }

    public function fetch(FetchPaymentPresenter $fetchPaymentPresenter)
    {
        // TODO: Implement fetch() method.
    }
}
