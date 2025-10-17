<?php

namespace Maize\GoogleRecaptchaV3;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Uri;
use Illuminate\Validation\Rule;
use Maize\GoogleRecaptchaV3\Enums\Badge;
use Maize\GoogleRecaptchaV3\Rules\RecaptchaRule;
use Maize\GoogleRecaptchaV3\Support\Config;

class GoogleRecaptchaV3
{
    public function boot(): void
    {
        Blade::directive('recaptcha', fn (string $expression) => (
            "<?php echo app(\Maize\GoogleRecaptchaV3\GoogleRecaptchaV3::class)->renderHtml({$expression}); ?>"
        ));

        Rule::macro('googleRecaptchaV3', fn (?float $scoreThreshold = null) => (
            new RecaptchaRule($scoreThreshold)
        ));
    }

    private function getJsScriptUrl(Badge $badge): string
    {
        return Config::getBaseJsScriptUrl()
            ->when($badge !== Badge::HIDDEN, fn (Uri $url) => (
                $url->withQuery(['badge' => $badge->value])
            ))
            ->value();
    }

    private function getJsTokenScript(): string
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

    private function getHiddenBadgeStyle(): string
    {
        return <<<'CSS'
            .grecaptcha-badge {
                visibility: hidden;
            }
        CSS;
    }

    public function renderHtml(Badge $badge): string
    {
        if (! Config::isEnabled()) {
            return '';
        }

        $parts = [
            '<script src="'.$this->getJsScriptUrl($badge).'"></script>',
            str($this->getJsTokenScript())->wrap('<script>', '</script>'),
        ];

        return collect($parts)
            ->when($badge === Badge::HIDDEN, fn ($collection) => (
                $collection->push(str(
                    $this->getHiddenBadgeStyle()
                )->wrap('<style>', '</style>'))
            ))
            ->implode("\n\n");
    }
}
