<?php

namespace Leonidas\Hooks;

trait TargetsRegisteredTaxonomyForObjectTypeHook
{
    protected function targetRegisteredTaxonomyForObjectTypeHook()
    {
        add_action(
            'registered_taxonomy_for_object_type',
            $this->doRegisteredTaxonomyForObjectTypeAction(...),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    abstract protected function doRegisteredTaxonomyForObjectTypeAction(string $taxonomy, string $objectType): void;
}
