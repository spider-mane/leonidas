<?php

namespace Leonidas\Library\Admin\Field\Selection\Traits;

use WP_Term;

trait NonHierarchicalTaxonomySelectionTrait
{
    /**
     * @param WP_Term $term
     */
    public function defineSelectionValue($term): string
    {
        return $term->name;
    }
}
