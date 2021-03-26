<?php

namespace Leonidas\Traits\Hooks;

use Closure;
use WP_Term;

trait TargetsTaxonomyPreEditFormHook
{
    protected function targetTaxonomyPreEditFormHook(): TargetsTaxonomyPreEditFormHook
    {
        $taxonomy = $this->getTaxonomy();

        add_action(
            "{$taxonomy}_pre_edit_form",
            $this->getTaxonomyPreEditFormCallback(),
            null,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getTaxonomyPreEditFormCallback(): Closure
    {
        return function (WP_Term $tag, string $taxonomy) {
            $this->doTaxonomyPreEditFormHookAction($tag, $taxonomy);
        };
    }

    abstract protected function doTaxonomyPreEditFormHookAction(WP_Term $tag, string $taxonomy): void;

    abstract protected function getTaxonomy(): string;
}
