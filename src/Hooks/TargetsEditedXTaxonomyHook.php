<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsEditedXTaxonomyHook
{
    protected function targetEditedXTaxonomyHook()
    {
        add_action(
            "edited_{$this->getTaxonomy()}",
            Closure::fromCallable([$this, 'doEditedXTaxonomyAction']),
            $this->getEditedXTaxonomyPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getEditedXTaxonomyPriority(): int
    {
        return 10;
    }

    abstract protected function doEditedXTaxonomyAction(int $termId, int $ttId): void;

    abstract protected function getTaxonomy(): string;
}
