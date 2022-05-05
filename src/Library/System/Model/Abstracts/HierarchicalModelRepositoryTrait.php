<?php

namespace Leonidas\Library\System\Model\Abstracts;

use Leonidas\Contracts\System\Model\HierarchicalInterface;

trait HierarchicalModelRepositoryTrait
{
    protected function getParentId(HierarchicalInterface $model): int
    {
        return ($parent = $model->getParent()) ? $parent->getId() : 0;
    }
}
