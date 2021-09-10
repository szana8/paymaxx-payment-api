<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Managers\PaymentTokenServiceManager;
use App\Presentations\TokenPresenter;
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->paymentTokenServiceManager
            ->driver($request->get('provider'))
            ->withCredentials($request->get('credentials'))
            ->create(new TokenPresenter($request->get('data')));
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
