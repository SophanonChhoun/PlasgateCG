<?php

namespace Kunlyly\PlasGate;

use Kunlyly\PlasGate\Commands\PlasGateCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class PlasGateServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('lyly-cg-otp')
            ->hasViews()
            ->hasMigration('create_lyly-cg-otp_table')
            ->hasCommand(PlasGateCommand::class);
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'plasgate');
    }
}
