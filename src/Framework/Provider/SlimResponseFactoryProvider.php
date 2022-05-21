<?php

namespace Leonidas\Framework\Provider;

use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Factory\ResponseFactory;

class SlimResponseFactoryProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): ResponseFactory
    {
        return new ResponseFactory();
    }
}
