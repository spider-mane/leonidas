<?php

namespace Leonidas\Library\Core\Localization;

use Leonidas\Contracts\Localization\LocalizerInterface;

class Localizer implements LocalizerInterface
{
    protected $textdomain;

    public function __construct(string $textdomain)
    {
        $this->textdomain = $textdomain;
    }

    public function translate(string $text): string
    {
        return __($text, $this->textdomain);
    }

    public function pluralize(string $single, string $plural, int $count): string
    {
        return _n($single, $plural, $count, $this->textdomain);
    }
}
