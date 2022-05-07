<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsXTaxonomyPreAddFormHook
{
    protected function targetXTaxonomyPreAddFormHook()
    {
        add_action(
            "{$this->getTaxonomy()}_pre_add_form",
            $this->getXTaxonomyPreAddFormCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getXTaxonomyPreAddFormCallback(): Closure
    {
        return function (string $taxonomy) {
            $this->doXTaxonomyPreAddFormAction($taxonomy);
        };
    }

    abstract protected function getTaxonomy(): string;

    abstract protected function doXTaxonomyPreAddFormAction(string $taxonomy): void;
}
