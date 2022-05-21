<?php

namespace Leonidas\Framework\Provider;

use Noodlehaus\Parser\ParserInterface;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use WebTheory\Config\Config;

class ConfigProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): Config
    {
        $parserService = $args['$parser'] ?? ParserInterface::class;

        $parser = $container->has($parserService)
            ? $container->get($parserService)
            : null;

        return new Config($args['values'], $parser, $args['string'] ?? false);
    }
}
