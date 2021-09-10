<?php

return [

    'paypal' => [

        'url' => env('PAYPAL_URL', null),

    ],

    'mipay' => [

        'url' => env('MIPAY_URL', null),

        'redis_key_prefix' => 'mipay_'
    ],

];
