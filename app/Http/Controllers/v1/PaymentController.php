<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Managers\PaymentServiceManager;
use App\Presentations\Request\PaymentPresenter;

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
