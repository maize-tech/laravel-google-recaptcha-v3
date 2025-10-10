<?php

namespace Maize\GoogleRecaptchaV3;

use Maize\GoogleRecaptchaV3\Commands\GoogleRecaptchaV3Command;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GoogleRecaptchaV3ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-google-recaptcha-v3')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_google_recaptcha_v3_table')
            ->hasCommand(GoogleRecaptchaV3Command::class);
    }
}
