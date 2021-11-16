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

    'paydirekt' => [

        /*
        |--------------------------------------------------------------------------
        | Paydirekt provider URL
        |--------------------------------------------------------------------------
        |
        | This URL is used to call the Paydirekt provider services. This is a base
        | URL, so you need to specify what service you want to call.
        */
        'url' => env('PAYDIREKT_URL', null),

        /*
        |--------------------------------------------------------------------------
        | Paydirekt Redis key
        |--------------------------------------------------------------------------
        |
        | To store the authentication token use this redis key with the
        | name of the merchant or any other unique merchant related
        | data.
        */
        'redis_key' => 'paydirekt_%s_access_token',

        /*
        |--------------------------------------------------------------------------
        | Sign in to Paydirekt URL
        |--------------------------------------------------------------------------
        |
        | This URL is used for Paydirekt authentication. Use client id and secret
        | to login to the provider. If the login is success it returns with
        | a valid access token for the future calls and an expiry date.
        */
        'get_access_token' => env('PAYDIREKT_URL', null) . '/merchantintegration/v1/token/obtain',

        /*
        |--------------------------------------------------------------------------
        | Fetch payment and token details URL
        |--------------------------------------------------------------------------
        |
        | Use this URL to create or get a checkout from Paydirekt
        */
        'checkout' => env('PAYDIREKT_URL', null) . '/checkout/v1/checkouts',

        /*
        |--------------------------------------------------------------------------
        | Start payment URL
        |--------------------------------------------------------------------------
        |
        | Use this URL to capture a checkout or get a capture details
        */
        'capture' => env('PAYDIREKT_URL', null) . '/checkout/v1/checkouts/%s/captures',

        /*
        |--------------------------------------------------------------------------
        | Reversal payment URL
        |--------------------------------------------------------------------------
        |
        | You can start revert your payment if it has successes in
        | a specific time window.
        */
        'reversal_payment' => env('PAYDIREKT_URL', null) . '/ReversalPayment',
    ],

    'tikkie' => [

        /*
        |--------------------------------------------------------------------------
        | Tikkie provider URL
        |--------------------------------------------------------------------------
        |
        | This URL is used to call the Tikkie provider services. This is a base
        | URL, so you need to specify what service you want to call.
        */
        'url' => env('TIKKIE_URL', null),

        /*
        |--------------------------------------------------------------------------
        | Start payment URL
        |--------------------------------------------------------------------------
        |
        | You can start a one off or tokenized payment with this URL. If
        | the payment is a one off one it will returns back with a form
        | URL with card information form.
        */
        'start_payment' => env('TIKKIE_URL', null),

        /*
        |--------------------------------------------------------------------------
        | Refund payment URL
        |--------------------------------------------------------------------------
        |
        | Use this URL to refund a transaction amount.
        */
        'refund' => env('TIKKIE_URL', null) . '/%s/payments/%s/refunds',
    ],

    'twikey' => [

        /*
        |--------------------------------------------------------------------------
        | Twikey provider URL
        |--------------------------------------------------------------------------
        |
        | This URL is used to call the Twikey provider services. This is a base
        | URL, so you need to specify what service you want to call.
        */
        'url' => env('TWIKEY_URL', null),

        /*
        |--------------------------------------------------------------------------
        | Twikey Redis key
        |--------------------------------------------------------------------------
        |
        | To store the authentication token use this redis key with the
        | name of the merchant or any other unique merchant related
        | data.
        */
        'redis_key' => 'twikey_%s_access_token',

        /*
        |--------------------------------------------------------------------------
        | Sign in to Twikey URL
        |--------------------------------------------------------------------------
        |
        | This URL is used for Twikey authentication. Use just the apiToken for
        | the login to the provider. If the login is success it returns with
        | a valid access token for the future calls and an expiry date.
        */
        'get_access_token' => env('TWIKEY_URL', null) . '/creditor',

        /*
        |--------------------------------------------------------------------------
        | Create Twikey payment token URL
        |--------------------------------------------------------------------------
        |
        | Use this URL to create token for the future payments. It needs the
        | Authorization in the header. It returns back with a registration
        | form URL.
        */
        'create_token_url' => env('TWIKEY_URL', null) . '/creditor/sign',

        /*
        |--------------------------------------------------------------------------
        | Fetch payment and token details URL
        |--------------------------------------------------------------------------
        |
        | Use this URL to get the details of a Twikey token or payment. Send
        | the Twikey ID of the token or payment, and it returns back the
        | status and many other information of it.
        */
        'fetch_token_details' => env('TWIKEY_URL', null) . '/creditor/mandate/detail',

        /*
        |--------------------------------------------------------------------------
        | Fetch payment and token details URL
        |--------------------------------------------------------------------------
        |
        | Use this URL to get the details of a MiPay token or payment. Send
        | the MiPay ID of the token or payment, and it returns back the
        | status and many other information of it.
        */
        'cancel_token' => env('TWIKEY_URL', null) . '/creditor/mandate',

        /*
        |--------------------------------------------------------------------------
        | Start payment URL
        |--------------------------------------------------------------------------
        |
        | You can start a one off or tokenized payment with this URL. If
        | the payment is a one off one it will returns back with a form
        | URL with card information form.
        */
        'start_payment' => env('TWIKEY_URL', null) . '/creditor/transaction',

        /*
        |--------------------------------------------------------------------------
        | Fetch payment details URL (POST)
        |--------------------------------------------------------------------------
        |
        | Use this URL to get the details of a Twikey transaction. Send the
        | Mandate ID of the payment, and it returns back the status and
        | many other information of it.
        */
        'fetch_details' => env('TWIKEY_URL', null) . '/creditor/transaction/detail',

        /*
        |--------------------------------------------------------------------------
        | Refund payment URL (POST)
        |--------------------------------------------------------------------------
        |
        | Use this URL to refund a transaction amount.
        */
        'refund_payment' => env('TWIKEY_URL', null) . '/creditor/transaction/refund',

        /*
        |--------------------------------------------------------------------------
        | Reversal payment URL (DELETE)
        |--------------------------------------------------------------------------
        |
        | Use this URL to reverse a transaction amount.
        */
        'reversal_payment' => env('TWIKEY_URL', null) . '/creditor/transaction',
    ],
    'buckaroo' => [

        /*
        |--------------------------------------------------------------------------
        | Twikey provider URL
        |--------------------------------------------------------------------------
        |
        | This URL is used to call the Twikey provider services. This is a base
        | URL, so you need to specify what service you want to call.
        */
        'url' => env('BUCKAROO_URL', null),
    ],
];
