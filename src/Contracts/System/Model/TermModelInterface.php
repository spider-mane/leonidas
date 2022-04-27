<?php

namespace Leonidas\Contracts\System\Model;

use Countable;
use Leonidas\Contracts\System\Model\Taxonomy\TaxonomyInterface;

interface TermModelInterface extends EntityModelInterface, Countable
{
    public function getName(): string;

    public function getSlug(): string;

    public function getTaxonomyId(): int;

    public function getGroup(): int;

    public function getFilter(): string;

    public function getTaxonomy(): TaxonomyInterface;
}
