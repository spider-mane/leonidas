<?php

namespace Leonidas\Library\System\Model\Post\Abstracts;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;

abstract class AbstractPostCollection extends AbstractModelCollection implements PostCollectionInterface
{
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

    public function add(PostInterface $post): void
    {
        $this->kernel->insert($post);
    }

    public function first(): PostInterface
    {
        return $this->kernel->first();
    }

    public function last(): PostInterface
    {
        return $this->kernel->last();
    }

    public function hasPosts(): bool
    {
        return $this->kernel->hasItems();
    }

    public function containsId(int $id): bool
    {
        return $this->kernel->hasWhere('id', '=', $id);
    }

    public function containsName(string $name): bool
    {
        return $this->kernel->contains($name);
    }

    public function merge(PostCollectionInterface ...$collections): PostCollectionInterface
    {
        return $this->kernel->merge(...$this->expose($collections));
    }

    public function diff(PostCollectionInterface ...$collections): PostCollectionInterface
    {
        return $this->kernel->diff(...$this->expose($collections));
    }

    public function contrast(PostCollectionInterface ...$collections): PostCollectionInterface
    {
        return $this->kernel->contrast(...$this->expose($collections));
    }

    public function intersect(PostCollectionInterface ...$collections): PostCollectionInterface
    {
        return $this->kernel->intersect(...$this->expose($collections));
    }

    public function matches(PostCollectionInterface $collection): bool
    {
        return $this->kernel->matches($collection->toArray());
    }

    public function withoutId(int ...$ids): PostCollectionInterface
    {
        return $this->kernel->where('id', 'not in', $ids);
    }

    public function withoutName(string ...$names): PostCollectionInterface
    {
        return $this->kernel->where('name', 'not in', $names);
    }

    public function filter(callable $callback): PostCollectionInterface
    {
        return $this->kernel->filter($callback);
    }

    public function sortBy(string $property, string $order = 'asc'): PostCollectionInterface
    {
        return $this->kernel->sortBy($property, $order);
    }

    public function sortMapped(array $map, string $property, string $order = 'asc'): PostCollectionInterface
    {
        return $this->kernel->sortMapped($map, $property, $order);
    }

    public function sortCustom(callable $callback): PostCollectionInterface
    {
        return $this->kernel->sortCustom($callback);
    }
}
