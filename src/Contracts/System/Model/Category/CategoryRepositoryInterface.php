<?php

namespace Leonidas\Contracts\System\Model\Category;

use Leonidas\Library\System\Model\Category\CategoryCollection;

interface CategoryRepositoryInterface
{
    public function select(int $id): CategoryInterface;

    public function whereObjectId(int $objectId): CategoryCollection;
}
