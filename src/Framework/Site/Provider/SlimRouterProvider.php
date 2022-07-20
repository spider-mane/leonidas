<?php

namespace Leonidas\Framework\Site\Provider;

use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\CallableResolver;
use Slim\Interfaces\RouteCollectorInterface;
use Slim\Routing\RouteCollectorProxy;

class SlimRouterProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): RouteCollectorProxy
    {
        $routeCollector = $container->has(RouteCollectorInterface::class)
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
