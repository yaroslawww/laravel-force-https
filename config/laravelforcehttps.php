<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Force redirect to secure route
    |--------------------------------------------------------------------------
    |
    | If true, all routes which use middleware
    | 'Angecode\LaravelForceHttps\Middleware\LaravelForceHttpsMiddlewareRedirect'
    | will be redirected to https
    |
    */
    'always_force_https' => false,

    /*
    |--------------------------------------------------------------------------
    | Force redirect to secure route depending on chosen environment 'APP_ENV'
    |--------------------------------------------------------------------------
    |
    | It redirects only if current environment is in the array
    |
    */
    'https_if_env_equal' => ['sandbox', 'production'],

    /*
    |--------------------------------------------------------------------------
    | Force redirect to secure route with query or not
    |--------------------------------------------------------------------------
    |
    | You can clear the request during a redirect
    |
    */
    'with_query' => [
        'get' => true
    ],

    /*
    |--------------------------------------------------------------------------
    | Whitelist your proxy
    |--------------------------------------------------------------------------
    |
    | Since HTTP headers can be spoofed, Laravel does not trust these proxy
    | headers by default. If you are behind a proxy, you should manually whitelist
    | your proxy as follows
    |
    */
    'set_trusted_proxies' => [
        'use_self_client_ip' => false,
        'ips' => [
            //'192.0.0.1',
            //'10.0.0.0/8',
        ]
    ]
];