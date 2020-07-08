<?php

namespace WebTheory\Leonidas\Fields\Transformers;

use WebTheory\Leonidas\Util\TermCollection;
use WebTheory\Saveyour\Contracts\DataTransformerInterface;

class TermIdChecklistTransformer implements DataTransformerInterface
{
    /**
     *
     */
    public function transform($terms)
    {
        $terms = new TermCollection(...$terms);

        return array_map('strval', $terms->getIds());
    }

    /**
     *
     */
    public function reverseTransform($terms)
    {
        if (in_array('0', $terms)) {
            unset($terms[array_search('0', $terms)]);
        }

        return array_map('intval', $terms);
    }
}
