<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use Leonidas\Framework\Providers\CsrfRepositoryProvider;
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
