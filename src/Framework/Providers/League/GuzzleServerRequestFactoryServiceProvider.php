<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\GuzzleHttpFactoryProvider;
use Psr\Http\Message\ServerRequestFactoryInterface;

class GuzzleServerRequestFactoryServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return ServerRequestFactoryInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['server_request_factory'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new GuzzleHttpFactoryProvider();
    }
}
