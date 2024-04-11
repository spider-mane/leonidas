<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeRepositoryInterface;
use Leonidas\Library\System\Schema\Post\PolyRelatablePostTypeRepository;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class PolyRelatablePostTypeRepositoryProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): PolyRelatablePostTypeRepositoryInterface
    {
        return new PolyRelatablePostTypeRepository();
    }
}
