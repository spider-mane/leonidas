<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Admin\Registrar\FlexPageRegistrarInterface;
use Leonidas\Framework\Provider\FlexPageRegistrarProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class FlexPageRegistrarServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'flex_page_registrar';
    }

    protected function types(): array
    {
        return [FlexPageRegistrarInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new FlexPageRegistrarProvider();
    }
}
