<?php

namespace Leonidas\Library\System\Model\Abstracts\Term;

trait HierarchicalTermTrait
{
    use MappedToWpTermTrait;

    public function getParentId(): int
    {
        return $this->term->parent;
    }
}
