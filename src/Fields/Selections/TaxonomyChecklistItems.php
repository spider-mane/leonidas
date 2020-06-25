<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Taxonomy;
use WP_Term;
use WebTheory\Saveyour\Contracts\SelectionProviderInterface;

class TaxonomyChecklistItems extends AbstractTermChecklistItems implements SelectionProviderInterface
{
    /**
     * @var WP_Taxonomy
     */
    protected $taxonomy;

    /**
     *
     */
    public function __construct(string $taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     * @param WP_Term $item
     */
    protected function provideItemsAsRawData(): array
    {
        return get_terms([
            'taxonomy' => $this->taxonomy,
            'hide_empty' => false
        ]);
    }
}
