<?php

namespace Juampi92\APIResources;

use Illuminate\Support\ServiceProvider;

class APIResourcesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishables();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('apiresource', function ($app) {
            return new APIResourceManager();
        });
    }

    /**
     * Registers the publishable config
     *
     * @return void
     */
    protected function registerPublishables()
    {
        $this->publishes([
            __DIR__ . '/../publishable/config/api.php' => config_path('api.php'),
        ]);
    }
}
