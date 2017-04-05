<?php

namespace Angecode\LaravelForceHttps\Middleware;

use Closure;
use Illuminate\Http\Request;

class LaravelForceHttpsMiddlewareRedirect
{
    public function handle(Request $request, Closure $next)
    {
        if (
            !$request->secure()
            && (
                config('laravelforcehttps.always_force_https')
                || in_array(
                    env('APP_ENV'),
                    config('laravelforcehttps.https_if_env_equal'),
                    true
                )
            )
        ) {
            if (config('laravelforcehttps.with_query.get') && $request->isMethod('get')) {
                return redirect()->secure($request->path() . (($request->getQueryString())?('?' . $request->getQueryString()):''));
            }
            return redirect()->secure($request->path());
        }

        return $next($request);
    }

}