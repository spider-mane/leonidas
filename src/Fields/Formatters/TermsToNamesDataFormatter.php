<?php

namespace WebTheory\Leonidas\Fields\Formatters;

use WebTheory\Leonidas\Util\TermCollection;
use WebTheory\Saveyour\Contracts\DataFormatterInterface;

class TermsToNamesDataFormatter implements DataFormatterInterface
{
    /**
     * @param WP_Term[] $posts
     *
     * @return array
     */
    public function formatData($terms)
    {
        $terms = new TermCollection(...$terms);

        return $terms->getNames();
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

        return $terms;
    }
}
