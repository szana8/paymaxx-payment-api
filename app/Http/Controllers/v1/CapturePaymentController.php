<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Managers\PaymentServiceManager;
use App\Presentations\Request\PaymentCapturePresenter;

class CapturePaymentController extends Controller
{
    protected PaymentServiceManager $paymentServiceManager;

    /**
     * @param PaymentServiceManager $paymentServiceManager
     */
    public function __construct(PaymentServiceManager $paymentServiceManager)
    {
        $this->paymentServiceManager = $paymentServiceManager;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $response = $this->paymentServiceManager
            ->driver(Str::lower($request->get('provider')))
            ->withCredentials($request->get('credentials'))
            ->capture(new PaymentCapturePresenter($request->get('data')));

        return response()->json($response);
    }
}
