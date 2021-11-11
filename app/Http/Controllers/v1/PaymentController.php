<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Managers\PaymentServiceManager;
use App\Presentations\Request\PaymentCapturePresenter;
use App\Presentations\Request\PaymentPresenter;
use App\Presentations\Request\PaymentRefundPresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $response = $this->paymentServiceManager
            ->driver(Str::lower($request->get('provider')))
            ->withCredentials($request->get('credentials'))
            ->create(new PaymentPresenter($request->get('data')));

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, string $external_id): JsonResponse
    {
        $response = $this->paymentServiceManager
            ->driver(Str::lower($request->get('provider')))
            ->withCredentials($request->get('credentials'))
            ->fetch($external_id);

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function capture(Request $request)
    {
        $response = $this->paymentServiceManager
            ->driver(Str::lower($request->get('provider')))
            ->withCredentials($request->get('credentials'))
            ->capture(new PaymentCapturePresenter($request->get('data')));

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refund(Request $request)
    {
        $response = $this->paymentServiceManager
            ->driver(Str::lower($request->get('provider')))
            ->withCredentials($request->get('credentials'))
            ->refund(new PaymentRefundPresenter($request->get('data')));

        return response()->json($response);
    }
}
