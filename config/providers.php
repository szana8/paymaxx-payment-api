<?php

return [

    /*
   |--------------------------------------------------------------------------
   | Paypal provider specific settings
   |--------------------------------------------------------------------------
   |
   */
    'paypal' => [

        'url' => env('PAYPAL_URL', null),

    ],

    /*
    |--------------------------------------------------------------------------
    | MiPay provider specific settings
    |--------------------------------------------------------------------------
    |
    */
    'mipay' => [

        /*
        |--------------------------------------------------------------------------
        | MiPay provider URL
        |--------------------------------------------------------------------------
        |
        | This URL is used to call the MiPay provider services. This is a base
        | URL, so you need to specify what service you want to call.
        */
        'url' => env('MIPAY_URL', null),

        /*
        |--------------------------------------------------------------------------
        | MiPay Redis key
        |--------------------------------------------------------------------------
        |
        | To store the authentication token use this redis key with the
        | name of the merchant or any other unique merchant related
        | data.
        */
        'redis_key' => 'mipay_%s_access_token',

        /*
        |--------------------------------------------------------------------------
        | Sign in to MiPay URL
        |--------------------------------------------------------------------------
        |
        | This URL is used for MiPay authentication. Use client id and secret
        | to login to the provider. If the login is success it returns with
        | a valid access token for the future calls and an expiry date.
        */
        'get_access_token' => env('MIPAY_URL', null) . '/GetAccessToken',

        /*
        |--------------------------------------------------------------------------
        | Create MiPay payment token URL
        |--------------------------------------------------------------------------
        |
        | Use this URL to create token for the future payments. It needs
        | auth token in the header. It returns back with a registration
        | form URL which contains the form for the card data.
        */
        'create_token_url' => env('MIPAY_URL', null) . '/CreatePaymentToken',

        /*
        |--------------------------------------------------------------------------
        | Fetch payment and token details URL
        |--------------------------------------------------------------------------
        |
        | Use this URL to get the details of a MiPay token or payment. Send
        | the MiPay ID of the token or payment, and it returns back the
        | status and many other information of it.
        */
        'fetch_details' => env('MIPAY_URL', null) . '/FetchPaymentDetails',

        /*
        |--------------------------------------------------------------------------
        | Start payment URL
        |--------------------------------------------------------------------------
        |
        | You can start a one off or tokenized payment with this URL. If
        | the payment is a one off one it will returns back with a form
        | URL with card information form.
        */
        'start_payment' => env('MIPAY_URL', null) . '/Payment',

        /*
        |--------------------------------------------------------------------------
        | Reversal payment URL
        |--------------------------------------------------------------------------
        |
        | You can start revert your payment if it has successes in
        | a specific time window.
        */
        'reversal_payment' => env('MIPAY_URL', null) . '/ReversalPayment',
    ],

];
