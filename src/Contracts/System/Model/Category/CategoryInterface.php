<?php

namespace Leonidas\Contracts\System\Model\Category;

use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;

interface CategoryInterface
{
    public function getPosts(): PostCollectionInterface;
}
