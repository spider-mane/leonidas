<?php

namespace Leonidas\Framework\Provider;

use GuzzleHttp\Psr7\ServerRequest;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class GuzzleServerRequestProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): ServerRequestInterface
    {
        return ServerRequest::fromGlobals();
    }
}
