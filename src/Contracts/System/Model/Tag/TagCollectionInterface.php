<?php

namespace Leonidas\Contracts\System\Model\Tag;

interface TagCollectionInterface
{
    /**
     * @return TagInterface[]
     */
    public function all(): array;
}
