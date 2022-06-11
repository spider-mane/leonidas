<?php

namespace Leonidas\Framework\Theme\Abstracts;

use Leonidas\Framework\Abstracts\ExtensionLauncherTrait;
use Leonidas\Framework\Exception\ThemeInitiationException;

trait ThemeLauncherTrait
{
    use ExtensionLauncherTrait;

    public static function init(string $path, string $url): void
    {
        !self::isLoaded() ? self::load($path, $url) : self::error(__METHOD__);
    }

    private static function load(string $path, string $url): void
    {
        self::$instance = new self($path, $url);
        self::$instance->bootstrap();
    }

    private static function error(string $method): void
    {
        throw new ThemeInitiationException(
            self::$instance->extension->getName(),
            $method
        );
    }
}
