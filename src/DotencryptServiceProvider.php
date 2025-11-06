<?php

namespace Dotencrypt;

use Dotencrypt\Commands\Decrypt;
use Dotencrypt\Commands\Encrypt;
use Dotencrypt\Commands\CheckUpdates;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DotencryptServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('dotencrypt')
            ->hasCommands([
                Encrypt::class,
                Decrypt::class,
                CheckUpdates::class
            ]);
    }
    
    public function boot()
    {
        parent::boot();
    }
}