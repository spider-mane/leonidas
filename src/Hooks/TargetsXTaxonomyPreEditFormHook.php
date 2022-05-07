<?php

namespace Leonidas\Hooks;

use Closure;
use WP_Term;

trait TargetsXTaxonomyPreEditFormHook
{
    protected function targetXTaxonomyPreEditFormHook()
    {
        add_action(
            "{$this->getTaxonomy()}_pre_edit_form",
            $this->getXTaxonomyPreEditFormCallback(),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getXTaxonomyPreEditFormCallback(): Closure
    {
        return function (WP_Term $tag, string $taxonomy) {
            $this->doXTaxonomyPreEditFormHookAction($tag, $taxonomy);
        };
    }

    abstract protected function doXTaxonomyPreEditFormHookAction(WP_Term $tag, string $taxonomy): void;

    abstract protected function getTaxonomy(): string;
}
