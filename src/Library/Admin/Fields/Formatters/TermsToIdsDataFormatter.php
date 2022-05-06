<?php

namespace Leonidas\Library\Admin\Fields\Formatters;

use Leonidas\Library\System\Schema\Term\TermCollection;
use WebTheory\Saveyour\Contracts\Formatting\DataFormatterInterface;
use WP_Term;

class TermsToIdsDataFormatter implements DataFormatterInterface
{
    /**
     * @param WP_Term[] $posts
     *
     * @return array
     */
    public function formatData($terms)
    {
        $terms = new TermCollection(...$terms);

        return array_map('strval', $terms->getIds());
    }

    /**
     * @param array $terms
     *
     * @return array
     */
    public function formatInput($terms)
    {
        if (in_array('', $terms)) {
            unset($terms[array_search('', $terms)]);
        }

        return array_map('intval', $terms);
    }
}
