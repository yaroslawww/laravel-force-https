# Laravel Force Https

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yaroslawww/laravel-force-https.svg?style=flat-square)](https://packagist.org/packages/yaroslawww/laravel-force-https)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](README.md)
[![Total Downloads](https://img.shields.io/packagist/dt/yaroslawww/laravel-force-https.svg?style=flat-square)](https://packagist.org/packages/yaroslawww/laravel-force-https)
[![Build Status](https://scrutinizer-ci.com/g/yaroslawww/laravel-force-https/badges/build.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/laravel-force-https/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/yaroslawww/laravel-force-https/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/laravel-force-https/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yaroslawww/laravel-force-https/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yaroslawww/laravel-force-https/?branch=master)

An easy redirect to https for Laravel.

## Redirects using server config

The fastest and easiest way to do a redirect is to configure the server to redirect requests itself (an example is shown
below). But in some situations you may not have access to the configuration, or you need to do additional checks using
PHP. Then this package comes in handy.

### Redirect using apache2

Add to **`.htaccess`**

```apacheconf
RewriteEngine On
RewriteCond %{HTTPS} !=on
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301,NE]
Header always set Content-Security-Policy "upgrade-insecure-requests;"
```

### Redirect using nginx

You need to migrate configurations from port 80 to 443 and then add redirect from port 80 to port 443

```
server {
    listen 443 ssl http2;
    server_name my-domain.example www.my-domain.example;

    # ... configuration
}
server {
    listen 80;
    server_name my-domain.example www.my-domain.example;
    return 301 https://my-domain.example$request_uri;
}
```

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

For use php < 8.0 please use version "^2.0"

## Installation

```shell
composer require yaroslawww/laravel-force-https
```

## Usage

### Middleware

Moreover, this package includes a middleware object to redirect all "non-ssl" routes to the corresponding "ssl".

So, if a user navigates to http://url-to-laravel/test and the system has this middleware active it would redirect (301)
him automatically to https://url-to-laravel/test. This is mainly used to avoid duplicate content and improve SEO
performance.

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
        'https' => \ForceHttps\Middleware\RedirectToHttps::class,
        // REDIRECTION MIDDLEWARE
    ];

```

```php
	// /routes/web.php

	Route::middleware('https')
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
php artisan vendor:publish --provider="ForceHttps\ServiceProvider"
```

After that, `config/force-https.php` will be created. Inside this file you will find all the fields that can be
edited in this package.

Since you will typically need to overwrite the assets every time the package is updated, you may use the --force flag:

```sh

php artisan vendor:publish --provider="ForceHttps\ServiceProvider" --force

```

## Changelog

View changelog here -> [changelog](CHANGELOG.md)

## License

## Credits

- [![Lemeor](https://yaroslawww.github.io/images/sponsors/packages/logo-lemeor.png)](https://lemeor.com/) 
- [![Think Studio](https://yaroslawww.github.io/images/sponsors/packages/logo-think-studio.png)](https://think.studio/) 
