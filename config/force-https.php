<?php

return [

    'conditions' => [
        /*
        |--------------------------------------------------------------------------
        | Force redirect to secure route
        |--------------------------------------------------------------------------
        |
        | If true, all routes which use middleware
        | will be redirected to https
        |
        */
        'always' => (bool) env('FORCE_HTTPS_ALWAYS', false),

        /*
        |--------------------------------------------------------------------------
        | Force redirect to secure route depending on chosen environment 'APP_ENV'
        |--------------------------------------------------------------------------
        |
        | It redirects only if current environment is in the array
        |
        */
        'envs'   => array_filter(array_map('trim', explode(',', env('FORCE_HTTPS_ENVS', 'sandbox,production')))),
    ],

    'redirect' => [
        'query'   => (bool) env('FORCE_HTTPS_REDIRECT_WITH_QUERY', true),
        'status'  => (int) env('FORCE_HTTPS_REDIRECT_STATUS', 302),
        'headers' => [],
    ],

];
