<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\TaxonomyProvider;
use Leonidas\Library\System\Taxonomy\TaxonomyFactory;
use Psr\Container\ContainerInterface;

class TaxonomyFactoryServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return TaxonomyFactory::class;
    }

    protected function serviceTags(): array
    {
        return ['taxonomy_factory'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new TaxonomyProvider();
    }

    protected function providerArgs(ContainerInterface $container): ?array
    {
        return [
            'prefix' => $this->getConfig('app.prefix'),
        ];
    }
}
