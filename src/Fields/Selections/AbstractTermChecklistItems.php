<?php

namespace WebTheory\Leonidas\Fields\Selections;

use WebTheory\Saveyour\Contracts\ChecklistItemsInterface;
use WebTheory\Saveyour\Fields\Selections\AbstractChecklistSelectionProvider;

abstract class AbstractTermChecklistItems extends AbstractChecklistSelectionProvider implements ChecklistItemsInterface
{
    /**
     * @var string
     */
    protected $idFormat = 'wts--term--%s';

    /**
     * Get the value of idFormat
     *
     * @return string
     */
    public function getIdFormat(): string
    {
        return $this->idFormat;
    }

    /**
     * Set the value of idFormat
     *
     * @param string $idFormat
     *
     * @return self
     */
    public function setIdFormat(string $idFormat)
    {
        $this->idFormat = $idFormat;

        return $this;
    }

    /**
     * @param WP_Term $term
     */
    protected function provideItemValue($term): string
    {
        return $term->term_id;
    }

    /**
     * @param WP_Term $term
     */
    protected function provideItemLabel($term): string
    {
        return $term->name;
    }

    /**
     * @param WP_Term $term
     */
    protected function provideItemId($term): string
    {
        return sprintf($this->idFormat, $term->slug);
    }
}
