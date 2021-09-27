<?php

namespace ForceHttps\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToHttps
{
    public function handle(Request $request, Closure $next)
    {
        if (
            !$request->isSecure()
            && (
                config('force-https.conditions.always')
                || app()->environment(config('force-https.conditions.envs'))
            )
        ) {
            $path = $request->path();
            if (config('force-https.redirect.query', false)) {
                // Also affect merged data
                $path .= '?' . http_build_query($request->query->all());
            }

            return redirect()->secure(
                $path,
                config('force-https.redirect.status', false),
                config('force-https.redirect.headers', []),
            );
        }

        return $next($request);
    }
}
