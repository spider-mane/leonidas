<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use Leonidas\Framework\Provider\CsrfRepositoryProvider;
use Leonidas\Framework\Provider\League\Abstracts\AbstractLeagueServiceFactory;
use Panamax\Contracts\ServiceFactoryInterface;

class CsrfRepositoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function id(): string
    {
        return 'csrf';
    }

    protected function types(): array
    {
        return [CsrfManagerRepositoryInterface::class];
    }

    protected function aliases(): array
    {
        return ['csrf_manager'];
    }

    protected function factory(): ServiceFactoryInterface
    {
        return new CsrfRepositoryProvider();
    }
}
