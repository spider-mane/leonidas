<?php

namespace Leonidas\Library\System\Model\Taxonomy;

use Leonidas\Contracts\System\Model\Taxonomy\TaxonomyInterface;
use WP_Taxonomy;

class AdaptedTaxonomy implements TaxonomyInterface
{
    protected WP_Taxonomy $taxonomy;

    public function __construct(WP_Taxonomy $taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    public function getName(): string
    {
        return $this->taxonomy->name;
    }

    public function getLabels(): array
    {
        return (array) $this->taxonomy->labels;
    }

    public function isHierarchical(): bool
    {
        return $this->taxonomy->hierarchical;
    }
}
