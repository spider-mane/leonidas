<?php

namespace Leonidas\Library\Admin\Field\Selection\Traits;

use WP_Term;

trait TermChecklistItemsTrait
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
    public function defineSelectionValue($term): string
    {
        return (string) $term->term_id;
    }

    /**
     * @param WP_Term $term
     */
    public function defineSelectionLabel($term): string
    {
        return $term->name;
    }

    /**
     * @param WP_Term $term
     */
    public function defineSelectionId($term): string
    {
        return sprintf($this->idFormat, $term->slug);
    }
}
