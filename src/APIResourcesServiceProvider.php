<?php

namespace Juampi92\APIResources;

use Illuminate\Support\ServiceProvider;

class APIResourcesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishables();
        }
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->singleton('apiresource', function () {
            return new APIResourceManager();
        });
    }

    /**
     * Registers the publishable config.
     */
    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__ . '/../publishable/config/api.php' => config_path('api.php'),
        ]);
    }
}
