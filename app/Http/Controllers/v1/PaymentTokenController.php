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
    protected PaymentTokenServiceManager $paymentTokenServiceManager;

    public function __construct(PaymentTokenServiceManager $paymentTokenServiceManager)
    {
        $this->paymentTokenServiceManager = $paymentTokenServiceManager;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
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
     * Display the specified resource.
     *
     * @param Request $request
     * @param string $token
     * @return JsonResponse
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
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param string $token
     * @return JsonResponse
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
