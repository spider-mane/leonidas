<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\GuzzleHttpFactoryProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class GuzzleResponseFactoryServiceProvider extends AbstractLeagueServiceFactory
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
