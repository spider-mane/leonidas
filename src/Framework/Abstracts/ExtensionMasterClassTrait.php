<?php

namespace Leonidas\Framework\Abstracts;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Exception\PluginInitiationException;

trait ExtensionMasterClassTrait
{
    protected WpExtensionInterface $base;

    private static $instance;

    private function __construct(WpExtensionInterface $base)
    {
        $this->base = $base;
    }

    public static function init(WpExtensionInterface $base): void
    {
        !isset(self::$instance) ? self::load($base) : self::error(__METHOD__);
    }

    private static function load(WpExtensionInterface $base): void
    {
        self::$instance = new self($base);
    }

    private static function error(string $method): void
    {
        throw new PluginInitiationException(
            self::$instance->base->getName(),
            $method
        );
    }
}
