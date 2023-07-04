<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Admin\Registrar\SubmenuPageRegistrarInterface;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\SubmenuPageRegistrarProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class SubmenuPageRegistrarServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'submenu_page_registrar';
    }

    protected function types(): array
    {
        return [SubmenuPageRegistrarInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new SubmenuPageRegistrarProvider();
    }
}
