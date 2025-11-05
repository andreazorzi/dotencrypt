<?php

namespace Dotencrypt;

use Dotencrypt\Commands\Encrypt;
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
                Encrypt::class
            ]);
    }
    
    public function boot()
    {
        parent::boot();
    }
}