<?php

namespace WebTheory\Leonidas\Fields\Selections\Traits;

use WP_Term;

trait NonHierarchicalTaxonomySelectionTrait
{
    /**
     * @param WP_Term $term
     */
    public function provideItemValue(WP_Term $term): string
    {
        return $term->name;
    }
}
