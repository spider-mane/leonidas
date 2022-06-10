<?php

namespace Leonidas\Plugin;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Exception\PluginInitiationException;

final class Leonidas
{
    protected WpExtensionInterface $base;

    private static self $instance;

    private function __construct(WpExtensionInterface $base)
    {
        $this->base = $base;
    }

    public static function init(WpExtensionInterface $base): void
    {
        if (!isset(self::$instance)) {
            self::create($base);
        } else {
            self::throwInvalidCallException(__METHOD__);
        }
    }

    private static function create(WpExtensionInterface $base): void
    {
        self::$instance = new self($base);
    }

    private static function throwInvalidCallException(string $method): void
    {
        throw new PluginInitiationException(
            self::$instance->base->getName(),
            $method
        );
    }
}
