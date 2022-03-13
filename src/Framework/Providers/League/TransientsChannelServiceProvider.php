<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Framework\Providers\TransientsChannelProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class TransientsChannelServiceProvider extends AbstractLeagueProviderWrapper
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
