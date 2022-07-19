<?php

namespace Leonidas\Framework\Provider;

use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;
use WebTheory\Context\Resources;

class AssetResourcesProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): Resources
    {
        return new Resources($args['base'], $args['types']);
    }
}
