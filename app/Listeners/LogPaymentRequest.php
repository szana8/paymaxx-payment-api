<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Events\RequestSending;

class LogPaymentRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param RequestSending $request
     * @return void
     */
    public function handle(RequestSending $request)
    {
        Log::debug(
            $request->request->method().' Payment Request',
            [
                'URL' => $request->request->url(),
                'method' => $request->request->method(),
                'body' => json_decode($request->request->body(), true),
            ]
        );
    }
}
