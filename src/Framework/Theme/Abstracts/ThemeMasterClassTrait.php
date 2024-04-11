<?php

namespace Leonidas\Framework\Theme\Abstracts;

use Leonidas\Framework\Abstracts\ExtensionMasterClassTrait;
use Leonidas\Framework\Exception\ThemeInitiationException;

trait ThemeMasterClassTrait
{
    use ExtensionMasterClassTrait;

    private static function initError(string $method): ThemeInitiationException
    {
        return new ThemeInitiationException(self::$instance->base, $method);
    }
}
