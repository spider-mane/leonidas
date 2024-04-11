<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeRegistrarInterface;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\PolyRelatablePostTypeRegistrarProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class PolyRelatablePostTypeRegistrarServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'poly_relatable_post_type_registrar';
    }

    protected function types(): array
    {
        return [PolyRelatablePostTypeRegistrarInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new PolyRelatablePostTypeRegistrarProvider();
    }
}
