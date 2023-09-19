<?php

namespace Firdavsi\Responses;

use Illuminate\Support\ServiceProvider;

class ResponsesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/responses.php', 'responses'
        );
    }

    public function boot()
    {
        $this->publish();
    }

    private function publish()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        if (!function_exists('config_path')) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/responses.php' => config_path('responses.php')
        ], 'responses-config');
    }
}