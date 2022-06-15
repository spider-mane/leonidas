<?php

namespace Leonidas\Framework\Abstracts;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Exception\ExtensionInitiationException;

trait ExtensionMasterClassTrait
{
    private WpExtensionInterface $base;

    private static self $instance;

    private function __construct(WpExtensionInterface $base)
    {
        $this->base = $base;
    }

    public function path(?string $file = null): string
    {
        return $this->base->relPath($file);
    }

    public function absPath(?string $file = null): string
    {
        return $this->base->absPath($file);
    }

    public function url(?string $route = null): string
    {
        return $this->base->url($route);
    }

    public function header(string $header): ?string
    {
        return $this->base->header($header);
    }

    public static function instance(): self
    {
        return static::$instance;
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
        throw new ExtensionInitiationException(self::$instance->base, $method);
    }
}
