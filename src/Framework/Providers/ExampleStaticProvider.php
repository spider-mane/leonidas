<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Psr\Container\ContainerInterface;
use stdClass;

class ExampleStaticProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = []): stdClass
    {
        return (object) $args;
    }
}
