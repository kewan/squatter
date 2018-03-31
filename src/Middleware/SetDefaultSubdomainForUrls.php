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
        $subdomain = preg_replace('/^([^\.]+).*/', '$1', $request->getHost());

        if (!in_array($subdomain, config('squatter.reserved_subdomains'))) {
            $subdomainField = config('squatter.subdomain_field_name');
            URL::defaults([$subdomainField => squatter()->$subdomainField]);
        }

        return $next($request);
    }
}
