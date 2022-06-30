<?php

namespace Leonidas\Contracts\System\Model\Page;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface PageCollectionInterface extends ModelCollectionInterface
{
    public function collect(PageInterface ...$pages): void;

    public function add(PageInterface $page): void;

    public function hasWithId(int ...$id): bool;

    public function hasWithName(int ...$name): bool;

    public function hasWith(string $property, ...$values): bool;

    public function hasWhere(string $property, string $operator, $value): bool;

    public function matches(PageCollectionInterface $pages): bool;

    public function getById(int $id): ?PageInterface;

    public function getByName(string $name): ?PageInterface;

    public function getBy(string $property, $value): ?PageInterface;

    public function firstWhere(string $property, string $operator, $value): ?PageInterface;

    public function first(): ?PageInterface;

    public function last(): ?PageInterface;

    public function withId(int ...$id): PageCollectionInterface;

    public function withoutId(int ...$id): PageCollectionInterface;

    public function withName(string ...$name): PageCollectionInterface;

    public function withoutName(string ...$name): PageCollectionInterface;

    public function with(string $property, ...$values): PageCollectionInterface;

    public function without(string $property, ...$values): PageCollectionInterface;

    public function where(string $property, string $operator, $value): PageCollectionInterface;

    public function filter(callable $callback): PageCollectionInterface;

    public function diff(PageCollectionInterface ...$pages): PageCollectionInterface;

    public function contrast(PageCollectionInterface ...$pages): PageCollectionInterface;

    public function intersect(PageCollectionInterface ...$pages): PageCollectionInterface;

    public function merge(PageCollectionInterface ...$pages): PageCollectionInterface;

    public function sortBy(string $property, string $order = 'asc'): PageCollectionInterface;

    public function sortMapped(array $map, string $property, string $order = 'asc'): PageCollectionInterface;

    public function sortCustom(callable $callback, string $order = 'asc'): PageCollectionInterface;
}
