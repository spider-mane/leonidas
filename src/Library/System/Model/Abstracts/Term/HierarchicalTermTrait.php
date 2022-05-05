<?php

namespace Leonidas\Library\System\Model\Abstracts\Term;

use WP_Term;

trait HierarchicalTermTrait
{
    protected WP_Term $term;

    public function getParentId(): int
    {
        return $this->term->parent;
    }
}
