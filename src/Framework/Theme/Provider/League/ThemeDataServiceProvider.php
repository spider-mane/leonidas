<?php

namespace Leonidas\Framework\Theme\Provider\League;

use Leonidas\Framework\Provider\ConfigDataProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class ThemeDataServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'data';
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new ConfigDataProvider();
    }

    protected function args(): ?array
    {
        return ['path' => $this->container->get('root') . '/theme/data'];
    }
}
