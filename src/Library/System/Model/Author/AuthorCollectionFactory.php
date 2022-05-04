<?php

namespace Leonidas\Library\System\Model\Author;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;

class AuthorCollectionFactory implements EntityCollectionFactoryInterface
{
    public function createEntityCollection(object ...$entities): object
    {
        return new AuthorCollection(...$entities);
    }
}
