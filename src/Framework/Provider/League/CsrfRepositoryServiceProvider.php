<?php

namespace Leonidas\Framework\Provider\League;

use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use Leonidas\Framework\Provider\CsrfRepositoryProvider;
use Panamax\Contracts\ServiceFactoryInterface;

class CsrfRepositoryServiceProvider extends AbstractLeagueServiceFactory
{
    protected function serviceId(): string
    {
        return CsrfManagerRepositoryInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['csrf', 'csrf_manager'];
    }

    protected function serviceFactory(): ServiceFactoryInterface
    {
        return new CsrfRepositoryProvider();
    }
}
