<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Taxonomy;
use WP_Term;
use WebTheory\Saveyour\Contracts\SuperSelectionProviderInterface;

abstract class AbstractTaxonomySelection extends AbstractTermSuperSelection implements SuperSelectionProviderInterface
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
     * @return WP_Term[]
     */
    public function provideItemsAsRawData(): array
    {
        return get_terms([
            'taxonomy' => $this->taxonomy,
            'hide_empty' => false
        ]);
    }
}
