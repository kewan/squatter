<?php

namespace Kewan\Squatter\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;
use Kewan\Squatter\Exceptions\TenantNotFoundException;

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
        $subdomainField = config('squatter.subdomain_field_name');
        URL::defaults([$subdomainField => preg_replace('/^([^\.]+).*/', '$1', $request->getHost())]);

        return $next($request);
    }
}
