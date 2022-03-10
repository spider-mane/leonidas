<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Library\Core\Auth\CsrfManagerRepository;
use Psr\Container\ContainerInterface;

class CsrfRepositoryProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = []): CsrfManagerRepository
    {
        return new CsrfManagerRepository();
    }
}
