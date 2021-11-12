<?php

namespace Kunlyly\PlasGate;

use Illuminate\Support\ServiceProvider;
use Kunlyly\PlasGate\Commands\PlasGateCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PlasGateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('plasgate.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'plasgate');

        // Register the main class to use with the facade
        $this->app->singleton('plasgate', function () {
            return new Plasgate;
        });
    }
}
