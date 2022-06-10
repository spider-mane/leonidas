<?php

namespace Leonidas\Framework\Abstracts;

use Leonidas\Framework\Exception\ThemeInitiationException;

trait ThemeLauncherTrait
{
    use ExtensionLauncherTrait;

    public static function init(string $path, string $url): void
    {
        if (!self::isLoaded()) {
            self::reallyInit($path, $url);
        } else {
            self::throwAlreadyLoadedException(__METHOD__);
        }
    }

    private static function reallyInit(string $path, string $url): void
    {
        self::$instance = new self($path, $url);
        self::$instance->bootstrap();
    }

    private static function throwAlreadyLoadedException(callable $method): void
    {
        throw new ThemeInitiationException(
            self::$instance->extension->getName(),
            $method
        );
    }
}
