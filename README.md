# Laravel Force Https

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yaroslawww/laravel-force-https.svg?style=flat-square)](https://packagist.org/packages/yaroslawww/laravel-force-https)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](README.md)
[![Total Downloads](https://img.shields.io/packagist/dt/yaroslawww/laravel-force-https.svg?style=flat-square)](https://packagist.org/packages/yaroslawww/laravel-force-https)

An easy redirect to https for Laravel


## Table of Contents

- <a href="#installation">Installation</a>
    - <a href="#composer">Composer</a>
- <a href="#usage">Usage</a>
    - <a href="#middleware">Middleware</a>
- <a href="#config">Config</a>
    - <a href="#config-files">Config files</a>
    - <a href="#service-providers">Service providers</a>
- <a href="#changelog">Changelog</a>
- <a href="#license">License</a>

## Compatibility

For use php < 7.4 please use verssion "^1.0"

## Installation

### Composer

    composer require yaroslawww/laravel-force-https
    
## Usage

### Middleware

Moreover, this package includes a middleware object to redirect all "non-ssl" routes to the corresponding "ssl".

So, if a user navigates to http://url-to-laravel/test and the system has this middleware active it would redirect (301) him automatically to https://url-to-laravel/test. This is mainly used to avoid duplicate content and improve SEO performance.

To do so, you have to register the middleware in the `app/Http/Kernel.php` file like this:

```php
    //app/Http/Kernel.php
	
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        /**** OTHER MIDDLEWARE ****/
        'laravelForceHttps' => \Angecode\LaravelForceHttps\Middleware\LaravelForceHttpsMiddlewareRedirect::class,
        // REDIRECTION MIDDLEWARE
    ];

```


```php
	// /routes/web.php

	Route::middleware('laravelForceHttps')
        ->group(function() {
            /** ADD ALL SECURE ROUTES INSIDE THIS GROUP **/
            Route::get('/', function()
            {
                //
            });
    
            Route::get('test',function()
            {
                //
            });
        });

	/** OTHER PAGES THAT SHOULD NOT BE SECURE **/

```

## Config

### Config Files

In order to edit the default configuration for this package you may execute:

```sh
php artisan vendor:publish --provider="Angecode\LaravelForceHttps\LaravelForceHttpsServiceProvider"
```

After that, `config/laravelforcehttps.php` will be created. Inside this file you will find all the fields that can be edited in this package.


Since you will typically need to overwrite the assets every time the package is updated, you may use the --force flag:
```sh

php artisan vendor:publish --provider="Angecode\LaravelForceHttps\LaravelForceHttpsServiceProvider" --force

```

## Laravel force https Amazon support 
If you find yourself behind some sort of proxy - like a load balancer - then certain header information may be sent to you using special X-Forwarded-* headers or the Forwarded header. For example, the Host HTTP header is usually used to return the requested host. But when you're behind a proxy, the actual host may be stored in an X-Forwarded-Host header.

Since HTTP headers can be spoofed, Laravel does not trust these proxy headers by default. If you are behind a proxy, you should manually whitelist your proxy as like follows:

```php
// config/laravelforcehttps.php

//...
'set_trusted_proxies' => [
    'use_self_client_ip' => true,
    'ips' => [
        '192.0.0.1',
        '10.0.0.0/8',
    ]
],
//...
```

## Changelog
View changelog here -> [changelog](CHANGELOG.md)

## License

Laravel Force Https is an open-sourced laravel package licensed under the MIT license
