<?php

namespace Leonidas\Plugin;

use Leonidas\Contracts\Extension\ExtensionLoaderInterface;
use Leonidas\Framework\ExtensionLoader;
use Leonidas\Framework\Plugin\Plugin;

final class Launcher
{
    private ExtensionLoaderInterface $loader;

    private static self $instance;

    private function __construct(string $path, string $url)
    {
        $this->loader = new ExtensionLoader('plugin', $path, $url);
    }

    private function launch(): void
    {
        $this->initiate()->boot()->broadcast();
    }

    private function initiate(): self
    {
        Leonidas::init($this->loader->getExtension());

        return $this;
    }

    private function boot(): self
    {
        $this->loader->bootstrap();

        return $this;
    }

    private function broadcast(): void
    {
        do_action('leonidas/loaded');
    }

    public static function init(string $base): void
    {
        !isset(self::$instance)
            ? self::load($base)
            : self::$instance->loader->error();
    }

    private static function load(string $base): void
    {
        self::$instance = new self(
            Plugin::path($base),
            Plugin::url($base),
        );

        self::$instance->launch();
    }
}
