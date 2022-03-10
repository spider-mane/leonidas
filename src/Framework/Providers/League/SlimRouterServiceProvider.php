<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\SlimRouterProvider;
use Slim\Interfaces\RouteCollectorProxyInterface;

class SlimRouterServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return RouteCollectorProxyInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['router'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new SlimRouterProvider();
    }
}
