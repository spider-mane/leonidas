<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Library\Core\Config\Config;
use Noodlehaus\ConfigInterface;
use Noodlehaus\Parser\ParserInterface;
use Psr\Container\ContainerInterface;

class ConfigProvider implements StaticProviderInterface
{
    public static function provide(array $args, ContainerInterface $container): ConfigInterface
    {
        $parser = $container->has(ParserInterface::class)
            ? $container->get(ParserInterface::class)
            : null;

        return new Config($args['values'], $parser, $args['string'] ?? false);
    }
}
