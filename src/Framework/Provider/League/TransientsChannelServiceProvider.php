<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\TransientsChannelProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class TransientsChannelServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return 'cache_channel';
    }

    protected function serviceTags(): array
    {
        return ['transients_channel'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new TransientsChannelProvider();
    }

    protected function factoryArgs(): ?array
    {
        return [
            'channel' => $this->getConfig('app.prefix'),
        ];
    }
}
