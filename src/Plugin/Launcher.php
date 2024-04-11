<?php

namespace Leonidas\Plugin;

use Leonidas\Contracts\Extension\ExtensionLoaderInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Exception\PluginInitiationException;
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
        $leonidas = $this->extension;

        /**
         * @hook
         *
         * Leonidas is fully bootstrapped. Dependent plugins may safely initiate
         * their own bootstrapping at this point.
         */
        $this->extension->doAction('loaded', $leonidas);
    }

    public static function init(string $base): void
    {
        !isset(self::$instance)
            ? self::load($base)
            : self::error(__FUNCTION__);
    }

    private static function load(string $base): void
    {
        (self::$instance = new self($base))->launch();
    }

    private static function error(string $method): void
    {
        throw new PluginInitiationException(
            self::$instance->extension,
            $method
        );
    }
}
