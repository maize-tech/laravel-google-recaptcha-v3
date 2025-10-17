<?php

use Maize\GoogleRecaptchaV3\Enums\Badge;
use Maize\GoogleRecaptchaV3\GoogleRecaptchaV3;

beforeEach(function () {
    config()->set('google-recaptcha-v3.enabled', true);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');
});

it('renders recaptcha HTML with badge parameter', function (Badge $badge, bool $shouldContainBadgeParam) {
    $recaptcha = new GoogleRecaptchaV3;

    $html = $recaptcha->renderHtml($badge);

    expect($html)
        ->toContain('https://www.google.com/recaptcha/api.js')
        ->toContain('render=test-site-key')
        ->toContain('window.recaptcha')
        ->toContain('grecaptcha.execute');

    if ($shouldContainBadgeParam) {
        expect($html)->toContain("badge={$badge->value}");
    } else {
        expect($html)->not->toContain('badge=');
    }
})->with([
    'bottomright badge' => [Badge::BOTTOMRIGHT, true],
    'bottomleft badge' => [Badge::BOTTOMLEFT, true],
    'inline badge' => [Badge::INLINE, true],
    'hidden badge should not have badge param' => [Badge::HIDDEN, false],
]);

it('renders hidden badge style for hidden badge', function () {
    $recaptcha = new GoogleRecaptchaV3;

    $html = $recaptcha->renderHtml(Badge::HIDDEN);

    expect($html)
        ->toContain('.grecaptcha-badge')
        ->toContain('visibility: hidden')
        ->toContain('<style>')
        ->toContain('</style>');
});

it('does not render hidden badge style for non-hidden badges', function (Badge $badge) {
    $recaptcha = new GoogleRecaptchaV3;

    $html = $recaptcha->renderHtml($badge);

    expect($html)
        ->not->toContain('.grecaptcha-badge')
        ->not->toContain('visibility: hidden');
})->with([
    Badge::BOTTOMRIGHT,
    Badge::BOTTOMLEFT,
    Badge::INLINE,
]);

it('returns empty string when recaptcha is disabled', function () {
    config()->set('google-recaptcha-v3.enabled', false);

    $recaptcha = new GoogleRecaptchaV3;
    $html = $recaptcha->renderHtml(Badge::BOTTOMRIGHT);

    expect($html)->toBe('');
});

it('returns empty string when site key is missing', function () {
    config()->set('google-recaptcha-v3.site_key', null);

    $recaptcha = new GoogleRecaptchaV3;
    $html = $recaptcha->renderHtml(Badge::BOTTOMRIGHT);

    expect($html)->toBe('');
});

it('returns empty string when secret key is missing', function () {
    config()->set('google-recaptcha-v3.secret_key', null);

    $recaptcha = new GoogleRecaptchaV3;
    $html = $recaptcha->renderHtml(Badge::BOTTOMRIGHT);

    expect($html)->toBe('');
});

it('includes window.recaptcha function in output', function () {
    $recaptcha = new GoogleRecaptchaV3;

    $html = $recaptcha->renderHtml(Badge::BOTTOMRIGHT);

    expect($html)
        ->toContain('window.recaptcha = function')
        ->toContain('action = \'submit\'')
        ->toContain('grecaptcha.ready')
        ->toContain('grecaptcha.execute');
});

it('includes site key in grecaptcha execute call', function () {
    $recaptcha = new GoogleRecaptchaV3;

    $html = $recaptcha->renderHtml(Badge::BOTTOMRIGHT);

    expect($html)->toContain("grecaptcha.execute('test-site-key'");
});

it('wraps scripts in script tags', function () {
    $recaptcha = new GoogleRecaptchaV3;

    $html = $recaptcha->renderHtml(Badge::BOTTOMRIGHT);

    expect($html)
        ->toMatch('/<script>.*?<\/script>/s')
        ->toContain('<script>')
        ->toContain('</script>');
});

it('generates correct js script url for each badge', function (Badge $badge, bool $shouldHaveBadgeQuery) {
    $recaptcha = new GoogleRecaptchaV3;

    $url = (fn () => $this->getJsScriptUrl($badge))->call($recaptcha);

    expect($url)
        ->toContain('https://www.google.com/recaptcha/api.js')
        ->toContain('render=test-site-key');

    if ($shouldHaveBadgeQuery) {
        expect($url)->toContain("badge={$badge->value}");
    } else {
        expect($url)->not->toContain('badge=');
    }
})->with([
    'bottomright has badge query' => [Badge::BOTTOMRIGHT, true],
    'bottomleft has badge query' => [Badge::BOTTOMLEFT, true],
    'inline has badge query' => [Badge::INLINE, true],
    'hidden does not have badge query' => [Badge::HIDDEN, false],
]);

it('generates js token script with site key', function () {
    $recaptcha = new GoogleRecaptchaV3;

    $script = (fn () => $this->getJsTokenScript())->call($recaptcha);

    expect($script)
        ->toContain('window.recaptcha = function')
        ->toContain("grecaptcha.execute('test-site-key'")
        ->toContain('action = \'submit\'')
        ->toContain('new Promise')
        ->toContain('grecaptcha.ready');
});

it('generates hidden badge style css', function () {
    $recaptcha = new GoogleRecaptchaV3;

    $style = (fn () => $this->getHiddenBadgeStyle())->call($recaptcha);

    expect($style)
        ->toContain('.grecaptcha-badge')
        ->toContain('visibility: hidden')
        ->not->toContain('<style>')
        ->not->toContain('</style>');
});
