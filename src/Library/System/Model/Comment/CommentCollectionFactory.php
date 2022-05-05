<?php

namespace Leonidas\Library\System\Model\Comment;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;

class CommentCollectionFactory implements EntityCollectionFactoryInterface
{
    public function createEntityCollection(object ...$entities): CommentCollection
    {
        return new CommentCollection(...$entities);
    }
}
