<?php

namespace Leonidas\Framework\Providers\Traits;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Psr\Container\ContainerInterface;

trait UsesStaticProviderTrait
{
    protected function service(ContainerInterface $container)
    {
        return $this->serviceProvider()->provide(
            $container,
            $this->providerArgs($container) ?? []
        );
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return [];
    }

    abstract protected function serviceProvider(): StaticProviderInterface;
}
