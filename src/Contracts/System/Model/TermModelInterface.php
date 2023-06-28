<?php

namespace Leonidas\Contracts\System\Model;

use Countable;
use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyInterface;
use WP_Term;

interface TermModelInterface extends EntityModelInterface, Countable
{
    public function getName(): string;

    public function getSlug(): string;

    public function getTaxonomyId(): int;

    public function getGroup(): int;

    public function getFilter(): string;

    public function applyFilter(string $name): self;

    public function getTaxonomy(): TaxonomyInterface;

    public function getCore(): WP_Term;
}
