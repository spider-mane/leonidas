<?php

namespace Leonidas\Contracts\System\Model\Tag;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface TagCollectionInterface extends ModelCollectionInterface
{
    public function collect(TagInterface ...$tags): void;

    public function add(TagInterface $tag): void;

    public function hasWithId(int ...$id): bool;

    public function hasWithSlug(string ...$slug): bool;

    public function hasWith(string $property, ...$values): bool;

    public function hasWhere(string $property, string $operator, $value): bool;

    public function matches(TagCollectionInterface $tags): bool;

    public function getById(int $id): ?TagInterface;

    public function getBySlug(string $slug): ?TagInterface;

    public function getBy(string $property, $value): ?TagInterface;

    public function firstWhere(string $property, string $operator, $value): ?TagInterface;

    public function first(): ?TagInterface;

    public function last(): ?TagInterface;

    public function withId(int ...$id): TagCollectionInterface;

    public function withoutId(int ...$id): TagCollectionInterface;

    public function withSlug(string ...$slug): TagCollectionInterface;

    public function withoutSlug(string ...$slug): TagCollectionInterface;

    public function with(string $property, ...$values): TagCollectionInterface;

    public function without(string $property, ...$values): TagCollectionInterface;

    public function where(string $property, string $operator, $value): TagCollectionInterface;

    public function filter(callable $callback): TagCollectionInterface;

    public function diff(TagCollectionInterface ...$tags): TagCollectionInterface;

    public function contrast(TagCollectionInterface ...$tags): TagCollectionInterface;

    public function intersect(TagCollectionInterface ...$tags): TagCollectionInterface;

    public function merge(TagCollectionInterface ...$tags): TagCollectionInterface;

    public function sortBy(string $property, string $order = 'asc'): TagCollectionInterface;

    public function sortMapped(array $map, string $property, string $order = 'asc'): TagCollectionInterface;

    public function sortCustom(callable $callback, string $order = 'asc'): TagCollectionInterface;
}
