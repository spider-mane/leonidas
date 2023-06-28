<?php

namespace Leonidas\Contracts\System\Configuration\Taxonomy;

interface TaxonomyFactoryInterface
{
    public function create(string $name, array $args): TaxonomyInterface;

    public function build(string $name, array $args): TaxonomyBuilderInterface;

    /**
     * @return TaxonomyInterface[]
     */
    public function createMany(array $definitions): array;

    /**
     * @return TaxonomyBuilderInterface[]
     */
    public function buildMany(array $definitions): array;
}
