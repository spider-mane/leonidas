<?php

namespace Leonidas\Plugin;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Enum\ExtensionType;
use Leonidas\Framework\Exceptions\PluginAlreadyLoadedException;
use Leonidas\Framework\ModuleInitializer;
use Leonidas\Framework\WpExtension;
use Leonidas\Library\Core\Proxies\BaseStaticObjectProxy;
use Leonidas\Plugin\Exceptions\LeonidasAlreadyLoadedException;
use Noodlehaus\ConfigInterface;
use Psr\Container\ContainerInterface;

final class Leonidas
{
    /**
     * @var string
     */
    protected $base;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var WpExtension
     */
    private $extension;

    /**
     * Array of extensions that depend on Leonidas for proper functioning
     *
     * @var string[]
     */
    private $supportedExtensions;

    /**
     * @var Leonidas
     */
    private static $instance;

    private function __construct(string $base, string $path, string $uri)
    {
        $this->base = $base;
        $this->path = $path;
        $this->uri = $uri;
        $this->container = $this->bootstrapContainer();
        $this->extension = $this->buildExtension();
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
        return require $this->path . '/boot/container.php';
    }

    private function buildExtension(): WpExtensionInterface
    {
        $config = [$this->container->get('config'), 'get'];

        return WpExtension::create([
            'name' => $config('plugin.name'),
            'prefix' => $config('plugin.prefix.short'),
            'description' => $config('plugin.description'),
            'base' => $this->base,
            'path' => $this->path,
            'uri' => $this->uri,
            'assets' => $config('plugin.assets'),
            'dev' => $config('plugin.dev'),
            'type' => new ExtensionType($config('plugin.type')),
            'container' => $this->container
        ]);
    }

    private function reallyReallyInit(): Leonidas
    {
        $this
            ->bindContainerToBaseProxy()
            ->requireFiles()
            ->initializeModules()
            ->registerHook();

        return $this;
    }

    private function bindContainerToBaseProxy(): Leonidas
    {
        BaseStaticObjectProxy::_setProxyContainer($this->container);

        return $this;
    }

    private function requireFiles(): Leonidas
    {
        return $this;
    }

    private function initializeModules(): Leonidas
    {
        (new ModuleInitializer($this->extension, $this->getModules()))->init();

        return $this;
    }

    private function getModules(): array
    {
        return require $this->extension->config('app.modules');
    }

    private function registerHook(): void
    {
        do_action('leonidas_loaded');
    }

    private function registerSupportedExtension(ExtensionType $type, string $name): Leonidas
    {
        $this->supportedExtensions[$type->getValue()][] = $name;

        return $this;
    }

    public static function init(string $base, string $path, string $uri): void
    {
        if (!self::isLoaded()) {
            self::reallyInit($base, $path, $uri);
        }

        self::throwAlreadyLoadedException(__METHOD__);
    }

    private static function isLoaded(): bool
    {
        return isset(self::$instance) && (self::$instance instanceof self);
    }

    private static function reallyInit(string $base, string $path, string $uri): void
    {
        self::$instance = (new self($base, $path, $uri))->reallyReallyInit();
    }

    private static function throwAlreadyLoadedException(callable $method): void
    {
        throw new PluginAlreadyLoadedException(
            self::$instance->getExtension()->getName(),
            $method
        );
    }

    public static function supportExtension(ExtensionType $type, string $name): void
    {
        self::$instance->registerSupportedExtension($type, $name);
    }

    public static function supportTheme(string $name): void
    {
        self::supportExtension(new ExtensionType('theme'), $name);
    }

    public static function supportPlugin(string $name): void
    {
        self::supportExtension(new ExtensionType('plugin'), $name);
    }

    public static function supportMuPlugin(string $name): void
    {
        self::supportExtension(new ExtensionType('mu-plugin'), $name);
    }

    public static function supportMixin(string $name): void
    {
        self::supportExtension(new ExtensionType('mixin'), $name);
    }
}
