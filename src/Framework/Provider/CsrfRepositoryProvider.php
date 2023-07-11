<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Library\Core\Auth\CsrfManagerRepository;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class CsrfRepositoryProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): CsrfManagerRepository
    {
        return new CsrfManagerRepository($args['prefix']);
    }
}
