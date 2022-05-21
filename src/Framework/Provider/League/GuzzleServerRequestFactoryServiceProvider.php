<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\GuzzleHttpFactoryProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;

class GuzzleServerRequestFactoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return ServerRequestFactoryInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['server_request_factory'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new GuzzleHttpFactoryProvider();
    }
}
