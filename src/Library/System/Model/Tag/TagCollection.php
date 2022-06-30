<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Model\Tag;

use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;

class TagCollection extends AbstractModelCollection implements TagCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    public function __construct(TagInterface ...$tags)
    {
        $this->initKernel($tags);
    }

    public function collect(TagInterface ...$tags): void
    {
        $this->kernel->collect($tags);
    }

    public function add(TagInterface $tag): void
    {
        $this->kernel->insert($tag);
    }

    public function hasWithId(int ...$id): bool
    {
        return $this->kernel->hasWhere('id', 'in', $id);
    }

    public function hasWithSlug(string ...$slug): bool
    {
        return $this->kernel->hasWhere('slug', 'in', $slug);
    }

    public function hasWith(string $property, ...$values): bool
    {
        return $this->kernel->hasWhere($property, 'in', $values);
    }

    public function hasWhere(string $property, string $operator, $value): bool
    {
        return $this->kernel->hasWhere($property, $operator, $value);
    }

    public function matches(TagCollectionInterface $tags): bool
    {
        return $this->kernel->matches($tags->toArray());
    }

    public function getById(int $id): ?TagInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getBySlug(string $slug): ?TagInterface
    {
        return $this->kernel->firstWhere('slug', '=', $slug);
    }

    public function getBy(string $property, $value): ?TagInterface
    {
        return $this->kernel->firstWhere($property, '=', $value);
    }

    public function firstWhere(string $property, string $operator, $value): ?TagInterface
    {
        return $this->kernel->firstWhere($property, $operator, $value);
    }

    public function first(): ?TagInterface
    {
        return $this->kernel->first();
    }

    public function last(): ?TagInterface
    {
        return $this->kernel->last();
    }

    public function withId(int ...$id): TagCollection
    {
        return $this->kernel->where('id', 'in', $id);
    }

    public function withoutId(int ...$id): TagCollection
    {
        return $this->kernel->where('id', 'not in', $id);
    }

    public function withSlug(string ...$slug): TagCollection
    {
        return $this->kernel->where('slug', 'in', $slug);
    }

    public function withoutSlug(string ...$slug): TagCollection
    {
        return $this->kernel->where('slug', 'not in', $slug);
    }

    public function with(string $property, ...$values): TagCollection
    {
        return $this->kernel->where($property, 'in', $values);
    }

    public function without(string $property, ...$values): TagCollection
    {
        return $this->kernel->where($property, 'not in', $values);
    }

    public function where(string $property, string $operator, $value): TagCollection
    {
        return $this->kernel->where($property, $operator, $value);
    }

    public function filter(callable $callback): TagCollection
    {
        return $this->kernel->filter($callback);
    }

    public function diff(TagCollectionInterface ...$tags): TagCollection
    {
        return $this->kernel->diff(...$this->expose(...$tags));
    }

    public function contrast(TagCollectionInterface ...$tags): TagCollection
    {
        return $this->kernel->contrast(...$this->expose(...$tags));
    }

    public function intersect(TagCollectionInterface ...$tags): TagCollection
    {
        return $this->kernel->intersect(...$this->expose(...$tags));
    }

    public function merge(TagCollectionInterface ...$tags): TagCollection
    {
        return $this->kernel->merge(...$this->expose(...$tags));
    }

    public function sortBy(string $property, string $order = 'asc'): TagCollection
    {
        return $this->kernel->sortBy($property, $order);
    }

    public function sortMapped(array $map, string $property, string $order = 'asc'): TagCollection
    {
        return $this->kernel->sortMapped($map, $property, $order);
    }

    public function sortCustom(callable $callback, string $order = 'asc'): TagCollection
    {
        return $this->kernel->sortCustom($callback, $order);
    }
}
