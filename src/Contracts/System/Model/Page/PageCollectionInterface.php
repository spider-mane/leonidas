<?php

namespace Leonidas\Contracts\System\Model\Page;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface PageCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): PageInterface;

    public function getByName(string $name): PageInterface;

    public function hasWithId(int $id): bool;

    public function hasWithName(string $name): bool;
}
