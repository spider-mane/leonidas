<?php

namespace WebTheory\Leonidas\Fields\Selections\Traits;

use WP_Term;

trait TermSelectOptionsTrait
{
    /**
     *
     */
    public function provideItemContent(WP_Term $term): string
    {
        return $term->name;
    }
}
