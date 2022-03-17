<?php

namespace Leonidas\Contracts\System\Model\Category;

interface CategoryCollectionInterface
{
    /**
     * @var CategoryInterface[]
     */
    public function all(): array;
}
