<?php

namespace Kewan\Squatter\Routing\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class Tenanted
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
        $tenant = squatter();

        $subdomainField = config('squatter.subdomain_field_name');

        URL::defaults([$subdomainField => $tenant->$subdomainField]);

        return $next($request);
    }
}
