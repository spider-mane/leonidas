<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsCreatedXTaxonomyHook
{
    protected function targetCreatedXTaxonomyHook()
    {
        add_action(
            "created_{$this->getTaxonomy()}",
            Closure::fromCallable([$this, 'doCreatedXTaxonomyAction']),
            $this->getCreatedXTaxonomyPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getCreatedXTaxonomyPriority(): int
    {
        return 10;
    }

    abstract protected function doCreatedXTaxonomyAction(int $termId, int $ttId): void;

    abstract protected function getTaxonomy(): string;
}
