<?php

namespace WebTheory\Leonidas\Fields\Formatters;

use WebTheory\Leonidas\Util\TermCollection;
use WebTheory\Saveyour\Contracts\DataFormatterInterface;

class TermIdChecklistFormatter implements DataFormatterInterface
{
    /**
     *
     */
    public function formatData($terms)
    {
        $terms = new TermCollection(...$terms);

        return array_map('strval', $terms->getIds());
    }

    /**
     *
     */
    public function formatInput($terms)
    {
        if (in_array('0', $terms)) {
            unset($terms[array_search('0', $terms)]);
        }

        return array_map('intval', $terms);
    }
}
