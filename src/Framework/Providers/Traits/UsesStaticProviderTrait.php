<?php

namespace Leonidas\Framework\Providers\Traits;

use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Container\ContainerInterface;

trait UsesStaticProviderTrait
{
    protected function service(ContainerInterface $container)
    {
        return $this->serviceFactory()->create(
            $container,
            $this->factoryArgs() ?? []
        );
    }

    protected function factoryArgs(): ?array
    {
        return [];
    }

    abstract protected function serviceFactory(): ServiceFactoryInterface;
}
