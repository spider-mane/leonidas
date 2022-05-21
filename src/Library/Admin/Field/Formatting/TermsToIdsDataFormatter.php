<?php

namespace Leonidas\Library\Admin\Field\Formatting;

use Leonidas\Library\System\Schema\Term\TermCollection;
use WebTheory\Saveyour\Contracts\Formatting\DataFormatterInterface;
use WP_Term;

class TermsToIdsDataFormatter implements DataFormatterInterface
{
    /**
     * @param array<WP_Term> $terms
     */
    public function formatData($terms): array
    {
        $terms = new TermCollection(...$terms);

        return array_map('strval', $terms->getIds());
    }

    /**
     * @param array $terms
     */
    public function formatInput($terms): array
    {
        if (in_array('', $terms)) {
            unset($terms[array_search('', $terms)]);
        }

        return array_map('intval', $terms);
    }
}
