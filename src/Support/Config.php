<?php

namespace Maize\GoogleRecaptchaV3\Support;

use Illuminate\Support\Uri;

class Config
{
    public static function getBaseJsScriptUrl(): Uri
    {
        return Uri::of('https://www.google.com/recaptcha/api.js')->withQuery([
            'render' => Config::getSiteKey(),
        ]);
    }

    public static function isEnabled(): bool
    {
        $enabled = config('google-recaptcha-v3.enabled') ?? null;
        $enabled = boolval($enabled);

        if (! $enabled) {
            return false;
        }

        return ! in_array(null, [
            static::getSiteKey(),
            static::getSecretKey(),
        ]);
    }

    public static function getSiteKey(): ?string
    {
        $key = config('google-recaptcha-v3.site_key');

        return empty($key) ? null : $key;
    }

    public static function getSecretKey(): ?string
    {
        $key = config('google-recaptcha-v3.secret_key');

        return empty($key) ? null : $key;
    }
}
