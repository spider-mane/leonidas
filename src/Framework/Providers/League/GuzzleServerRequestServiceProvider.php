<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\GuzzleServerRequestProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class GuzzleServerRequestServiceProvider extends AbstractLeagueProviderWrapper
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
