<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\TransientsChannelProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class TransientsChannelServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'cache_channel';
    }

    protected function aliases(): array
    {
        return ['transients_channel'];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new TransientsChannelProvider();
    }

    protected function args(): ?array
    {
        return [
            'channel' => $this->getConfig('app.prefix'),
        ];
    }
}
