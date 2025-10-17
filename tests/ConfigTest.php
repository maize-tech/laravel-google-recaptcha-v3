<?php

use Maize\GoogleRecaptchaV3\Enums\Badge;
use Maize\GoogleRecaptchaV3\Support\Config;

it('returns base js script url with render parameter', function () {
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');

    $url = Config::getBaseJsScriptUrl();

    expect($url->value())
        ->toBe('https://www.google.com/recaptcha/api.js?render=test-site-key');
});

it('handles enabled config values correctly', function (mixed $value, bool $expected) {
    config()->set('google-recaptcha-v3.enabled', $value);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBe($expected);
})->with([
    'boolean true' => [true, true],
    'boolean false' => [false, false],
    'string true' => ['true', true],
    'string false' => ['false', false],
    'string 1' => ['1', true],
    'string 0' => ['0', false],
    'integer 1' => [1, true],
    'integer 0' => [0, false],
    'null' => [null, false],
    'empty string' => ['', false],
]);

it('returns false when site key is missing', function (?string $siteKey) {
    config()->set('google-recaptcha-v3.enabled', true);
    config()->set('google-recaptcha-v3.site_key', $siteKey);
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeFalse();
})->with([
    'null' => [null],
    'empty string' => [''],
]);

it('returns false when secret key is missing', function (?string $secretKey) {
    config()->set('google-recaptcha-v3.enabled', true);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', $secretKey);

    expect(Config::isEnabled())->toBeFalse();
})->with([
    'null' => [null],
    'empty string' => [''],
]);

it('returns site key when configured', function () {
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');

    expect(Config::getSiteKey())->toBe('test-site-key');
});

it('returns null when site key is blank', function (?string $value) {
    config()->set('google-recaptcha-v3.site_key', $value);

    expect(Config::getSiteKey())->toBeNull();
})->with([
    'null' => [null],
    'empty string' => [''],
]);

it('returns secret key when configured', function () {
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::getSecretKey())->toBe('test-secret-key');
});

it('returns null when secret key is blank', function (?string $value) {
    config()->set('google-recaptcha-v3.secret_key', $value);

    expect(Config::getSecretKey())->toBeNull();
})->with([
    'null' => [null],
    'empty string' => [''],
]);

it('returns score threshold correctly', function (mixed $value, float $expected) {
    config()->set('google-recaptcha-v3.score_threshold', $value);

    expect(Config::getScoreThreshold())->toBe($expected);
})->with([
    'float 0.7' => [0.7, 0.7],
    'float 1.0' => [1.0, 1.0],
    'float 0.0' => [0.0, 0.0],
    'string 0.8' => ['0.8', 0.8],
    'null defaults to 0.5' => [null, 0.5],
    'empty string defaults to 0.5' => ['', 0.5],
]);

it('returns badge correctly', function (mixed $value, Badge $expected) {
    config()->set('google-recaptcha-v3.badge', $value);

    expect(Config::getBadge())->toBe($expected);
})->with([
    'Badge enum BOTTOMRIGHT' => [Badge::BOTTOMRIGHT, Badge::BOTTOMRIGHT],
    'Badge enum BOTTOMLEFT' => [Badge::BOTTOMLEFT, Badge::BOTTOMLEFT],
    'Badge enum INLINE' => [Badge::INLINE, Badge::INLINE],
    'Badge enum HIDDEN' => [Badge::HIDDEN, Badge::HIDDEN],
    'string bottomright' => ['bottomright', Badge::BOTTOMRIGHT],
    'string bottomleft' => ['bottomleft', Badge::BOTTOMLEFT],
    'string inline' => ['inline', Badge::INLINE],
    'string hidden' => ['hidden', Badge::HIDDEN],
    'null defaults to BOTTOMRIGHT' => [null, Badge::BOTTOMRIGHT],
    'invalid string defaults to BOTTOMRIGHT' => ['invalid', Badge::BOTTOMRIGHT],
]);
