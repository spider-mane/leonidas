<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Admin\Registrar\MenuPageRegistrarInterface;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\MenuPageRegistrarProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class MenuPageRegistrarServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'menu_page_registrar';
    }

    protected function types(): array
    {
        return [MenuPageRegistrarInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new MenuPageRegistrarProvider();
    }
}
