<?php

namespace Maize\GoogleRecaptchaV3\Commands;

use Illuminate\Console\Command;

class GoogleRecaptchaV3Command extends Command
{
    public $signature = 'laravel-google-recaptcha-v3';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
