<?php

namespace App\Providers;

use App\Listeners\LogPaymentRequest;
use App\Listeners\LogPaymentResponse;
use Illuminate\Support\Facades\Event;
use App\Listeners\LogConnectionFailed;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Client\Events\ConnectionFailed;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RequestSending::class => [
            LogPaymentRequest::class,
        ],
        ResponseReceived::class => [
            LogPaymentResponse::class,
        ],
        ConnectionFailed::class => [
            LogConnectionFailed::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
