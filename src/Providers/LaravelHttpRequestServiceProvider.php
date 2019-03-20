<?php

namespace Submtd\LaravelHttpRequest\Providers;

use Illuminate\Support\ServiceProvider;
use Submtd\LaravelHttpRequest\LaravelHttpRequest;

class LaravelHttpRequestServiceProvider extends ServiceProvider
{
    /**
     * register method
     */
    public function register()
    {
        // bind LaravelHttpRequest class to the service container
        $this->app->bind('http', function () {
            return new LaravelHttpRequest();
        });
    }

    public function boot()
    {
        // config
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-http-request.php', 'laravel-http-request');
        $this->publishes([__DIR__ . '/../../config' => config_path()], 'config');
    }
}
