<?php

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;

class CategoryCollectionFactory implements EntityCollectionFactoryInterface
{
    public function createEntityCollection(object ...$entities): object
    {
        return new CategoryCollection(...$entities);
    }
}
