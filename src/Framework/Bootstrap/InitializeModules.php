<?php

namespace Leonidas\Framework\Bootstrap;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Leonidas\Framework\ModuleInitializer;
use Panamax\Contracts\ServiceContainerInterface;

class InitializeModules implements ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        (new ModuleInitializer(
            $extension,
            $extension->config('app.modules', [])
        ))->init();
    }
}
