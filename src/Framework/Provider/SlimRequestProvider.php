<?php

namespace Leonidas\Framework\Provider;

use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\Psr7\Request;

class SlimRequestProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): Request
    {
        $streamFactoryService = $args['$stream_factory_service'] ?? StreamFactoryInterface::class;
        $uriFactoryService = $args['$uri_factory_service'] ?? UriFactoryInterface::class;

        $streamFactory = $container->has($streamFactoryService)
            ? $container->get($streamFactoryService)
            : null;

        $uriFactory = $container->has($uriFactoryService)
            ? $container->get($uriFactoryService)
            : null;

        $factory = new ServerRequestFactory($streamFactory, $uriFactory);

        return $factory->createFromGlobals();
    }
}
