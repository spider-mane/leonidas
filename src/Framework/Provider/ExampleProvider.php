<?php

namespace Leonidas\Framework\Provider;

use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use stdClass;

class ExampleProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): stdClass
    {
        return (object) $args;
    }
}
