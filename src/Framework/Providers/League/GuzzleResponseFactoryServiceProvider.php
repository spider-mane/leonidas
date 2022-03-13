<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\GuzzleHttpFactoryProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class GuzzleResponseFactoryServiceProvider extends AbstractLeagueProviderWrapper
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
        return new GuzzleHttpFactoryProvider();
    }
}
