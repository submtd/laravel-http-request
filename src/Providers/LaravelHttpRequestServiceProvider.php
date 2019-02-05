<?php

namespace Submtd\LaravelHttpRequest\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelHttpRequestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // config
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-http-request.php', 'laravel-http-request');
        $this->publishes([__DIR__ . '/../../config' => config_path()], 'config');
    }
}
