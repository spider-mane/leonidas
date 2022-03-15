<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\SlimRouterProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Slim\Interfaces\RouteCollectorProxyInterface;

class SlimRouterServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return RouteCollectorProxyInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['router'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new SlimRouterProvider();
    }
}
