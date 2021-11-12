<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Events\ConnectionFailed;

class LogConnectionFailed
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
     * @param ConnectionFailed $event
     * @return void
     */
    public function handle(ConnectionFailed $event)
    {
        Log::critical(
            'Error during the HTTP connection',
            [
                'message' => $event->request->data(),
            ]
        );
    }
}
