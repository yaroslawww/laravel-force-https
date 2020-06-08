<?php

namespace Angecode\LaravelForceHttps\Middleware;

use Closure;
use Illuminate\Http\Request;

class LaravelForceHttpsMiddlewareRedirect
{
    public function handle(Request $request, Closure $next)
    {
        if (
            ! $this->isSecure($request)
            && (
                config('laravelforcehttps.always_force_https')
                || in_array(
                    env('APP_ENV'),
                    config('laravelforcehttps.https_if_env_equal'),
                    true
                )
            )
        ) {
            if ($request->getQueryString() && config('laravelforcehttps.with_query.get') && $request->isMethod('get')) {
                return redirect()->secure($request->path() . '?' . $request->getQueryString());
            }

            return redirect()->secure($request->path());
        }

        return $next($request);
    }


    /**
     * check whether x-forward-proto is provided by the reverse-proxy
     *
     * @param Request $request
     * @return bool
     */

    public function isSecure(Request $request): bool
    {
        return $request->headers->get('x-forwarded-proto') === 'https' ? true : $request->secure();
    }
}
