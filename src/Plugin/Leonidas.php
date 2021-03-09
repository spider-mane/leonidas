<?php

namespace WebTheory\Leonidas\Plugin;

use League\Container\Container;
use Noodlehaus\Config;
use Noodlehaus\ConfigInterface;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;
use WebTheory\Leonidas\Admin\Loaders\AdminNoticeCollectionLoader;
use WebTheory\Leonidas\Contracts\Extension\WpExtensionInterface;
use WebTheory\Leonidas\Enum\ExtensionType;
use WebTheory\Leonidas\Framework\ModuleInitializer;
use WebTheory\Leonidas\Framework\WpExtension;
use WebTheory\Leonidas\Library\BaseObjectProxy;
use WebTheory\Leonidas\Plugin\Exceptions\LeonidasAlreadyLoadedException;

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
     * @var Container
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
        $this->path = $path;
        $this->base = $base;
        $this->uri = $uri;
        $this->container = $this->bootstrapContainer();
        $this->extension = $this->buildExtension();
    }

    private function bootstrapContainer(): ContainerInterface
    {
        /** @var Container $container */
        $container = require realpath($this->path . '/boot/container.php');
        $providers = $this->container->get('config')->get('app.providers', []);

        foreach ($providers as $provider) {
            $container->addServiceProvider($provider);
        }

        return $container;
    }

    private function buildExtension(): WpExtensionInterface
    {
        /** @var ConfigInterface $config */
        $config = $this->container->get('config');

        return WpExtension::create([
            'name' => $config->get('app.name'),
            'prefix' => $config->get('app.prefix'),
            'path' => $this->path,
            'base' => $this->base,
            'uri' => $this->uri,
            'assets' => $config->get('app.assets'),
            'dev' => $config->get('app.dev'),
            'type' => new ExtensionType($config->get('app.type')),
            'container' => $this->container
        ]);
    }

    private function reallyReallyInit(): Leonidas
    {
        $this
            ->bindContainerToBaseProxy()
            ->requireFiles()
            ->initializeModules()
            ->registerHookEmitter();

        return $this;
    }

    private function bindContainerToBaseProxy(): Leonidas
    {
        BaseObjectProxy::_setProxyContainer($this->container);

        return $this;
    }

    private function requireFiles(): Leonidas
    {
        require realpath($this->path . '/boot/files.php');

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

    private function registerHookEmitter(): Leonidas
    {
        do_action('leonidas.loaded');

        return $this;
    }

    private function registerSupportedExtension(ExtensionType $type, string $name): Leonidas
    {
        $this->supportedExtensions[$type->getValue()][] = $name;

        return $this;
    }

    /**
     *
     */
    public static function init(array $root): void
    {
        if (!self::isLoaded()) {
            self::reallyInit($root);
        }

        self::throwAlreadyLoadedException(__METHOD__);
    }

    private static function isLoaded(): bool
    {
        return isset(static::$instance);
    }

    private static function reallyInit(array $root): void
    {
        static::$instance = new self(
            $root['base'],
            $root['path'],
            $root['uri']
        );

        static::$instance->reallyReallyInit();
    }

    private static function throwAlreadyLoadedException(string $method): void
    {
        $message = "Leonidas should only be initiated internally. If you're seeing this Exception it's because the
            user, a plugin, or theme has made an illegitimate call to {$method}";

        throw new LeonidasAlreadyLoadedException($message);
    }

    public static function supportExtension(ExtensionType $type, string $name): void
    {
        static::$instance->registerSupportedExtension($type, $name);
    }

    public static function supportTheme(string $name): void
    {
        static::supportExtension(new ExtensionType('theme'), $name);
    }

    public static function supportPlugin(string $name): void
    {
        static::supportExtension(new ExtensionType('plugin'), $name);
    }

    public static function supportMuPlugin(string $name): void
    {
        static::supportExtension(new ExtensionType('mu-plugin'), $name);
    }

    public static function supportMixin(string $name): void
    {
        static::supportExtension(new ExtensionType('mixin'), $name);
    }
}
