<?php

if (!function_exists('squatter')) {
    function squatter()
    {
        return \Kewan\Squatter\Facades\Squatter::tenant();
    }
}

if (!function_exists('tenanted_route') && function_exists('route')) {

    function tenanted_route($name, $parameters = [], $absolute = true)
    {
        $subdomain = config('squatter.subdomain_field_name');
        $parameters = array_merge(['subdomain' => squatter()->$subdomain], $parameters);

        return route($name, $parameters, $absolute);
    }
}