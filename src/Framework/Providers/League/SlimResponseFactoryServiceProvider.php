<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\SlimResponseFactoryProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class SlimResponseFactoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return ResponseFactoryInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['response_factory'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new SlimResponseFactoryProvider();
    }
}
