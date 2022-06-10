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
        $this->loader = new ExtensionLoader($path, $url);
    }

    private function bootstrap(): void
    {
        $this->launch()->loadExtension()->declareExtensionLoaded();
    }

    private function launch(): self
    {
        $this->loader->bootstrap();

        return $this;
    }

    private function loadExtension(): self
    {
        Leonidas::init($this->loader->getExtension());

        return $this;
    }

    private function declareExtensionLoaded(): void
    {
        do_action('leonidas_loaded');
    }

    public static function init(string $base): void
    {
        !isset(self::$instance)
            ? self::load($base)
            : self::$instance->loader->error();
    }

    private static function load(string $base): void
    {
        define('LEONIDAS_PLUGIN_HEADERS', Plugin::headers($base));

        self::$instance = new self(
            Plugin::path($base),
            Plugin::url($base),
        );

        self::$instance->bootstrap();
    }
}
