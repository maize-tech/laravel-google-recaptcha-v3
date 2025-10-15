<?php

namespace Maize\GoogleRecaptchaV3\Tests;

use Maize\GoogleRecaptchaV3\GoogleRecaptchaV3ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            GoogleRecaptchaV3ServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
