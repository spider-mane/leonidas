<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Noodlehaus\ConfigInterface;
use Psr\Container\ContainerInterface;
use WebTheory\GuctilityBelt\Config;

class ConfigProvider implements StaticProviderInterface
{
    public static function provide(array $args, ContainerInterface $container): ConfigInterface
    {
        return new Config(
            $args['values'],
            $args['parser'] ?? null,
            $args['string'] ?? false
        );
    }
}
