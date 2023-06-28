<?php

namespace Leonidas\Library\System\Schema\Term;

use Leonidas\Contracts\System\Schema\Term\TermConversionArchiveInterface;
use Leonidas\Library\System\Schema\Abstracts\AbstractEntityConversionArchive;
use WP_Term;

class TermConversionArchive extends AbstractEntityConversionArchive implements TermConversionArchiveInterface
{
    protected array $conversions = [];

    protected array $reversions = [];

    public function getConversion(WP_Term $term): object
    {
        return $this->conversions[$this->hash($term)];
    }

    public function getReversion(object $entity): WP_Term
    {
        return $this->reversions[$this->hash($entity)];
    }

    public function archive(WP_Term $term, object $entity): void
    {
        $this->reversions[$this->hash($entity)] = $term;
        $this->conversions[$this->hash($term)] = $entity;
    }
}
