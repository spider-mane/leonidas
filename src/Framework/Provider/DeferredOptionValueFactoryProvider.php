<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\Option\OptionRepositoryInterface;
use Leonidas\Library\System\Configuration\Option\DeferredOptionValueFactory;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class DeferredOptionValueFactoryProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): DeferredOptionValueFactory
    {
        return new DeferredOptionValueFactory(
            $container->get(OptionRepositoryInterface::class)
        );
    }
}
