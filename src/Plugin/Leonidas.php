<?php

namespace Leonidas\Plugin;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Exception\InvalidCallToPluginMethodException;

final class Leonidas
{
    protected WpExtensionInterface $base;

    private static self $instance;

    private function __construct(WpExtensionInterface $base)
    {
        $this->base = $base;
    }

    public static function launch(WpExtensionInterface $base): void
    {
        if (!self::isLoaded()) {
            self::create($base);
        } else {
            self::throwInvalidCallException(__METHOD__);
        }
    }

    private static function isLoaded(): bool
    {
        return isset(self::$instance) && (self::$instance instanceof self);
    }

    private static function create(WpExtensionInterface $base): void
    {
        self::$instance = new self($base);
    }

    private static function throwInvalidCallException(callable $method): void
    {
        throw new InvalidCallToPluginMethodException(
            self::$instance->base->getName(),
            $method
        );
    }
}
