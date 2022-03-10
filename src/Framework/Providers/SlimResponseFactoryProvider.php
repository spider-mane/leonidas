<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Factory\ResponseFactory;

class SlimResponseFactoryProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = []): ResponseFactory
    {
        return new ResponseFactory();
    }
}
