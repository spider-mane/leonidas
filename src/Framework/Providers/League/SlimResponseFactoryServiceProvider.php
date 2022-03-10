<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\SlimResponseFactoryProvider;
use Psr\Http\Message\ResponseFactoryInterface;

class SlimResponseFactoryServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return ResponseFactoryInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['response_factory'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new SlimResponseFactoryProvider();
    }
}
