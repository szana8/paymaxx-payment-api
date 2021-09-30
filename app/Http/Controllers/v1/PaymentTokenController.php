<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Managers\PaymentTokenServiceManager;
use App\Presentations\Request\TokenPresenter;

class PaymentTokenController extends Controller
{
    /**
     * A common token service manager class for all the providers.
     */
    protected PaymentTokenServiceManager $paymentTokenServiceManager;

    /**
     * Initialize the token service manager to perform actions.
     */
    public function __construct(PaymentTokenServiceManager $paymentTokenServiceManager)
    {
        $this->paymentTokenServiceManager = $paymentTokenServiceManager;
    }

    /**
     * Create a new token in the database and call the provider
     * specific call with the request data.
     */
    public function store(Request $request): JsonResponse
    {
        $response = $this->paymentTokenServiceManager
            ->driver(Str::lower($request->get('provider')))
            ->withCredentials($request->get('credentials'))
            ->create(new TokenPresenter($request->get('data')));

        return response()->json($response);
    }

    /**
     * Use this endpoint for the fetch token details from
     * the providers.
     */
    public function show(Request $request, string $token): JsonResponse
    {
        $response = $this->paymentTokenServiceManager
            ->driver(Str::lower($request->get('provider')))
            ->withCredentials($request->get('credentials'))
            ->fetch($token);

        return response()->json($response);
    }

    /**
     * Start to cancel the token on the provider side.
     */
    public function destroy(Request $request, string $token): JsonResponse
    {
        $response = $this->paymentTokenServiceManager
            ->driver(Str::lower($request->get('provider')))
            ->withCredentials($request->get('credentials'))
            ->cancel($token);

        return response()->json($response);
    }
}
