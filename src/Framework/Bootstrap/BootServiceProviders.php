<?php

namespace Leonidas\Framework\Bootstrap;

use Leonidas\Contracts\Extension\ExtensionBootProcessInterface;
use Leonidas\Contracts\Extension\WpExtensionInterface;
use LogicException;
use Panamax\Contracts\BootableProviderContainerInterface;
use Panamax\Contracts\ServiceContainerInterface;

class BootServiceProviders implements ExtensionBootProcessInterface
{
    public function boot(WpExtensionInterface $extension, ServiceContainerInterface $container): void
    {
        if ($container instanceof BootableProviderContainerInterface) {
            $container->bootServiceProviders();
        } else {
            throw new LogicException(
                "\"\$container\" must be instance of " . BootableProviderContainerInterface::class . " boot process to work."
            );
        }
    }
}
