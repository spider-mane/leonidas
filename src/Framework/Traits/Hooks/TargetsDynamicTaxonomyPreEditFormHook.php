<?php

namespace WebTheory\Leonidas\Framework\Traits\Hooks;

trait TargetsDynamicTaxonomyPreEditFormHook
{
    protected function targetDynamicTaxonomyPreEditFormHook()
    {
        $taxonomy = $this->getTaxonomy();
        add_filter(
            "{$taxonomy}_pre_add_form",
            [$this, 'doDynamicTaxonomyPreEditFormHookAction'],
            $this->defineDynamicTaxonomyPreEditFormHookPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function defineDynamicTaxonomyPreEditFormHookPriority(): ?int
    {
        return null;
    }

    abstract protected function getTaxonomy(): string;

    abstract public function doDynamicTaxonomyPreEditFormHookAction(string $context): void;
}
