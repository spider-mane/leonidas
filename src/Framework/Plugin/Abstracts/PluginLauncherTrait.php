<?php

namespace Leonidas\Framework\Plugin\Abstracts;

use Leonidas\Framework\Abstracts\ExtensionLauncherTrait;
use Leonidas\Framework\Exception\PluginInitiationException;
use Leonidas\Framework\Plugin\Plugin;
use RuntimeException;

trait PluginLauncherTrait
{
    use ExtensionLauncherTrait;

    public static function init(string $base): void
    {
        !self::isLoaded() ? self::load($base) : self::error(__METHOD__);
    }

    private static function load(string $base): void
    {
        define(static::headers(), Plugin::headers($base));

        self::$instance = new self(
            Plugin::path($base),
            Plugin::url($base),
        );

        self::$instance->bootstrap();
    }

    private static function error(string $method): PluginInitiationException
    {
        return new PluginInitiationException(
            self::$instance->extension->getName(),
            $method
        );
    }

    private static function headers(): string
    {
        throw new RuntimeException(static::class . ' must implement headers method');
    }
}
