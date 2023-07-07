<?php

namespace Leonidas\Plugin;

use Leonidas\Contracts\Extension\ExtensionLoaderInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Plugin\PluginLoader;

final class Launcher
{
    private ExtensionLoaderInterface $loader;

    private WpExtensionInterface $extension;

    private static self $instance;

    private function __construct(string $base)
    {
        $this->loader = new PluginLoader($base);
        $this->extension = $this->loader->getExtension();
    }

    private function launch(): void
    {
        $this->initiate()->boot()->broadcast();
    }

    private function initiate(): self
    {
        Leonidas::init($this->extension);

        return $this;
    }

    private function boot(): self
    {
        $this->loader->bootstrap();

        return $this;
    }

    private function broadcast(): void
    {
        /**
         * @hook
         *
         * Leonidas is fully bootstrapped. Dependent plugins may safely initiate
         * their own bootstrapping at this point.
         */
        $this->extension->doAction('loaded');
    }

    public static function init(string $base): void
    {
        !isset(self::$instance)
            ? self::load($base)
            : self::$instance->loader->error();
    }

    private static function load(string $base): void
    {
        (self::$instance = new self($base))->launch();
    }
}
