<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Model\Image\Abstracts;

use Leonidas\Contracts\System\Model\Image\ImageCollectionInterface;
use Leonidas\Contracts\System\Model\Image\ImageInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;

abstract class AbstractImageCollection extends AbstractModelCollection implements ImageCollectionInterface
{
    public function collect(ImageInterface ...$images): void
    {
        $this->kernel->collect($images);
    }

    public function add(ImageInterface $image): void
    {
        $this->kernel->insert($image);
    }

    public function hasWithId(int ...$id): bool
    {
        return $this->kernel->hasWhere('id', 'in', $id);
    }

    public function hasWithName(string ...$name): bool
    {
        return $this->kernel->hasWhere('name', 'in', $name);
    }

    public function hasWithSrc(string ...$src): bool
    {
        return $this->kernel->hasWhere('src', 'in', $src);
    }

    public function hasWith(string $property, ...$values): bool
    {
        return $this->kernel->hasWhere($property, 'in', $values);
    }

    public function hasWhere(string $property, string $operator, $value): bool
    {
        return $this->kernel->hasWhere($property, $operator, $value);
    }

    public function matches(ImageCollectionInterface $images): bool
    {
        return $this->kernel->matches($images->toArray());
    }

    public function getById(int $id): ?ImageInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getByName(string $name): ?ImageInterface
    {
        return $this->kernel->firstWhere('name', '=', $name);
    }

    public function getBySrc(string $src): ?ImageInterface
    {
        return $this->kernel->firstWhere('src', '=', $src);
    }

    public function getBy(string $property, $value): ?ImageInterface
    {
        return $this->kernel->firstWhere($property, '=', $value);
    }

    public function firstWhere(string $property, string $operator, $value): ?ImageInterface
    {
        return $this->kernel->firstWhere($property, $operator, $value);
    }

    public function first(): ?ImageInterface
    {
        return $this->kernel->first();
    }

    public function last(): ?ImageInterface
    {
        return $this->kernel->last();
    }

    public function withId(int ...$id): AbstractImageCollection
    {
        return $this->kernel->where('id', 'in', $id);
    }

    public function withoutId(int ...$id): AbstractImageCollection
    {
        return $this->kernel->where('id', 'not in', $id);
    }

    public function withName(string ...$name): AbstractImageCollection
    {
        return $this->kernel->where('name', 'in', $name);
    }

    public function withoutName(string ...$name): AbstractImageCollection
    {
        return $this->kernel->where('name', 'not in', $name);
    }

    public function withSrc(string ...$src): AbstractImageCollection
    {
        return $this->kernel->where('src', 'in', $src);
    }

    public function withoutSrc(string ...$src): AbstractImageCollection
    {
        return $this->kernel->where('src', 'not in', $src);
    }

    public function with(string $property, ...$values): AbstractImageCollection
    {
        return $this->kernel->where($property, 'in', $values);
    }

    public function without(string $property, ...$values): AbstractImageCollection
    {
        return $this->kernel->where($property, 'not in', $values);
    }

    public function where(string $property, string $operator, $value): AbstractImageCollection
    {
        return $this->kernel->where($property, $operator, $value);
    }

    public function filter(callable $callback): AbstractImageCollection
    {
        return $this->kernel->filter($callback);
    }

    public function diff(ImageCollectionInterface ...$images): AbstractImageCollection
    {
        return $this->kernel->diff(...$this->expose(...$images));
    }

    public function contrast(ImageCollectionInterface ...$images): AbstractImageCollection
    {
        return $this->kernel->contrast(...$this->expose(...$images));
    }

    public function intersect(ImageCollectionInterface ...$images): AbstractImageCollection
    {
        return $this->kernel->intersect(...$this->expose(...$images));
    }

    public function merge(ImageCollectionInterface ...$images): AbstractImageCollection
    {
        return $this->kernel->merge(...$this->expose(...$images));
    }

    public function sortBy(string $property, string $order = 'asc'): AbstractImageCollection
    {
        return $this->kernel->sortBy($property, $order);
    }

    public function sortMappedById(array $map, string $order = 'asc'): AbstractImageCollection
    {
        return $this->kernel->sortMapped($map, 'id', $order);
    }

    public function sortMappedByName(array $map, string $order = 'asc'): AbstractImageCollection
    {
        return $this->kernel->sortMapped($map, 'name', $order);
    }

    public function sortMapped(array $map, string $property, string $order = 'asc'): AbstractImageCollection
    {
        return $this->kernel->sortMapped($map, $property, $order);
    }

    public function sortCustom(callable $callback, string $order = 'asc'): AbstractImageCollection
    {
        return $this->kernel->sortCustom($callback, $order);
    }
}
