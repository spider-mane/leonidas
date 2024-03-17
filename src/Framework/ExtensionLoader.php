<?php

namespace Leonidas\Framework;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\ExtensionLoaderInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\Bootstrap\BootServiceProviders;
use Leonidas\Framework\Bootstrap\BuildServiceContainer;
use Leonidas\Framework\Bootstrap\InitializeModules;
use Panamax\Contracts\ContainerAdapterInterface;
use Panamax\Contracts\ServiceContainerInterface;
use Psr\Container\ContainerInterface;
use WebTheory\Config\Config;
use WebTheory\Config\Interfaces\ConfigInterface;

class ExtensionLoader implements ExtensionLoaderInterface
{
    /**
     * @var list<class-string<ExtensionBootProcessInterface>>
     */
    public const BOOTSTRAP = [
        BuildServiceContainer::class,
        BootServiceProviders::class,
        InitializeModules::class,
    ];

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
        $this->config = $this->defineConfig();
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
            ->initBootClasses()
            ->requireExtraScripts();
    }

    protected function defineContainer(): ServiceContainerInterface
    {
        return (static function (self $self) {
            $root = $self->path;

            $__script = $root . '/' . $self->getContainerScript();

            unset($self);

            return require $__script;
        })($this);
    }

    protected function getContainerScript(): string
    {
        return 'boot/container.php';
    }

    protected function defineExtension(): WpExtensionInterface
    {
        $container = $this->resolveExtensionContainer();

        return new WpExtension($this->type, $this->path, $this->url, $container);
    }

    protected function resolveExtensionContainer(): ContainerInterface
    {
        return $this->container instanceof ContainerAdapterInterface
            ? $this->container->getAdaptedContainer()
            : $this->container;
    }

    protected function defineConfig(): ConfigInterface
    {
        return new Config($this->path . $this->getConfigPath());
    }

    protected function getConfigPath(): string
    {
        return '/config';
    }

    /**
     * @return $this
     */
    protected function bindServicesToContainer(): static
    {
        $container = $this->container;

        $container->share('config', $this->config);
        $container->share('root', fn () => $this->extension->absPath());
        $container->share('url', fn () => $this->extension->getUrl());

        return $this;
    }

    /**
     * @return $this
     */
    protected function requireExtraScripts(): static
    {
        $extension = $this->getExtension();
        $__scripts = $this->getBootScriptDir();

        array_map(static function ($__script) use ($extension, $__scripts) {
            require $extension->absPath("/{$__scripts}/{$__script}.php");
        }, $extension->config('boot.scripts', []));

        return $this;
    }

    protected function getBootScriptDir(): string
    {
        return 'boot';
    }

    /**
     * @return $this
     */
    protected function initBootClasses(): static
    {
        $this->runBootProcesses(
            [...static::BOOTSTRAP, ...$this->config->get('boot.classes', [])]
        );

        return $this;
    }

    /**
     * @param array<class-string<ExtensionBootProcessInterface>> $processes
     */
    protected function runBootProcesses(array $processes): void
    {
        foreach (array_unique($processes) as $process) {
            (new $process())->boot($this->extension, $this->container);
        }
    }
}
