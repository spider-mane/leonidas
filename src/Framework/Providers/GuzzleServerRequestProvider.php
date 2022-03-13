<?php

namespace Leonidas\Framework\Providers;

use GuzzleHttp\Psr7\ServerRequest;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class GuzzleServerRequestProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): ServerRequest
    {
        return ServerRequest::fromGlobals();
    }
}
