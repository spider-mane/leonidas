<?php

namespace WebTheory\Leonidas\Framework\Traits\Hooks;

use Closure;

trait TargetsTaxonomyPreAddFormHook
{
    protected function targetTaxonomyPreAddFormHook(): TargetsTaxonomyPreAddFormHook
    {
        $taxonomy = $this->getTaxonomy();

        add_action(
            "{$taxonomy}_pre_add_form",
            $this->getTaxonomyPreAddFormCallback(),
            null,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getTaxonomyPreAddFormCallback(): Closure
    {
        return function (string $taxonomy) {
            $this->doTaxonomyPreAddFormAction($taxonomy);
        };
    }

    abstract protected function getTaxonomy(): string;

    abstract protected function doTaxonomyPreAddFormAction(string $taxonomy): void;
}
