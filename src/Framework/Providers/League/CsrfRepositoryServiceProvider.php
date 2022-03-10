<?php

namespace Leonidas\Framework\Providers\League;

use Leonidas\Contracts\Auth\CsrfManagerRepositoryInterface;
use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Framework\Providers\CsrfRepositoryProvider;

class CsrfRepositoryServiceProvider extends AbstractLeagueProviderWrapper
{
    protected function serviceId(): string
    {
        return CsrfManagerRepositoryInterface::class;
    }

    protected function serviceTags(): array
    {
        return ['csrf', 'csrf_manager'];
    }

    protected function serviceProvider(): StaticProviderInterface
    {
        return new CsrfRepositoryProvider();
    }
}
