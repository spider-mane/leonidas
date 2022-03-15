<?php

namespace Framework\Bootstrappers;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use Panamax\Contracts\ProviderContainerInterface;
use Panamax\Contracts\ServiceContainerInterface;
use Panamax\Contracts\ServiceCreatorInterface;

class BuildServiceContainer implements ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        if ($container instanceof ProviderContainerInterface) {
            $container->addServiceProviders(
                $extension->config('app.providers', [])
            );
        }

        if ($container instanceof ServiceCreatorInterface) {
            $container->createServices($extension->config('app.services', []));
        }
    }
}
