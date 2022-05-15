<?php

namespace Leonidas\Library\Admin\Field\Formatting;

use Leonidas\Library\System\Schema\Term\TermCollection;
use WebTheory\Saveyour\Contracts\Formatting\DataFormatterInterface;

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
