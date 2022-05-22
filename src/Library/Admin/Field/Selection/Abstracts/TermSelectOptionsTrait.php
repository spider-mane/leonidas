<?php

namespace Leonidas\Library\Admin\Field\Selection\Abstracts;

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
