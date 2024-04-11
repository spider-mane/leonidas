<?php

namespace Leonidas\Framework\Abstracts;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Exception\ExtensionInitiationException;
use RuntimeException;

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

    public static function instance(): static
    {
        return self::$instance ?? throw self::accessError(__METHOD__);
    }

    public static function init(WpExtensionInterface $base): void
    {
        !isset(self::$instance)
            ? self::load($base)
            : throw self::initError(__METHOD__);
    }

    private static function load(WpExtensionInterface $base): void
    {
        self::$instance = new self($base);
    }

    private static function initError(string $method): ExtensionInitiationException
    {
        return new ExtensionInitiationException(self::$instance->base, $method);
    }

    private static function accessError(string $method): RuntimeException
    {
        return new RuntimeException(
            "Invalid call to {$method}. Instance has not been initiated."
        );
    }
}
