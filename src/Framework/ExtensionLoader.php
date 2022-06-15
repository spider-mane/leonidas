<?php

namespace Leonidas\Framework;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\ExtensionLoaderInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Exception\ExtensionInitiationException;
use Leonidas\Framework\Exception\PluginInitiationException;
use Leonidas\Framework\Exception\ThemeInitiationException;
use Panamax\Contracts\BootableProviderContainerInterface;
use Panamax\Contracts\ContainerAdapterInterface;
use Panamax\Contracts\ProviderContainerInterface;
use Panamax\Contracts\ServiceContainerInterface;
use Panamax\Contracts\ServiceCreatorInterface;
use WebTheory\Config\Config;
use WebTheory\Config\Interfaces\ConfigInterface;

class ExtensionLoader implements ExtensionLoaderInterface
{
    protected string $type;

    protected string $path;

    protected string $url;

    protected ServiceContainerInterface $container;

    protected WpExtensionInterface $extension;

    protected ConfigInterface $config;

    public function __construct(string $type, string $path, string $url)
    {
        $this->type = $type;
        $this->path = $path;
        $this->url = $url;
        $this->container = $this->defineContainer();
        $this->extension = $this->defineExtension();
    }

    public function getContainer(): ServiceContainerInterface
    {
        return $this->container;
    }

    public function getExtension(): WpExtensionInterface
    {
        return $this->extension;
    }

    public function bootstrap(): void
    {
        $this
            ->initiateConfig()
            ->bindServicesToContainer()
            ->loadBootProcesses()
            ->maybeBootProviders()
            ->initializeModules();
    }

    public function error(): void
    {
        $backtrace = debug_backtrace();
        $caller = $backtrace[1];
        $method = $caller['class'] . $caller['type'] . $caller['function'];

        switch ($this->extension->getType()) {
            case 'plugin':
                throw new PluginInitiationException($this->extension, $method);

            case 'theme':
                throw new ThemeInitiationException($this->extension, $method);

            default:
                throw new ExtensionInitiationException($this->extension, $method);
        }
    }

    protected function defineContainer(): ServiceContainerInterface
    {
        return require $this->path . '/boot/container.php';
    }

    protected function defineExtension(): WpExtensionInterface
    {
        $container = $this->container instanceof ContainerAdapterInterface
            ? $this->container->getAdaptedContainer()
            : $this->container;

        return new WpExtension($this->type, $this->path, $this->url, $container);
    }

    protected function initiateConfig(): ExtensionLoader
    {
        $this->config = new Config($this->path . '/config');

        return $this;
    }

    protected function bindServicesToContainer(): ExtensionLoader
    {
        $container = $this->container;

        $container->share('root', $this->path);
        $container->share('url', $this->url);
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

    protected function loadBootProcesses(): ExtensionLoader
    {
        foreach ($this->config->get('app.bootstrap', []) as $bootProcess) {
            /** @var ExtensionBootProcessInterface $bootProcess */
            $bootProcess = new $bootProcess();
            $bootProcess->boot($this->extension, $this->container);
        }

        return $this;
    }

    protected function maybeBootProviders(): ExtensionLoader
    {
        if ($this->container instanceof BootableProviderContainerInterface) {
            $this->container->bootServiceProviders();
        }

        return $this;
    }

    protected function initializeModules(): ExtensionLoader
    {
        (new ModuleInitializer(
            $this->extension,
            $this->config->get('app.modules', [])
        ))->init();

        return $this;
    }
}
