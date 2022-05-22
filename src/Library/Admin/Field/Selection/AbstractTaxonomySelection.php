<?php

namespace Leonidas\Library\Admin\Field\Selection;

use WebTheory\Saveyour\Contracts\Field\Selection\SelectionProviderInterface;
use WP_Term;

abstract class AbstractTaxonomySelection extends AbstractTermSelectionProvider implements SelectionProviderInterface
{
    protected string $taxonomy;

    public function __construct(string $taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     * @return WP_Term[]
     */
    public function provideSelectionsData(): array
    {
        return get_terms([
            'taxonomy' => $this->taxonomy,
            'hide_empty' => false,
        ]);
    }
}
