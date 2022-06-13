<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\SlimRequestProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class SlimRequestServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'server_request';
    }

    protected function types(): array
    {
        return [ServerRequestInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new SlimRequestProvider();
    }
}
