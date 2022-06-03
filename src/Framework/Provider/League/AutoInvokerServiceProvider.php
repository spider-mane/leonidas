<?php

namespace Leonidas\Framework\Provider\League;

use League\Container\ServiceProvider\ServiceProviderInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Framework\Provider\AutoInvokerProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class AutoInvokerServiceProvider extends AbstractLeagueServiceFactory implements ServiceProviderInterface
{
    protected function serviceId(): string
    {
        return AutoInvokerInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['auto_invoker', 'autowire'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new AutoInvokerProvider();
    }

    protected function factoryArgs(): ?array
    {
        return $this->getConfig('container.aliases', []);
    }
}
