<?php

namespace Mxgel\MPesa;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;


/**
 * Class ServiceProvider
 *
 * @package Mxgel\USSD
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . "/config/mpesa.php" => config_path('mpesa.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/config/mpesa.php", 'mpesa');
    }
}
