<?php

namespace Kewan\Squatter\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Kewan\Squatter\TenantManager;

class SquatterProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @param \Illuminate\Http\Request
     * @return void
     */
    public function boot(Request $request)
    {
        $this->publishes([
            __DIR__ . '/../../config/squatter.php' => config_path('squatter.php'),
        ]);

        $this->bootSquatter($request);
    }

    /**
     * Boot multitenant context.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function bootSquatter(Request $request)
    {
        // Leave if we are running in CLI mode
        if (php_sapi_name() === 'cli') {
            return;
        }

        $this->app->singleton('Squatter', function ($app) use ($request) {
            return new TenantManager($request->getHost(), config('squatter.class'), config('squatter.subdomain_field_name'));
        });
    }
}