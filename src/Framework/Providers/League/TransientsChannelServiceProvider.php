<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\TransientsChannelProvider;
use Psr\Container\ContainerInterface;

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

    protected function serviceProvider(): StaticProviderInterface
    {
        return new TransientsChannelProvider();
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return [
            'channel' => $this->getConfig('app.prefix'),
        ];
    }
}
