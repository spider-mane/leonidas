<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Option\OptionRepositoryInterface;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Leonidas\Framework\Provider\OptionRepositoryProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class OptionRepositoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'option_repository';
    }

    protected function types(): array
    {
        return [OptionRepositoryInterface::class];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new OptionRepositoryProvider();
    }
}
