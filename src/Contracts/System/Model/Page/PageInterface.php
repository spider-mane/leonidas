<?php

namespace Leonidas\Contracts\System\Model\Page;

use Leonidas\Contracts\System\Model\HierarchicalInterface;
use Leonidas\Contracts\System\Model\Post\PostInterface;

interface PageInterface extends PostInterface, HierarchicalInterface
{
    public function getParent(): ?PageInterface;

    public function getChildren(): PageCollectionInterface;
}
