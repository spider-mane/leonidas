<?php

namespace Leonidas\Library\System\Model\Page\Abstracts;

use Leonidas\Contracts\System\Model\Page\PageCollectionInterface;
use Leonidas\Contracts\System\Model\Page\PageInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelCollection;

abstract class AbstractPageCollection extends AbstractModelCollection implements PageCollectionInterface
{
    public function getById(int $id): PageInterface
    {
        return $this->kernel->firstWhere('id', '=', $id);
    }

    public function getByName(string $name): PageInterface
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
}
