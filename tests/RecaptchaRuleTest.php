<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Maize\GoogleRecaptchaV3\Rules\Recaptcha;

it('can validate token', function (bool $enabled, ?bool $success, ?float $score, ?float $threshold, bool $fails) {

    config()->set('google-recaptcha-v3.enabled', $enabled);
    config()->set('google-recaptcha-v3.site_key', 'sitekey');
    config()->set('google-recaptcha-v3.secret_key', 'secretkey');

    $body = [];

    if (filled($success)) {
        $body['success'] = $success;
    }

    if (filled($score)) {
        $body['score'] = $score;
    }

    Http::fake([
        '*' => Http::response($body, 200),
    ]);

    Http::fake();

    $validator = validator(
        ['token' => 'value'],
        ['token' => Rule::googleRecaptchaV3($threshold)]
    );

    expect($validator->fails())->toBe($fails);
})->with([
    ['enabled' => true, 'success' => null, 'score' => null, 'threshold' => 0.5, 'fails' => true],
    ['enabled' => true, 'success' => null, 'score' => 0.0, 'threshold' => 0.5, 'fails' => true],
    ['enabled' => true, 'success' => true, 'score' => null, 'threshold' => 0.5, 'fails' => true],
    ['enabled' => true, 'success' => true, 'score' => 0.0, 'threshold' => 0.5, 'fails' => true],
    ['enabled' => true, 'success' => true, 'score' => 0.4, 'threshold' => 0.5, 'fails' => true],

    ['enabled' => true, 'success' => true, 'score' => 0.5, 'threshold' => 0.5, 'fails' => false],
    ['enabled' => true, 'success' => true, 'score' => 1.0, 'threshold' => 0.5, 'fails' => false],

    ['enabled' => false, 'success' => null, 'score' => null, 'threshold' => 0.5, 'fails' => false],

    ['enabled' => true, 'success' => true, 'score' => 0.4, 'threshold' => null, 'fails' => true],
    ['enabled' => true, 'success' => true, 'score' => 0.9, 'threshold' => null, 'fails' => false],

    ['enabled' => true, 'success' => true, 'score' => 0.4, 'threshold' => 1, 'fails' => true],
    ['enabled' => true, 'success' => true, 'score' => 1, 'threshold' => 1, 'fails' => false],
]);
