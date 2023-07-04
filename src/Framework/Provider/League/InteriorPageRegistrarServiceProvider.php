<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Admin\Registrar\InteriorPageRegistrarInterface;
use Leonidas\Framework\Provider\InteriorPageRegistrarProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class InteriorPageRegistrarServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'interior_page_registrar';
    }

    protected function types(): array
    {
        return [InteriorPageRegistrarInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new InteriorPageRegistrarProvider();
    }
}
