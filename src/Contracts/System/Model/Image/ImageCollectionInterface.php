<?php

namespace Leonidas\Contracts\System\Model\Image;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface ImageCollectionInterface extends ModelCollectionInterface
{
    public function collect(ImageInterface ...$images): void;

    public function add(ImageInterface $image): void;

    public function hasWithId(int ...$id): bool;

    public function hasWithName(string ...$name): bool;

    public function hasWithSrc(string ...$src): bool;

    public function hasWith(string $property, ...$values): bool;

    public function hasWhere(string $property, string $operator, $value): bool;

    public function matches(ImageCollectionInterface $images): bool;

    public function getById(int $id): ?ImageInterface;

    public function getByName(string $name): ?ImageInterface;

    public function getBySrc(string $src): ?ImageInterface;

    public function getBy(string $property, $value): ?ImageInterface;

    public function firstWhere(string $property, string $operator, $value): ?ImageInterface;

    public function first(): ?ImageInterface;

    public function last(): ?ImageInterface;

    public function withId(int ...$id): ImageCollectionInterface;

    public function withoutId(int ...$id): ImageCollectionInterface;

    public function withName(string ...$name): ImageCollectionInterface;

    public function withoutName(string ...$name): ImageCollectionInterface;

    public function withSrc(string ...$src): ImageCollectionInterface;

    public function withoutSrc(string ...$src): ImageCollectionInterface;

    public function with(string $property, ...$values): ImageCollectionInterface;

    public function without(string $property, ...$values): ImageCollectionInterface;

    public function where(string $property, string $operator, $value): ImageCollectionInterface;

    public function filter(callable $callback): ImageCollectionInterface;

    public function diff(ImageCollectionInterface ...$images): ImageCollectionInterface;

    public function contrast(ImageCollectionInterface ...$images): ImageCollectionInterface;

    public function intersect(ImageCollectionInterface ...$images): ImageCollectionInterface;

    public function merge(ImageCollectionInterface ...$images): ImageCollectionInterface;

    public function sortBy(string $property, string $order = 'asc'): ImageCollectionInterface;

    public function sortMappedById(array $map, string $order = 'asc'): ImageCollectionInterface;

    public function sortMappedByName(array $map, string $order = 'asc'): ImageCollectionInterface;

    public function sortMapped(array $map, string $property, string $order = 'asc'): ImageCollectionInterface;

    public function sortCustom(callable $callback, string $order = 'asc'): ImageCollectionInterface;
}
