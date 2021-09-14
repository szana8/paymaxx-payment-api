<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Managers\PaymentTokenServiceManager;
use App\Presentations\Request\TokenPresenter;
use Illuminate\Http\Request;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $response = $this->paymentTokenServiceManager
            ->driver(\Str::lower($request->get('provider')))
            ->withCredentials($request->get('credentials'))
            ->create(new TokenPresenter($request->get('data')));

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
     * @param  \Illuminate\Http\Request  $request
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
