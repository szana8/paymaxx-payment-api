<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Events\ResponseReceived;

class LogPaymentResponse
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
     * @param ResponseReceived $event
     * @return void
     */
    public function handle(ResponseReceived $event)
    {
        Log::debug(
            'Provider Response',
            [
                'status' => $event->response->status(),
                'body' => $event->response->body(),
            ]
        );
    }
}
