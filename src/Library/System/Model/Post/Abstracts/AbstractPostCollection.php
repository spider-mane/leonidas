<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Model\Post\Abstracts;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;

abstract class AbstractPostCollection extends AbstractModelCollection implements PostCollectionInterface
{
    public function collect(PostInterface ...$posts): void
    {
        $this->kernel->collect($posts);
    }

    public function add(PostInterface $post): void
    {
        $this->kernel->insert($post);
    }

    public function hasWithId(int ...$id): bool
    {
        return $this->kernel->hasWhere('id', 'in', $id);
    }

    public function hasWithName(int ...$name): bool
    {
        return $this->kernel->hasWhere('name', 'in', $name);
    }

    public function hasWith(string $property, ...$values): bool
    {
        return $this->kernel->hasWhere($property, 'in', $values);
    }

    public function hasWhere(string $property, string $operator, $value): bool
    {
        return $this->kernel->hasWhere($property, $operator, $value);
    }

    public function matches(PostCollectionInterface $posts): bool
    {
        return $this->kernel->matches($posts->toArray());
    }

    public function getById(int $id): ?PostInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getByName(string $name): ?PostInterface
    {
        return $this->kernel->firstWhere('name', '=', $name);
    }

    public function getBy(string $property, $value): ?PostInterface
    {
        return $this->kernel->firstWhere($property, '=', $value);
    }

    public function firstWhere(string $property, string $operator, $value): ?PostInterface
    {
        return $this->kernel->firstWhere($property, $operator, $value);
    }

    public function first(): ?PostInterface
    {
        return $this->kernel->first();
    }

    public function last(): ?PostInterface
    {
        return $this->kernel->last();
    }

    public function withId(int ...$id): AbstractPostCollection
    {
        return $this->kernel->where('id', 'in', $id);
    }

    public function withoutId(int ...$id): AbstractPostCollection
    {
        return $this->kernel->where('id', 'not in', $id);
    }

    public function withName(string ...$name): AbstractPostCollection
    {
        return $this->kernel->where('name', 'in', $name);
    }

    public function withoutName(string ...$name): AbstractPostCollection
    {
        return $this->kernel->where('name', 'not in', $name);
    }

    public function with(string $property, ...$values): AbstractPostCollection
    {
        return $this->kernel->where($property, 'in', $values);
    }

    public function without(string $property, ...$values): AbstractPostCollection
    {
        return $this->kernel->where($property, 'not in', $values);
    }

    public function where(string $property, string $operator, $value): AbstractPostCollection
    {
        return $this->kernel->where($property, $operator, $value);
    }

    public function filter(callable $callback): AbstractPostCollection
    {
        return $this->kernel->filter($callback);
    }

    public function diff(PostCollectionInterface ...$posts): AbstractPostCollection
    {
        return $this->kernel->diff(...$this->expose(...$posts));
    }

    public function contrast(PostCollectionInterface ...$posts): AbstractPostCollection
    {
        return $this->kernel->contrast(...$this->expose(...$posts));
    }

    public function intersect(PostCollectionInterface ...$posts): AbstractPostCollection
    {
        return $this->kernel->intersect(...$this->expose(...$posts));
    }

    public function merge(PostCollectionInterface ...$posts): AbstractPostCollection
    {
        return $this->kernel->merge(...$this->expose(...$posts));
    }

    public function sortBy(string $property, string $order = 'asc'): AbstractPostCollection
    {
        return $this->kernel->sortBy($property, $order);
    }

    public function sortMapped(array $map, string $property, string $order = 'asc'): AbstractPostCollection
    {
        return $this->kernel->sortMapped($map, $property, $order);
    }

    public function sortCustom(callable $callback, string $order = 'asc'): AbstractPostCollection
    {
        return $this->kernel->sortCustom($callback, $order);
    }
}
