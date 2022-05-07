<?php

namespace Leonidas\Library\System\Model\Abstracts\Term;

use InvalidArgumentException;
use WP_Term;

trait ValidatesTaxonomyTrait
{
    protected function assertTaxonomy(WP_Term $term, string $taxonomy): void
    {
        if ($expected = $taxonomy !== $actual = $term->taxonomy) {
            throw new InvalidArgumentException(
                "The taxonomy of the term must be \"{$expected}\", but it is \"{$actual}.\"",
            );
        }
    }
}
