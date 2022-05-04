<?php

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;

class UserCollectionFactory implements EntityCollectionFactoryInterface
{
    public function createEntityCollection(object ...$entities): object
    {
        return new UserCollection(...$entities);
    }
}
