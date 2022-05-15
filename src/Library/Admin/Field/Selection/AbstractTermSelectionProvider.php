<?php

namespace Leonidas\Library\Admin\Field\Selection;

use WebTheory\Saveyour\Contracts\Field\Selection\SelectionProviderInterface;
use WP_Term;

abstract class AbstractTermSelectionProvider implements SelectionProviderInterface
{
    protected string $valueKey = 'term_id';

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
    public function defineSelectionValue($term): string
    {
        return (string) $term->{$this->valueKey};
    }
}
