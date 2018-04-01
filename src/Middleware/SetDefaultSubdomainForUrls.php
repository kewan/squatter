<?php

namespace Kewan\Squatter\Middleware;

use Closure;

class SetDefaultSubdomainForUrls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->subdomain == null) {
            $request->subdomain = preg_replace('/^([^\.]+).*/', '$1', $request->getHost());
        }

        return $next($request);
    }
}
