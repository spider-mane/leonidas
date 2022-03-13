<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\SlimRequestProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class SlimRequestServiceProvider extends AbstractLeagueProviderWrapper
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
        return new SlimRequestProvider();
    }
}
