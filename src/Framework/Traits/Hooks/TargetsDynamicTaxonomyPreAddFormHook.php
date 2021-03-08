<?php

namespace WebTheory\Leonidas\Framework\Traits\Hooks;

trait TargetsDynamicTaxonomyPreAddFormHook
{
    protected function targetDynamicTaxonomyPreAddFormHook()
    {
        $taxonomy = $this->getTaxonomy();

        add_filter(
            "{$taxonomy}_pre_add_form",
            [$this, 'doDynamicTaxonomyPreAddFormHookAction'],
            $this->defineDynamicTaxonomyPreAddFormHookPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function defineDynamicTaxonomyPreAddFormHookPriority(): ?int
    {
        return null;
    }

    abstract protected function getTaxonomy(): string;

    abstract public function doDynamicTaxonomyPreAddFormHookAction(string $context): void;
}
