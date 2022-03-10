<?php

namespace Leonidas\Framework\Providers;

use Leonidas\Contracts\Container\StaticProviderInterface;
use Leonidas\Library\System\Taxonomy\TaxonomyFactory;
use Psr\Container\ContainerInterface;

class TaxonomyProvider implements StaticProviderInterface
{
    public static function provide(ContainerInterface $container, array $args = []): TaxonomyFactory
    {
        return new TaxonomyFactory($args['prefix']);
    }
}
