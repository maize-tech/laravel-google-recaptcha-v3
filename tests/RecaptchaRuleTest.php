<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

it('can validate token', function (bool $enabled, ?bool $success, ?float $score, ?float $threshold, bool $fails) {
    config()->set('google-recaptcha-v3.enabled', $enabled);
    config()->set('google-recaptcha-v3.site_key', 'test-site-key');
    config()->set('google-recaptcha-v3.secret_key', 'test-secret-key');

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

    $validator = validator(
        ['token' => 'value'],
        ['token' => Rule::googleRecaptchaV3($threshold)]
    );

    expect($validator->fails())->toBe($fails);
})->with([
    'missing success field fails' => [true, null, null, 0.5, true],
    'missing success with score fails' => [true, null, 0.0, 0.5, true],
    'success without score fails' => [true, true, null, 0.5, true],
    'success with zero score fails' => [true, true, 0.0, 0.5, true],
    'score below threshold fails' => [true, true, 0.4, 0.5, true],
    'score equal to threshold passes' => [true, true, 0.5, 0.5, false],
    'score above threshold passes' => [true, true, 1.0, 0.5, false],
    'disabled recaptcha always passes' => [false, null, null, 0.5, false],
    'default threshold 0.5 with low score fails' => [true, true, 0.4, null, true],
    'default threshold 0.5 with high score passes' => [true, true, 0.9, null, false],
    'custom threshold 1.0 with low score fails' => [true, true, 0.4, 1.0, true],
    'custom threshold 1.0 with perfect score passes' => [true, true, 1.0, 1.0, false],
]);
