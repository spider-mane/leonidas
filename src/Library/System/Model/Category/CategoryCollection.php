<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;
use Leonidas\Library\System\Model\Abstracts\PoweredByModelCollectionKernelTrait;

class CategoryCollection extends AbstractModelCollection implements CategoryCollectionInterface
{
    use PoweredByModelCollectionKernelTrait;

    public function __construct(CategoryInterface ...$categories)
    {
        $this->initKernel($categories);
    }

    public function collect(CategoryInterface ...$categories): void
    {
        $this->kernel->collect($categories);
    }

    public function add(CategoryInterface $category): void
    {
        $this->kernel->insert($category);
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

    public function matches(CategoryCollectionInterface $categories): bool
    {
        return $this->kernel->matches($categories->toArray());
    }

    public function getById(int $id): ?CategoryInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getBySlug(string $slug): ?CategoryInterface
    {
        return $this->kernel->firstWhere('slug', '=', $slug);
    }

    public function getBy(string $property, $value): ?CategoryInterface
    {
        return $this->kernel->firstWhere($property, '=', $value);
    }

    public function firstWhere(string $property, string $operator, $value): ?CategoryInterface
    {
        return $this->kernel->firstWhere($property, $operator, $value);
    }

    public function first(): ?CategoryInterface
    {
        return $this->kernel->first();
    }

    public function last(): ?CategoryInterface
    {
        return $this->kernel->last();
    }

    public function withId(int ...$id): CategoryCollection
    {
        return $this->kernel->where('id', 'in', $id);
    }

    public function withoutId(int ...$id): CategoryCollection
    {
        return $this->kernel->where('id', 'not in', $id);
    }

    public function withSlug(string ...$slug): CategoryCollection
    {
        return $this->kernel->where('slug', 'in', $slug);
    }

    public function withoutSlug(string ...$slug): CategoryCollection
    {
        return $this->kernel->where('slug', 'not in', $slug);
    }

    public function with(string $property, ...$values): CategoryCollection
    {
        return $this->kernel->where($property, 'in', $values);
    }

    public function without(string $property, ...$values): CategoryCollection
    {
        return $this->kernel->where($property, 'not in', $values);
    }

    public function where(string $property, string $operator, $value): CategoryCollection
    {
        return $this->kernel->where($property, $operator, $value);
    }

    public function filter(callable $callback): CategoryCollection
    {
        return $this->kernel->filter($callback);
    }

    public function diff(CategoryCollectionInterface ...$categories): CategoryCollection
    {
        return $this->kernel->diff(...$this->expose(...$categories));
    }

    public function contrast(CategoryCollectionInterface ...$categories): CategoryCollection
    {
        return $this->kernel->contrast(...$this->expose(...$categories));
    }

    public function intersect(CategoryCollectionInterface ...$categories): CategoryCollection
    {
        return $this->kernel->intersect(...$this->expose(...$categories));
    }

    public function merge(CategoryCollectionInterface ...$categories): CategoryCollection
    {
        return $this->kernel->merge(...$this->expose(...$categories));
    }

    public function sortBy(string $property, string $order = 'asc'): CategoryCollection
    {
        return $this->kernel->sortBy($property, $order);
    }

    public function sortMapped(array $map, string $property, string $order = 'asc'): CategoryCollection
    {
        return $this->kernel->sortMapped($map, $property, $order);
    }

    public function sortCustom(callable $callback, string $order = 'asc'): CategoryCollection
    {
        return $this->kernel->sortCustom($callback, $order);
    }
}
