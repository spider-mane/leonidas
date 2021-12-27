<?php

namespace Leonidas\Framework\Providers\League;

use League\Container\ServiceProvider\AbstractServiceProvider;
use WebTheory\Leonidas\Taxonomy\Factory;

class TaxonomyServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function provides(string $id): bool
    {
        return in_array($id, [Factory::class]);
    }

    /**
     * {@inheritDoc}
     */
    public function register(): void
    {
        $container = $this->getContainer();

        $container->addShared(Factory::class, function () use ($container) {
            return new Factory($container->get('config')->get('wp.option_handlers.taxonomy'));
        })->addTag('taxonomy');
    }
}
