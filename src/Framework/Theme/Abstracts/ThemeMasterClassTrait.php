<?php

namespace Leonidas\Framework\Theme\Abstracts;

use Leonidas\Framework\Abstracts\ExtensionMasterClassTrait;
use Leonidas\Framework\Exception\ThemeInitiationException;

trait ThemeMasterClassTrait
{
    use ExtensionMasterClassTrait;

    private static function error(string $method): void
    {
        throw new ThemeInitiationException(self::$instance->base, $method);
    }
}
