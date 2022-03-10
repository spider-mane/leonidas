<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\CallableResolver;
use Slim\Interfaces\RouteCollectorInterface;
use Slim\Routing\RouteCollectorProxy;

class SlimRouterProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = []): RouteCollectorProxy
    {
        $routeCollector = $container->get(RouteCollectorInterface::class)
            ? $container->get(RouteCollectorInterface::class)
            : null;

        return new RouteCollectorProxy(
            $container->get(ResponseFactoryInterface::class),
            new CallableResolver($container),
            $container,
            $routeCollector,
            $args['group_pattern'] ?? ''
        );
    }
}
