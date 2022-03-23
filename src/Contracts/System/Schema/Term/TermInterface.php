<?php

namespace Leonidas\Contracts\System\Schema\Term;

use Leonidas\Contracts\System\Model\Taxonomy\TaxonomyInterface;

interface TermInterface
{
    public function getId(): int;

    public function getName(): string;

    public function getSlug(): string;

    public function getDescription(): string;

    public function getCount(): int;

    public function getTaxonomy(): TaxonomyInterface;

    public function getGroup(): int;

    public function getTaxonomyId(): int;

    public function getParentId(): int;

    public function getFilter(): string;
}
