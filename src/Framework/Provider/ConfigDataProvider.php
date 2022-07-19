<?php

namespace Leonidas\Framework\Provider;

use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use WebTheory\Config\Config;

class ConfigDataProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): Config
    {
        return new Config($args['path']);
    }
}
