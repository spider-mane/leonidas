<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\GuzzleServerRequestProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

class GuzzleServerRequestServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'server_request';
    }

    protected function types(): array
    {
        return [ServerRequestInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new GuzzleServerRequestProvider();
    }

    protected function shared(): ?bool
    {
        return false;
    }
}
