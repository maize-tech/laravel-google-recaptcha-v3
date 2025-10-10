<?php

namespace Maize\GoogleRecaptchaV3\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Maize\GoogleRecaptchaV3\GoogleRecaptchaV3
 */
class GoogleRecaptchaV3 extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Maize\GoogleRecaptchaV3\GoogleRecaptchaV3::class;
    }
}
