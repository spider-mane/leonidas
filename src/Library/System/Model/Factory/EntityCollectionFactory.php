<?php

namespace Leonidas\Library\System\Model\Factory;

use Leonidas\Contracts\System\Schema\EntityCollectionFactoryInterface;

class EntityCollectionFactory implements EntityCollectionFactoryInterface
{
    public function __construct(protected string $class)
    {
        //
    }

    public function createEntityCollection(object ...$entities): object
    {
        return new $this->class(...$entities);
    }
}
