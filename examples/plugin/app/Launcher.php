<?php

namespace Example\Plugin;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Exception\PluginInitiationException;
use Leonidas\Framework\Plugin\PluginLoader;

final class Launcher
{
    private PluginLoader $loader;

    private WpExtensionInterface $extension;

    private static self $instance;

    private function __construct(string $base)
    {
        $this->loader = new PluginLoader($base);
        $this->extension = $this->loader->getExtension();
    }

    private function launch(): void
    {
        $this->initiate()->boot();
    }

    private function initiate(): self
    {
        Plugin::init($this->extension);

        return $this;
    }

    private function boot(): self
    {
        $this->loader->bootstrap();

        return $this;
    }

    public static function init(string $base): void
    {
        !isset(self::$instance)
            ? self::load($base)
            : self::error(__FUNCTION__);
    }

    private static function load(string $base): void
    {
        $init = fn () => (self::$instance = new self($base))->launch();

        did_action($hook = 'leonidas/loaded')
            ? $init()
            : add_action($hook, $init);
    }

    private static function error(string $method): void
    {
        throw new PluginInitiationException(
            self::$instance->extension,
            $method
        );
    }
}
