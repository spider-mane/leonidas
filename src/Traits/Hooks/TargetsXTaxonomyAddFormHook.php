<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsXTaxonomyAddFormHook
{
    protected function targetXTaxonomyAddFormHook()
    {
        add_action(
            "{$this->getTaxonomy()}_add_form",
            Closure::fromCallable([$this, 'doXTaxonomyAddFormAction']),
            $this->getXTaxonomyAddFormPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getXTaxonomyAddFormPriority(): int
    {
        return 10;
    }

    abstract protected function getTaxonomy(): string;

    abstract protected function doXTaxonomyAddFormAction(string $taxonomy): void;
}
