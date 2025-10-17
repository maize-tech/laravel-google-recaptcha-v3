<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Enabled
    |--------------------------------------------------------------------------
    |
    | This option controls whether Google reCAPTCHA v3 is enabled.
    | When disabled, the validation will be skipped.
    |
    */
    'enabled' => null,

    /*
    |--------------------------------------------------------------------------
    | Site Key
    |--------------------------------------------------------------------------
    |
    | Your Google reCAPTCHA v3 site key.
    | You can get this from https://www.google.com/recaptcha/admin
    |
    */
    'site_key' => null,

    /*
    |--------------------------------------------------------------------------
    | Secret Key
    |--------------------------------------------------------------------------
    |
    | Your Google reCAPTCHA v3 secret key.
    | You can get this from https://www.google.com/recaptcha/admin
    |
    */
    'secret_key' => null,

    /*
    |--------------------------------------------------------------------------
    | Score Threshold
    |--------------------------------------------------------------------------
    |
    | The minimum score threshold for the reCAPTCHA validation.
    | Google reCAPTCHA v3 returns a score (1.0 is very likely a good interaction,
    | 0.0 is very likely a bot). Default is 0.5.
    |
    */
    'score_threshold' => null,

    /*
    |--------------------------------------------------------------------------
    | Badge
    |--------------------------------------------------------------------------
    |
    | The default badge position for the reCAPTCHA badge.
    | Available options: 'bottomright', 'bottomleft', 'inline', 'hidden'.
    | Default is 'bottomright'.
    |
    */
    'badge' => null,
];
