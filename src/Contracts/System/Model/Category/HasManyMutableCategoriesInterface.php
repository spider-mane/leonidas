<?php

namespace Leonidas\Contracts\System\Model\Category;

interface HasManyMutableCategoriesInterface extends HasManyCategoriesInterface
{
    /**
     * @return $this
     */
    public function setCategories(CategoryCollectionInterface $categories): self;

    /**
     * @return $this
     */
    public function addCategories(CategoryInterface ...$categories): self;

    /**
     * @return $this
     */
    public function mergeCategories(CategoryCollectionInterface $categories): self;
}
