<?php

namespace WebTheory\Leonidas\Admin\Fields\Formatters;

use WP_Term;
use WebTheory\Leonidas\Core\Util\TermCollection;
use WebTheory\Saveyour\Contracts\DataFormatterInterface;

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
