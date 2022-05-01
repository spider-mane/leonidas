<?php

namespace Leonidas\Contracts\System\Model\Page;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface PageCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): ?PageInterface;

    public function getByName(string $name): ?PageInterface;

    public function hasWithId(int $id): bool;

    public function hasWithName(string $name): bool;

    public function sortBy(string $sortBy, string $order = 'asc'): PageCollectionInterface;

    public function sortMapped(array $sortMap, string $order = 'asc'): PageCollectionInterface;

    public function removeWithName(string $name): PageCollectionInterface;

    public function removeWithId(int $id): PageCollectionInterface;
}
