<?php

namespace Keepcloud\Laravel\Freshdesk;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class FreshdeskServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/freshdesk.php', 'freshdesk');

        $this->app->singleton('freshdesk', function (Application $app) {
            $config = $app->make('config')->get('freshdesk', []);

            return new Api(
                (string) ($config['api_key'] ?? ''),
                (string) ($config['domain'] ?? ''),
                (array) ($config['http'] ?? [])
            );
        });

        $this->app->alias('freshdesk', Api::class);
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/freshdesk.php' => config_path('freshdesk.php'),
            ], 'freshdesk-config');
        }
    }
}
