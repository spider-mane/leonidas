<?php

namespace Leonidas\Framework\Provider;

use GuzzleHttp\Psr7\HttpFactory;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class GuzzleHttpFactoryProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): HttpFactory
    {
        return new HttpFactory();
    }
}
