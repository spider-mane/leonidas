<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\SlimResponseFactoryProvider;
use Panamax\Contracts\ServiceFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class SlimResponseFactoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'response_factory';
    }

    protected function types(): array
    {
        return [ResponseFactoryInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new SlimResponseFactoryProvider();
    }
}
