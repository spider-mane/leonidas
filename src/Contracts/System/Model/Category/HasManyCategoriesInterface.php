<?php

namespace Leonidas\Contracts\System\Model\Category;

interface HasManyCategoriesInterface
{
    public function getCategories(): CategoryCollectionInterface;
}
