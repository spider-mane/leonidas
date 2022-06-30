<?php

namespace Leonidas\Contracts\System\Model\Category;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface CategoryCollectionInterface extends ModelCollectionInterface
{
    public function collect(CategoryInterface ...$categories): void;

    public function add(CategoryInterface $category): void;

    public function hasWithId(int ...$id): bool;

    public function hasWithSlug(string ...$slug): bool;

    public function hasWith(string $property, ...$values): bool;

    public function hasWhere(string $property, string $operator, $value): bool;

    public function matches(CategoryCollectionInterface $categories): bool;

    public function getById(int $id): ?CategoryInterface;

    public function getBySlug(string $slug): ?CategoryInterface;

    public function getBy(string $property, $value): ?CategoryInterface;

    public function firstWhere(string $property, string $operator, $value): ?CategoryInterface;

    public function first(): ?CategoryInterface;

    public function last(): ?CategoryInterface;

    public function withId(int ...$id): CategoryCollectionInterface;

    public function withoutId(int ...$id): CategoryCollectionInterface;

    public function withSlug(string ...$slug): CategoryCollectionInterface;

    public function withoutSlug(string ...$slug): CategoryCollectionInterface;

    public function with(string $property, ...$values): CategoryCollectionInterface;

    public function without(string $property, ...$values): CategoryCollectionInterface;

    public function where(string $property, string $operator, $value): CategoryCollectionInterface;

    public function filter(callable $callback): CategoryCollectionInterface;

    public function diff(CategoryCollectionInterface ...$categories): CategoryCollectionInterface;

    public function contrast(CategoryCollectionInterface ...$categories): CategoryCollectionInterface;

    public function intersect(CategoryCollectionInterface ...$categories): CategoryCollectionInterface;

    public function merge(CategoryCollectionInterface ...$categories): CategoryCollectionInterface;

    public function sortBy(string $property, string $order = 'asc'): CategoryCollectionInterface;

    public function sortMapped(array $map, string $property, string $order = 'asc'): CategoryCollectionInterface;

    public function sortCustom(callable $callback, string $order = 'asc'): CategoryCollectionInterface;
}
