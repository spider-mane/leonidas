<?php

namespace Leonidas\Framework\Provider;

use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyRegistrarInterface;
use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeRegistrarInterface;
use Leonidas\Contracts\System\Schema\Post\PolyRelatablePostTypeRepositoryInterface;
use Leonidas\Library\System\Schema\Post\PolyRelatablePostTypeRegistrar;
use Panamax\Factories\AbstractServiceFactory;
use Psr\Container\ContainerInterface;

class PolyRelatablePostTypeRegistrarProvider extends AbstractServiceFactory
{
    public function create(ContainerInterface $container, array $args = []): PolyRelatablePostTypeRegistrarInterface
    {
        return new PolyRelatablePostTypeRegistrar(
            $container->get(PolyRelatablePostTypeRepositoryInterface::class),
            $container->get(TaxonomyRegistrarInterface::class)
        );
    }
}
