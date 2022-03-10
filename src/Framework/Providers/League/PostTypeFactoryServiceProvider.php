<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\PostTypeProvider;
use Leonidas\Library\System\PostType\PostTypeFactory;
use Psr\Container\ContainerInterface;

class PostTypeFactoryServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return PostTypeFactory::class;
    }

    protected function serviceTags(): array
    {
        return ['post_type_factory'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new PostTypeProvider();
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return [
            'prefix' => $this->getConfig('app.prefix'),
        ];
    }
}
