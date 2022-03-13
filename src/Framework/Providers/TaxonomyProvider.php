<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Library\System\Taxonomy\TaxonomyFactory;
use Panamax\Contracts\ServiceFactoryInterface;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class TaxonomyProvider extends AbstractServiceFactory implements ServiceFactoryInterface
{
    public function create(ContainerInterface $container, array $args = []): TaxonomyFactory
    {
        return new TaxonomyFactory($args['prefix']);
    }
}
