<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WP_Term;
use WebTheory\Saveyour\Contracts\SuperSelectionProviderInterface;

abstract class AbstractTermSuperSelection implements SuperSelectionProviderInterface
{
    /**
     *
     */
    protected $valueKey = 'term_id';

    /**
     * Get the value of valueKey
     *
     * @return mixed
     */
    public function getValueKey()
    {
        return $this->valueKey;
    }

    /**
     * Set the value of valueKey
     *
     * @param mixed $valueKey
     *
     * @return self
     */
    public function setValueKey($valueKey)
    {
        $this->valueKey = $valueKey;

        return $this;
    }

    /**
     * @param WP_Term $term
     */
    public function provideItemValue($term): string
    {
        return (string) $term->{$this->valueKey};
    }
}
