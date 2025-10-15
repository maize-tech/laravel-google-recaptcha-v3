<?php

namespace Maize\GoogleRecaptchaV3;

use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\Rule;
use Maize\GoogleRecaptchaV3\Enums\Badge;
use Maize\GoogleRecaptchaV3\Support\Config;

class GoogleRecaptchaV3
{
    public function boot(): void
    {
        Blade::directive('recaptcha', fn (Badge $badge) => (
            $this->toHtml($badge)
        ));

        Rule::macro('googleRecaptchaV3', fn () => null);
    }

    protected function getJsScriptUrl(Badge $badge): string
    {
        return Config::getBaseJsScriptUrl()
            ->withQuery(['badge' => $badge])
            ->value();
    }

    protected function getJsTokenScript(): string
    {
        $key = Config::getSiteKey();

        return <<<JS
            window.recaptcha = function (action = 'submit') {
                return new Promise((resolve, reject) => {
                    if (typeof grecaptcha.ready === 'undefined') {
                        return resolve(null);
                    }

                    if (typeof grecaptcha.ready === 'undefined') {
                        return resolve(null);
                    }

                    grecaptcha.ready(function() {
                        try {
                            grecaptcha.execute('{$key}', { action: action })
                                .then(token => resolve(token))
                                .catch(error => resolve(null));
                        } catch (error) {
                            resolve(null);
                        }
                    });
                });
            };
        JS;
    }

    protected function toHtml(Badge $badge): string
    {
        if (! Config::isEnabled()) {
            return '';
        }

        return implode("\n\n", [
            str($this->getJsScriptUrl($badge))->wrap('<script>', '</script>'),
            str($this->getJsTokenScript())->wrap('<script>', '</script>'),
            // TODO: add style
        ]);
    }

    public function FunctionName($value = '')
    {
        // Rule::macro('recaptcha', );
    }

    // <style>
    // .grecaptcha-badge {
    // bottom: 90px !important;
    // }
    // </style>
}
