<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Noodlehaus\Parser\ParserInterface;
use Psr\Container\ContainerInterface;
use WebTheory\Config\Config;

class ConfigProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = []): Config
    {
        $parser = $container->has(ParserInterface::class)
            ? $container->get(ParserInterface::class)
            : null;

        return new Config($args['values'], $parser, $args['string'] ?? false);
    }
}
