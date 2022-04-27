<?php

namespace Leonidas\Contracts\System\Schema;

interface EntityCollectionFactoryInterface
{
    public function createEntityCollection(object ...$entities): object;
}
