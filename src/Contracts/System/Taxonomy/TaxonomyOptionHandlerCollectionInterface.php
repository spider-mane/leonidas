<?php

namespace Leonidas\Contracts\System\Taxonomy;

interface TaxonomyOptionHandlerCollectionInterface
{
    public function add(string $option, TaxonomyOptionHandlerInterface $handler);

    public function with(array $handlers);

    public function get(string $handler): TaxonomyOptionHandlerInterface;

    public function remove(string $handler);

    public function has(string $handler): bool;

    /**
     * @return TaxonomyOptionHandlerInterface[]
     */
    public function all(): array;
}
