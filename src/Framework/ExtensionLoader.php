<?php

namespace Leonidas\Framework;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\ExtensionLoaderInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
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
    protected string $path;

    protected string $url;

    protected ServiceContainerInterface $container;

    protected ConfigInterface $config;

    protected WpExtensionInterface $extension;

    public function __construct(string $path, string $url)
    {
        $this->path = $path;
        $this->url = $url;
        $this->config = $this->defineConfig();
        $this->container = $this->defineContainer();
        $this->extension = $this->defineExtension();
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
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
            ->bindServicesToContainer()
            ->initializeModules()
            ->loadBootProcesses()
            ->maybeBootProviders();
    }

    public function error(): void
    {
        $backtrace = debug_backtrace();
        $caller = $backtrace[1];
        $method = $caller['class'] . $caller['type'] . $caller['function'];

        switch ($this->extension->getType()) {
            case 'theme':
                throw new ThemeInitiationException(
                    $this->extension->getName(),
                    $method
                );

            case 'plugin':
                throw new PluginInitiationException(
                    $this->extension->getName(),
                    $method
                );
        }
    }

    protected function defineConfig(): ConfigInterface
    {
        return new Config($this->path . '/config');
    }

    protected function defineContainer(): ServiceContainerInterface
    {
        return require $this->path . '/boot/container.php';
    }

    protected function defineExtension(): WpExtensionInterface
    {
        $data = $this->config->get('app');

        if ($this->container instanceof ContainerAdapterInterface) {
            $container = $this->container->getAdaptedContainer();
        }

        return WpExtension::create([
            'name' => $data['name'],
            'version' => $data['version'],
            'slug' => $data['slug'],
            'prefix' => $data['prefix'],
            'description' => $data['description'],
            'path' => $this->path,
            'url' => $this->url,
            'type' => $data['type'],
            'container' => $container ?? $this->container,
            'dev' => $data['dev'],
        ]);
    }

    protected function bindServicesToContainer(): ExtensionLoader
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

    protected function initializeModules(): ExtensionLoader
    {
        (new ModuleInitializer(
            $this->extension,
            $this->config->get('app.modules', [])
        ))->init();

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
}
