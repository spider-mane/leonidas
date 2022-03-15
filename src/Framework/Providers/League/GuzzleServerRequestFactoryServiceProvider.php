<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\GuzzleHttpFactoryProvider;
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
