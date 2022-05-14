<?php

namespace Leonidas\Console\Stubs\Model;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface DummyModelCollectionInterface extends ModelCollectionInterface
{
    public function collect(DummyModelInterface ...$tags): void;

    public function add(DummyModelInterface $tag): void;

    public function getById(int $id): DummyModelInterface;

    public function where(string $property, string $operator, $value): DummyModelInterface;

    public function hasWhere(string $property, string $operator, $value): bool;

    public function firstWhere(string $property, string $operator, $value): ?DummyModelInterface;

    public function remove($item): bool;

    public function hasItems(): bool;

    public function hasWithId(int $id): bool;

    public function removeWithId(int $id): DummyModelCollectionInterface;

    public function matches(DummyModelCollectionInterface $tags): bool;

    public function filter(callable $callback): DummyModelCollectionInterface;

    public function diff(DummyModelCollectionInterface ...$collections): DummyModelCollectionInterface;

    public function contrast(DummyModelCollectionInterface ...$collections): DummyModelCollectionInterface;

    public function intersect(DummyModelCollectionInterface ...$collections): DummyModelCollectionInterface;

    public function merge(DummyModelCollectionInterface ...$tags): DummyModelCollectionInterface;

    public function extractIds(): array;

    public function column(string $property): array;

    public function first(): DummyModelInterface;

    public function last(): DummyModelInterface;

    public function sortBy(string $property, string $order = 'asc'): DummyModelCollectionInterface;

    public function sortMapped(array $map, string $property, string $order = 'asc'): DummyModelCollectionInterface;

    public function sortCustom(callable $callback): DummyModelCollectionInterface;
}
