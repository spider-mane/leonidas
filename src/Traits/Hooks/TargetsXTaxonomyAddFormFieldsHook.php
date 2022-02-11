<?php

namespace Leonidas\Traits\Hooks;

use Closure;

trait TargetsXTaxonomyAddFormFieldsHook
{
    protected function targetXTaxonomyAddFormFieldsHook()
    {
        add_action(
            "{$this->getTaxonomy()}_add_form_fields",
            Closure::fromCallable([$this, 'doXTaxonomyAddFormFieldsAction']),
            $this->getXTaxonomyAddFormFieldsPriority(),
            PHP_INT_MAX
        );

        return $this;
    }

    protected function getXTaxonomyAddFormFieldsPriority(): int
    {
        return 10;
    }

    abstract protected function getTaxonomy(): string;

    abstract protected function doXTaxonomyAddFormFieldsAction(): void;
}
