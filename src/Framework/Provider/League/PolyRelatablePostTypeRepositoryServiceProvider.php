<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeRepositoryInterface;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\PolyRelatablePostTypeRepositoryProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class PolyRelatablePostTypeRepositoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'poly_relatable_post_types';
    }

    protected function types(): array
    {
        return [PolyRelatablePostTypeRepositoryInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new PolyRelatablePostTypeRepositoryProvider();
    }
}
