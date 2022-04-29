<?php

namespace Leonidas\Library\System\Model\Post;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;

class PostCollectionFactory implements EntityCollectionFactoryInterface
{
    public function createEntityCollection(object ...$entities): PostCollection
    {
        return new PostCollection(...$entities);
    }
}
