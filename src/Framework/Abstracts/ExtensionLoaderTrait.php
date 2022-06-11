<?php

namespace Leonidas\Framework\Abstracts;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\ModuleInitializer;
use Leonidas\Framework\WpExtension;
use Panamax\Contracts\BootableProviderContainerInterface;
use Panamax\Contracts\ContainerAdapterInterface;
use Panamax\Contracts\ProviderContainerInterface;
use Panamax\Contracts\ServiceContainerInterface;
use Panamax\Contracts\ServiceCreatorInterface;
use WebTheory\Config\Config;
use WebTheory\Config\Interfaces\ConfigInterface;

trait ExtensionLoaderTrait
{
    private string $path;

    private string $url;

    private ConfigInterface $config;

    private ServiceContainerInterface $container;

    private WpExtensionInterface $extension;

    private static self $instance;

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
            'type' => $app['type'],
            'container' => $container ?? $this->container,
            'dev' => $app['dev'],
        ]);
    }

    private function bootstrap(): void
    {
        $this
            ->bindServicesToContainer()
            ->initializeModules()
            ->loadBootProcesses()
            ->maybeBootProviders();
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

    private function initializeModules(): self
    {
        (new ModuleInitializer(
            $this->extension,
            $this->config->get('app.modules', [])
        ))->init();

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

    private function maybeBootProviders(): self
    {
        if ($this->container instanceof BootableProviderContainerInterface) {
            $this->container->bootServiceProviders();
        }

        return $this;
    }
}
