<?php

namespace Leonidas\Plugin;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Exception\InvalidCallToPluginMethodException;
use Leonidas\Framework\ModuleInitializer;
use Leonidas\Framework\Plugin\Plugin;
use Leonidas\Framework\WpExtension;
use Leonidas\Library\Core\Access\_Facade;
use Panamax\Contracts\BootableProviderContainerInterface;
use Panamax\Contracts\ContainerAdapterInterface;
use Panamax\Contracts\ProviderContainerInterface;
use Panamax\Contracts\ServiceContainerInterface;
use Panamax\Contracts\ServiceCreatorInterface;
use WebTheory\Config\Config;
use WebTheory\Config\Interfaces\ConfigInterface;

final class Launcher
{
    private string $file;

    private string $path;

    private string $url;

    private ConfigInterface $config;

    private ServiceContainerInterface $container;

    private WpExtensionInterface $extension;

    private static Launcher $instance;

    private function __construct(string $file, string $path, string $url)
    {
        $this->file = $file;
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
            'file' => $this->file,
            'path' => $this->path,
            'url' => $this->url,
            'type' => $app['type'],
            'container' => $container ?? $this->container,
            'dev' => $app['dev'],
        ]);
    }

    private function bootstrap(): void
    {
        $this
            ->bindServicesToContainer()
            ->bindContainerToBaseFacade()
            ->initializeModules()
            ->loadBootProcesses()
            ->maybeBootProviders()
            ->launchLeonidas()
            ->declareExtensionLoaded();
    }

    private function bindServicesToContainer(): self
    {
        $container = $this->container;

        $container->share('root', $this->path);
        $container->share('config', $this->config);

        if ($container instanceof ProviderContainerInterface) {
            $container->addServiceProviders(
                $this->config->get('app.providers', [])
            );
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

    private function maybeBootProviders(): self
    {
        if ($this->container instanceof BootableProviderContainerInterface) {
            $this->container->bootServiceProviders();
        }

        return $this;
    }

    private function loadBootProcesses(): self
    {
        foreach ($this->config->get('app.bootstrap', []) as $bootProcess) {
            /** @var ExtensionBootProcessInterface $bootProcess */
            $bootProcess = new $bootProcess();
            $bootProcess->boot($this->extension, $this->container);
        }

        return $this;
    }

    private function launchLeonidas(): self
    {
        Leonidas::launch($this->extension);

        return $this;
    }

    private function declareExtensionLoaded(): void
    {
        do_action('leonidas_loaded');
    }

    public static function init(string $base): void
    {
        if (!self::isLoaded()) {
            self::reallyInit($base);
        } else {
            throw self::invalidCallException(__METHOD__);
        }
    }

    private static function isLoaded(): bool
    {
        return isset(self::$instance);
    }

    private static function reallyInit(string $base): void
    {
        self::helpers();

        define('LEONIDAS_PLUGIN_HEADERS', Plugin::headers($base));

        self::$instance = new self(
            $base,
            Plugin::path($base),
            Plugin::url($base),
        );

        self::$instance->bootstrap();
    }

    private static function helpers()
    {
        function header(string $header)
        {
            return LEONIDAS_PLUGIN_HEADERS[$header];
        }
    }

    private static function invalidCallException(callable $method): InvalidCallToPluginMethodException
    {
        return new InvalidCallToPluginMethodException(
            self::$instance->extension->getName(),
            $method
        );
    }
}
