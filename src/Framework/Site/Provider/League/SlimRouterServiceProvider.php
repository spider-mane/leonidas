<?php

namespace Leonidas\Framework\Site\Provider\League;

use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Site\Provider\SlimRouterProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Slim\Interfaces\RouteCollectorProxyInterface;

class SlimRouterServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'router';
    }

    protected function types(): array
    {
        return [RouteCollectorProxyInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new SlimRouterProvider();
    }
}
