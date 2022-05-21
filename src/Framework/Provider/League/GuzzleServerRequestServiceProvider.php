<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\GuzzleServerRequestProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class GuzzleServerRequestServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return ServerRequestInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['server_request'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new GuzzleServerRequestProvider();
    }
}
