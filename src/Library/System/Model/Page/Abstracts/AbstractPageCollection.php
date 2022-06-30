<?php

declare(strict_types=1);

namespace Leonidas\Library\System\Model\Page\Abstracts;

use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;

abstract class AbstractPageCollection extends AbstractModelCollection implements PageCollectionInterface
{
    public function collect(PageInterface ...$pages): void
    {
        $this->kernel->collect($pages);
    }

    public function add(PageInterface $page): void
    {
        $this->kernel->insert($page);
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

    public function matches(PageCollectionInterface $pages): bool
    {
        return $this->kernel->matches($pages->toArray());
    }

    public function getById(int $id): ?PageInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getByName(string $name): ?PageInterface
    {
        return $this->kernel->firstWhere('name', '=', $name);
    }

    public function getBy(string $property, $value): ?PageInterface
    {
        return $this->kernel->firstWhere($property, '=', $value);
    }

    public function firstWhere(string $property, string $operator, $value): ?PageInterface
    {
        return $this->kernel->firstWhere($property, $operator, $value);
    }

    public function first(): ?PageInterface
    {
        return $this->kernel->first();
    }

    public function last(): ?PageInterface
    {
        return $this->kernel->last();
    }

    public function withId(int ...$id): AbstractPageCollection
    {
        return $this->kernel->where('id', 'in', $id);
    }

    public function withoutId(int ...$id): AbstractPageCollection
    {
        return $this->kernel->where('id', 'not in', $id);
    }

    public function withName(string ...$name): AbstractPageCollection
    {
        return $this->kernel->where('name', 'in', $name);
    }

    public function withoutName(string ...$name): AbstractPageCollection
    {
        return $this->kernel->where('name', 'not in', $name);
    }

    public function with(string $property, ...$values): AbstractPageCollection
    {
        return $this->kernel->where($property, 'in', $values);
    }

    public function without(string $property, ...$values): AbstractPageCollection
    {
        return $this->kernel->where($property, 'not in', $values);
    }

    public function where(string $property, string $operator, $value): AbstractPageCollection
    {
        return $this->kernel->where($property, $operator, $value);
    }

    public function filter(callable $callback): AbstractPageCollection
    {
        return $this->kernel->filter($callback);
    }

    public function diff(PageCollectionInterface ...$pages): AbstractPageCollection
    {
        return $this->kernel->diff(...$this->expose(...$pages));
    }

    public function contrast(PageCollectionInterface ...$pages): AbstractPageCollection
    {
        return $this->kernel->contrast(...$this->expose(...$pages));
    }

    public function intersect(PageCollectionInterface ...$pages): AbstractPageCollection
    {
        return $this->kernel->intersect(...$this->expose(...$pages));
    }

    public function merge(PageCollectionInterface ...$pages): AbstractPageCollection
    {
        return $this->kernel->merge(...$this->expose(...$pages));
    }

    public function sortBy(string $property, string $order = 'asc'): AbstractPageCollection
    {
        return $this->kernel->sortBy($property, $order);
    }

    public function sortMapped(array $map, string $property, string $order = 'asc'): AbstractPageCollection
    {
        return $this->kernel->sortMapped($map, $property, $order);
    }

    public function sortCustom(callable $callback, string $order = 'asc'): AbstractPageCollection
    {
        return $this->kernel->sortCustom($callback, $order);
    }
}
