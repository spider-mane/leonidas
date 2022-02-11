<?php

namespace Leonidas\Traits\Hooks;

use Closure;
use WP_Term;

trait TargetsXTaxonomyTermEditFormTopHook
{
    protected function targetXTaxonomyTermEditFormTopHook()
    {
        add_action(
            "{$this->getTaxonomy()}_term_edit_form_top",
            Closure::fromCallable([$this, 'doXTaxonomyTermEditFormTopAction']),
            $this->getXTaxonomyTermEditFormTopPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getXTaxonomyTermEditFormTopPriority(): int
    {
        return 10;
    }

    abstract protected function getTaxonomy(): string;

    abstract protected function doXTaxonomyTermEditFormTopAction(WP_Term $term, string $taxonomy): void;
}
