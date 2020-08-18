<?php

namespace WebTheory\Leonidas\Fields\Formatters;

use WebTheory\Leonidas\Util\TermCollection;
use WebTheory\Saveyour\Contracts\DataFormatterInterface;

class TermSelectFormatter implements DataFormatterInterface
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
        return array_map('intval', $terms);
    }
}
