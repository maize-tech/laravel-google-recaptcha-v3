<?php

use Maize\GoogleRecaptchaV3\Support\Config;

it('returns base js script url with render parameter', function () {
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');

    $url = Config::getBaseJsScriptUrl();

    expect($url->value())
        ->toBe('https://www.google.com/recaptcha/api.js?render=test-site-key');
});

it('returns true when recaptcha is enabled with valid keys', function () {
    config()->set('google-recaptcha-v3.enabled', true);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeTrue();
});

it('returns false when recaptcha is explicitly disabled', function () {
    config()->set('google-recaptcha-v3.enabled', false);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeFalse();
});

it('returns false when enabled is null', function () {
    config()->set('google-recaptcha-v3.enabled', null);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeFalse();
});

it('returns false when site key is missing', function () {
    config()->set('google-recaptcha-v3.enabled', true);
    config()->set('google-recaptcha-v3.site_key', null);
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeFalse();
});

it('returns false when site key is empty string', function () {
    config()->set('google-recaptcha-v3.enabled', true);
    config()->set('google-recaptcha-v3.site_key', '');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeFalse();
});

it('returns false when secret key is missing', function () {
    config()->set('google-recaptcha-v3.enabled', true);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', null);

    expect(Config::isEnabled())->toBeFalse();
});

it('returns false when secret key is empty string', function () {
    config()->set('google-recaptcha-v3.enabled', true);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', '');

    expect(Config::isEnabled())->toBeFalse();
});

it('returns site key when configured', function () {
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');

    expect(Config::getSiteKey())->toBe('test-site-key');
});

it('returns null when site key is not configured', function () {
    config()->set('google-recaptcha-v3.site_key', null);

    expect(Config::getSiteKey())->toBeNull();
});

it('returns null when site key is empty string', function () {
    config()->set('google-recaptcha-v3.site_key', '');

    expect(Config::getSiteKey())->toBeNull();
});

it('returns secret key when configured', function () {
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::getSecretKey())->toBe('test-secret-key');
});

it('returns null when secret key is not configured', function () {
    config()->set('google-recaptcha-v3.secret_key', null);

    expect(Config::getSecretKey())->toBeNull();
});

it('returns null when secret key is empty string', function () {
    config()->set('google-recaptcha-v3.secret_key', '');

    expect(Config::getSecretKey())->toBeNull();
});

it('returns score threshold from config', function () {
    config()->set('google-recaptcha-v3.score_threshold', 0.7);

    expect(Config::getScoreThreshold())->toBe(0.7);
});

it('returns default score threshold when not configured', function () {
    config()->set('google-recaptcha-v3.score_threshold', null);

    expect(Config::getScoreThreshold())->toBe(0.5);
});

it('returns default score threshold when empty string', function () {
    config()->set('google-recaptcha-v3.score_threshold', '');

    expect(Config::getScoreThreshold())->toBe(0.5);
});

it('converts string score threshold to float', function () {
    config()->set('google-recaptcha-v3.score_threshold', '0.8');

    expect(Config::getScoreThreshold())->toBe(0.8);
});

it('returns score threshold of 1.0', function () {
    config()->set('google-recaptcha-v3.score_threshold', 1.0);

    expect(Config::getScoreThreshold())->toBe(1.0);
});

it('returns score threshold of 0.0', function () {
    config()->set('google-recaptcha-v3.score_threshold', 0.0);

    expect(Config::getScoreThreshold())->toBe(0.0);
});

it('handles enabled config as string value', function () {
    config()->set('google-recaptcha-v3.enabled', '1');
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeTrue();
});

it('handles enabled config as empty string', function () {
    config()->set('google-recaptcha-v3.enabled', '');
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeFalse();
});

it('handles enabled config as integer 1', function () {
    config()->set('google-recaptcha-v3.enabled', 1);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeTrue();
});

it('handles enabled config as integer 0', function () {
    config()->set('google-recaptcha-v3.enabled', 0);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeFalse();
});

it('handles enabled config as boolean true', function () {
    config()->set('google-recaptcha-v3.enabled', true);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeTrue();
});

it('handles enabled config as boolean false', function () {
    config()->set('google-recaptcha-v3.enabled', false);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeFalse();
});

it('handles enabled config as string true', function () {
    config()->set('google-recaptcha-v3.enabled', 'true');
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeTrue();
});

it('handles enabled config as string false', function () {
    config()->set('google-recaptcha-v3.enabled', 'false');
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

    expect(Config::isEnabled())->toBeFalse();
});
