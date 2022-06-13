<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\TaxonomyProvider;
use Leonidas\Library\System\Model\Taxonomy\TaxonomyFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class TaxonomyFactoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'taxonomy_factory';
    }

    protected function types(): array
    {
        return [TaxonomyFactory::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new TaxonomyProvider();
    }

    protected function args(): ?array
    {
        return [
            'prefix' => $this->getConfig('app.prefix'),
        ];
    }
}
