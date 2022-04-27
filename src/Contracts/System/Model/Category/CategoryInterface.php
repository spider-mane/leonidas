<?php

namespace Leonidas\Contracts\System\Model\Category;

use Leonidas\Contracts\System\Model\HierarchicalInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;

interface CategoryInterface extends TagInterface, HierarchicalInterface
{
    public function getParent(): ?CategoryInterface;

    public function getChildren(): CategoryCollectionInterface;

    public function setParent(?CategoryInterface $parent): CategoryInterface;
}
