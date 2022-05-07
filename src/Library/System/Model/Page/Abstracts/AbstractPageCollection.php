<?php

namespace Leonidas\Library\System\Model\Page\Abstracts;

use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;

abstract class AbstractPageCollection extends AbstractModelCollection implements PageCollectionInterface
{
    public function getById(int $id): ?PageInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getByName(string $name): ?PageInterface
    {
        return $this->kernel->firstWhere('name', '=', $name);
    }

    public function hasWithId(int $id): bool
    {
        return $this->kernel->hasWhere('id', '=', $id);
    }

    public function hasWithName(string $name): bool
    {
        return $this->kernel->hasWhere('name', '=', $name);
    }

    public function add(PageInterface $page): void
    {
        $this->kernel->insert($page);
    }

    public function collect(PageInterface ...$pages): void
    {
        $this->kernel->collect($pages);
    }

    public function sortBy(string $sortBy, string $order = 'asc'): PageCollectionInterface
    {
        return $this->kernel->sortBy($sortBy, $order);
    }

    public function sortMapped(array $sortMap, string $order = 'asc'): PageCollectionInterface
    {
        return $this->kernel->sortMapped($sortMap, 'name', $order);
    }

    public function removeWithId(int $id): PageCollectionInterface
    {
        return $this->kernel->where('id', '!=', $id);
    }

    public function removeWithName(string $name): PageCollectionInterface
    {
        return $this->kernel->where('name', '!=', $name);
    }
}
