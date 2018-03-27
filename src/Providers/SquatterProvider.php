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
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/../../config/squatter.php' => config_path('squatter.php'),
            ]);
        }

        $this->bootSquatter($request);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/squatter.php', 'squatter'
        );
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

        $this->app->singleton(TenantManager::class, function ($app) use ($request) {
            return new TenantManager($request->getHost(), config('squatter.class'), config('squatter.subdomain_field_name'));
        });
    }
}