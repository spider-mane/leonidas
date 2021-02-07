<?php

namespace WebTheory\Leonidas\Admin\Fields\Selections\Traits;

use WP_Term;

trait TermSelectOptionsTrait
{
    /**
     * @param WP_Term $term
     */
    public function defineSelectionText($term): string
    {
        return $term->name;
    }
}
