<?php

namespace Leonidas\Framework\App;

use Leonidas\Contracts\Extension\App\AppLoaderInterface;
use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\App\Bootstrap\LoadEnvironmentVariables;
use Leonidas\Framework\App\Bootstrap\SetupErrorHandling;
use Leonidas\Framework\Bootstrap\BootServiceProviders;
use Leonidas\Framework\Bootstrap\BuildServiceContainer;
use Leonidas\Framework\Bootstrap\InitializeModules;
use Leonidas\Framework\ExtensionLoader;

class AppLoader extends ExtensionLoader implements AppLoaderInterface
{
    /**
     * @var list<class-string<ExtensionBootProcessInterface>>
     */
    public const BOOTSTRAP = [
        LoadEnvironmentVariables::class,
        SetupErrorHandling::class,
        BuildServiceContainer::class,
        BootServiceProviders::class,
    ];

    /**
     * @var list<class-string<ExtensionBootProcessInterface>>
     */
    public const LOAD = [
        InitializeModules::class,
    ];

    public function __construct(string $path, string $url = '')
    {
        parent::__construct('plugin', $path, $url);
    }

    public function integrate(): void
    {
        $this->initIntegrationClasses();
    }

    /**
     * @return $this
     */
    protected function initIntegrationClasses(): static
    {
        $this->runBootProcesses(
            [...static::LOAD, ...$this->config->get('boot.load', [])]
        );

        return $this;
    }

    protected function defineExtension(): WpExtensionInterface
    {
        return new Application($this->path, $this->resolveExtensionContainer());
    }
}
