<?php

namespace Maize\GoogleRecaptchaV3\Support;

use Illuminate\Support\Uri;
use Maize\GoogleRecaptchaV3\Enums\Badge;

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

        if ($enabled === 'false' || $enabled === '0') {
            $enabled = false;
        } else {
            $enabled = boolval($enabled);
        }

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

        return blank($key) ? null : $key;
    }

    public static function getSecretKey(): ?string
    {
        $key = config('google-recaptcha-v3.secret_key');

        return blank($key) ? null : $key;
    }

    public static function getScoreThreshold(): float
    {
        $threshold = config('google-recaptcha-v3.score_threshold');

        return blank($threshold) ? 0.5 : floatval($threshold);
    }

    public static function getBadge(): Badge
    {
        $badge = config('google-recaptcha-v3.badge');

        if ($badge instanceof Badge) {
            return $badge;
        }

        if (is_string($badge)) {
            return Badge::tryFrom($badge) ?? Badge::BOTTOMRIGHT;
        }

        return Badge::BOTTOMRIGHT;
    }
}
