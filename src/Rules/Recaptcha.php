<?php

namespace Support\ReCaptcha\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Maize\GoogleRecaptchaV3\Support\Config;

class Recaptcha implements ValidationRule
{
    public function __construct(
        private float $scoreThreshold
    ) {}

    /**
     * Esegue la logica di validazione.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => Config::getSecretKey(),
            'response' => $value,
        ])->json();

        if (! ($response['success'] ?? false)) {
            $fail(__('ReCAPTCHA verification failed.'));
        }

        if (($response['score'] ?? 0.0) < $this->scoreThreshold) {
            $fail(__('ReCAPTCHA verification failed.'));
        }
    }
}
