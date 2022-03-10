<?php

namespace Leonidas\Contracts\Container;

use Psr\Container\ContainerInterface;

interface StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = []);
}
