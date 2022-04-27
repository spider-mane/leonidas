<?php

namespace Leonidas\Contracts\System\Model\Post;

use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;

interface PostCollectionInterface extends SystemModelCollectionInterface
{
    public function getById(int $id): ?PostInterface;

    public function getByName(string $name): ?PostInterface;

    public function getBy(string $property, $value): ?PostInterface;

    public function first(): PostInterface;

    public function last(): PostInterface;

    public function add(PostInterface $post): void;

    public function hasPosts(): bool;

    public function containsId(int $id): bool;

    public function containsName(string $name): bool;

    public function merge(PostCollectionInterface ...$collections): PostCollectionInterface;

    public function diff(PostCollectionInterface ...$collections): PostCollectionInterface;

    public function contrast(PostCollectionInterface ...$collections): PostCollectionInterface;

    public function intersect(PostCollectionInterface ...$collections): PostCollectionInterface;

    public function matches(PostCollectionInterface $collection): bool;

    public function withoutId(int ...$ids): PostCollectionInterface;

    public function withoutName(string ...$names): PostCollectionInterface;

    public function filter(callable $callback): PostCollectionInterface;

    public function sortBy(string $property, string $order = 'asc'): PostCollectionInterface;

    public function sortMapped(array $map, string $property, string $order = 'asc'): PostCollectionInterface;

    public function sortCustom(callable $callback): PostCollectionInterface;

    /**
     * @return array<int|string,PostInterface>
     */
    public function toArray(): array;
}
