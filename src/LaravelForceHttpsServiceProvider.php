<?php

namespace Angecode\LaravelForceHttps;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class LaravelForceHttpsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/laravelforcehttps.php' => config_path('laravelforcehttps.php'),
        ], 'config');

        if (config('laravelforcehttps.set_trusted_proxies.use_self_client_ip') || ! empty(config('laravelforcehttps.set_trusted_proxies.ips'))) {
            $proxies = [];
            if (! empty(config('laravelforcehttps.set_trusted_proxies.ips'))) {
                $proxies = array_merge(
                    $proxies,
                    config('laravelforcehttps.set_trusted_proxies.ips')
                );
            }
            if (config('laravelforcehttps.set_trusted_proxies.use_self_client_ip')
                && ! is_null(Request::getClientIp())
            ) {
                $proxies[] = Request::getClientIp();
            }
            Request::setTrustedProxies($proxies, \Symfony\Component\HttpFoundation\Request::getTrustedHeaderSet());
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravelforcehttps.php', 'laravelforcehttps');
    }
}
