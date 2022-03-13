<?php

namespace Leonidas\Plugin;

use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Enum\Extension\ExtensionType;
use Leonidas\Framework\Exceptions\InvalidCallToPluginMethodException;
use Leonidas\Framework\ModuleInitializer;
use Leonidas\Framework\Plugin\Plugin;
use Leonidas\Framework\WpExtension;
use Leonidas\Library\Core\Facades\_Facade;
use Panamax\Contracts\ContainerAdapterInterface;
use Panamax\Contracts\ProviderContainerInterface;
use Panamax\Contracts\ServiceContainerInterface;
use Panamax\Contracts\ServiceCreatorInterface;
use WebTheory\Config\Config;
use WebTheory\Config\Interfaces\ConfigInterface;

final class Launcher
{
    private string $path;

    private string $url;

    private Config $config;

    private ServiceContainerInterface $container;

    private WpExtension $extension;

    private static Launcher $instance;

    private function __construct(string $path, string $url)
    {
        $this->path = $path;
        $this->url = $url;
        $this->config = $this->defineConfig();
        $this->container = $this->defineContainer();
        $this->extension = $this->defineExtension();
    }

    protected function defineConfig(): ConfigInterface
    {
        return new Config($this->path . '/config');
    }

    private function defineContainer(): ServiceContainerInterface
    {
        return require $this->path . '/boot/container.php';
    }

    private function defineExtension(): WpExtensionInterface
    {
        $app = $this->config->get('app');

        if ($this->container instanceof ContainerAdapterInterface) {
            $container = $this->container->getAdaptedContainer();
        }

        return WpExtension::create([
            'name' => $app['name'],
            'version' => $app['version'],
            'slug' => $app['slug'],
            'prefix' => $app['prefix'],
            'description' => $app['description'],
            'path' => $this->path,
            'url' => $this->url,
            'dev' => $app['dev'],
            'type' => ExtensionType::from($app['type']),
            'container' => $container ?? $this->container,
        ]);
    }

    private function bootstrap(): void
    {
        $this
            ->buildServiceContainer()
            ->bindContainerToBaseFacade()
            ->initializeModules()
            ->initBootstrappers()
            ->launchLeonidas()
            ->registerLoadedHook();
    }

    private function buildServiceContainer(): self
    {
        $container = $this->container;

        $container->share('root', $this->path);
        $container->share('config', $this->config);

        if ($container instanceof ProviderContainerInterface) {
            foreach ($this->config->get('app.providers', []) as $provider) {
                $container->addServiceProvider(new $provider());
            }
        }

        if ($container instanceof ServiceCreatorInterface) {
            $container->createServices($this->config->get('app.services', []));
        }

        return $this;
    }

    private function bindContainerToBaseFacade(): self
    {
        _Facade::_setFacadeContainer($this->container);

        return $this;
    }

    private function initializeModules(): self
    {
        (new ModuleInitializer(
            $this->extension,
            $this->config->get('app.modules', [])
        ))->init();

        return $this;
    }

    private function initBootstrappers(): self
    {
        foreach ($this->config->get('app.bootstrap', []) as $bootstrapper) {
            (new $bootstrapper($this->extension))->bootstrap();
        }

        return $this;
    }

    private function launchLeonidas(): self
    {
        Leonidas::launch($this->extension);

        return $this;
    }

    private function registerLoadedHook(): void
    {
        do_action('leonidas_loaded');
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
            Plugin::path($base),
            Plugin::url($base),
        );

        static::$instance->bootstrap();
    }

    private static function throwInvalidCallException(callable $method): void
    {
        throw new InvalidCallToPluginMethodException(
            self::$instance->extension->getName(),
            $method
        );
    }
}
