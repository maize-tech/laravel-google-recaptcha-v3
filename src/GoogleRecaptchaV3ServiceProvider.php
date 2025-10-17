<?php

namespace Maize\GoogleRecaptchaV3;

use Maize\GoogleRecaptchaV3\Facades\GoogleRecaptchaV3;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GoogleRecaptchaV3ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-google-recaptcha-v3')
            ->hasConfigFile()
            ->hasInstallCommand(fn (InstallCommand $command) => (
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('maize-tech/laravel-google-recaptcha-v3')
            ));
    }

    public function packageBooted(): void
    {
        GoogleRecaptchaV3::boot();
    }
}
