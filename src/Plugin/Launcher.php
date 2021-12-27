<?php

namespace Leonidas\Plugin;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Enum\ExtensionType;
use Leonidas\Framework\Exceptions\InvalidCallToPluginMethodException;
use Leonidas\Framework\ModuleInitializer;
use Leonidas\Framework\Plugin\Plugin;
use Leonidas\Framework\WpExtension;
use Leonidas\Library\Core\Facades\_Facade;
use Psr\Container\ContainerInterface;

final class Launcher
{
    /**
     * @var string
     */
    private $base;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $url;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var WpExtension
     */
    private $extension;

    /**
     * @var Launcher
     */
    private static $instance;

    private function __construct(string $base, string $path, string $url)
    {
        $this->base = $base;
        $this->path = $path;
        $this->url = $url;
        $this->container = $this->bootstrapContainer();
        $this->extension = $this->bootstrapExtension();
    }

    /**
     * Get the value of extension
     *
     * @return WpExtension
     */
    private function getExtension(): WpExtension
    {
        return $this->extension;
    }

    private function bootstrapContainer(): ContainerInterface
    {
        return require $this->path . 'boot/container.php';
    }

    private function bootstrapExtension(): WpExtensionInterface
    {
        $config = [$this->container->get('config'), 'get'];

        return WpExtension::create([
            'name' => $config('plugin.name'),
            'version' => $config('plugin.version'),
            'slug' => $config('plugin.slug'),
            'prefix' => $config('plugin.prefix'),
            'description' => $config('plugin.description'),
            'path' => $this->path,
            'url' => $this->url,
            'dev' => $config('plugin.dev'),
            'type' => new ExtensionType($config('plugin.type')),
            'container' => $this->container,
        ]);
    }

    private function reallyReallyInit(): void
    {
        $this
            ->bindContainerToBaseProxy()
            ->requireFiles()
            ->initializeModules()
            ->getFurtherAssistance()
            ->bootLeonidas()
            ->registerLoadedHook();
    }

    private function bindContainerToBaseProxy(): Launcher
    {
        _Facade::_setFacadeContainer($this->container);

        return $this;
    }

    private function requireFiles(): Launcher
    {
        return $this;
    }

    private function initializeModules(): Launcher
    {
        (new ModuleInitializer($this->extension, $this->getModules()))->init();

        return $this;
    }

    private function getFurtherAssistance(): Launcher
    {
        foreach ($this->extension->config('app.bootstrap', []) as $assistant) {
            (new $assistant($this->extension))->bootstrap();
        }

        return $this;
    }

    private function bootLeonidas(): Launcher
    {
        Leonidas::launch($this->extension);

        return $this;
    }

    private function registerLoadedHook(): void
    {
        do_action('leonidas_loaded');
    }

    private function getModules(): array
    {
        return $this->extension->config('app.modules');
    }

    public static function init(string $base): void
    {
        if (!self::isLoaded()) {
            self::reallyInit($base);
        } else {
            self::throwInvalidCallException(__METHOD__);
        }
    }

    private static function isLoaded(): bool
    {
        return isset(self::$instance) && (self::$instance instanceof self);
    }

    private static function reallyInit(string $base): void
    {
        self::$instance = new self(
            Plugin::base($base),
            Plugin::path($base),
            Plugin::url($base),
        );

        static::$instance->reallyReallyInit();
    }

    private static function throwInvalidCallException(callable $method): void
    {
        throw new InvalidCallToPluginMethodException(
            self::$instance->getExtension()->getName(),
            $method
        );
    }
}
