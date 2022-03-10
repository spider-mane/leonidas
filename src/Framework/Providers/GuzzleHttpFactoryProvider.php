<?php

namespace Leonidas\Framework\Providers;

use GuzzleHttp\Psr7\HttpFactory;
use Leonidas\Contracts\Container\StaticProviderInterface;
use Psr\Container\ContainerInterface;

class GuzzleHttpFactoryProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = []): HttpFactory
    {
        return new HttpFactory();
    }
}
