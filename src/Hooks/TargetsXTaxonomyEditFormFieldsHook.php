<?php

namespace Leonidas\Hooks;

use Closure;
use WP_Term;

trait TargetsXTaxonomyEditFormFieldsHook
{
    protected function targetXTaxonomyEditFormFieldsHook()
    {
        add_action(
            "{$this->getTaxonomy()}_edit_form_fields",
            Closure::fromCallable([$this, 'doXTaxonomyEditFormFieldsAction']),
            $this->getXTaxonomyEditFormFieldsPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getXTaxonomyEditFormFieldsPriority(): int
    {
        return 10;
    }

    abstract protected function getTaxonomy(): string;

    abstract protected function doXTaxonomyEditFormFieldsAction(WP_Term $term, string $taxonomy): void;
}
