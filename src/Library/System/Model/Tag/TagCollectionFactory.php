<?php

namespace Leonidas\Library\System\Model\Tag;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;

class TagCollectionFactory implements EntityCollectionFactoryInterface
{
    public function createEntityCollection(object ...$entities): object
    {
        return new TagCollection(...$entities);
    }
}
