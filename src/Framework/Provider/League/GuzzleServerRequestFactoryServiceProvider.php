<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\GuzzleHttpFactoryProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;

class GuzzleServerRequestFactoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'server_request_factory';
    }

    protected function types(): array
    {
        return [ServerRequestFactoryInterface::class];
    }

    protected function aliases(): array
    {
        return ['serverRequestFactory'];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new GuzzleHttpFactoryProvider();
    }
}
