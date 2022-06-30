<?php

namespace Leonidas\Contracts\System\Model\Post;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface PostCollectionInterface extends ModelCollectionInterface
{
    public function collect(PostInterface ...$posts): void;

    public function add(PostInterface $post): void;

    public function hasWithId(int ...$id): bool;

    public function hasWithName(int ...$name): bool;

    public function hasWith(string $property, ...$values): bool;

    public function hasWhere(string $property, string $operator, $value): bool;

    public function matches(PostCollectionInterface $posts): bool;

    public function getById(int $id): ?PostInterface;

    public function getByName(string $name): ?PostInterface;

    public function getBy(string $property, $value): ?PostInterface;

    public function firstWhere(string $property, string $operator, $value): ?PostInterface;

    public function first(): ?PostInterface;

    public function last(): ?PostInterface;

    public function withId(int ...$id): PostCollectionInterface;

    public function withoutId(int ...$id): PostCollectionInterface;

    public function withName(string ...$name): PostCollectionInterface;

    public function withoutName(string ...$name): PostCollectionInterface;

    public function with(string $property, ...$values): PostCollectionInterface;

    public function without(string $property, ...$values): PostCollectionInterface;

    public function where(string $property, string $operator, $value): PostCollectionInterface;

    public function filter(callable $callback): PostCollectionInterface;

    public function diff(PostCollectionInterface ...$posts): PostCollectionInterface;

    public function contrast(PostCollectionInterface ...$posts): PostCollectionInterface;

    public function intersect(PostCollectionInterface ...$posts): PostCollectionInterface;

    public function merge(PostCollectionInterface ...$posts): PostCollectionInterface;

    public function sortBy(string $property, string $order = 'asc'): PostCollectionInterface;

    public function sortMapped(array $map, string $property, string $order = 'asc'): PostCollectionInterface;

    public function sortCustom(callable $callback, string $order = 'asc'): PostCollectionInterface;
}
