<?php

namespace Leonidas\Library\System\Model\Abstracts\Term;

use Leonidas\Contracts\System\Configuration\Taxonomy\TaxonomyInterface;
use Leonidas\Library\System\Configuration\Taxonomy\AdaptedTaxonomy;
use WP_Term;

trait TermModelTrait
{
    use MappedToWpTermTrait;

    protected TaxonomyInterface $taxonomy;

    public function getId(): int
    {
        return $this->term->term_id ?? 0;
    }

    public function getCore(): WP_Term
    {
        return $this->term;
    }

    public function getName(): string
    {
        return $this->term->name;
    }

    public function getSlug(): string
    {
        return $this->term->slug;
    }

    public function getTaxonomyId(): int
    {
        return $this->term->term_taxonomy_id;
    }

    public function getGroup(): int
    {
        return $this->term->term_group;
    }

    public function getFilter(): string
    {
        return $this->term->filter;
    }

    public function applyFilter(string $filter): self
    {
        $this->term->filter($filter);

        return $this;
    }

    public function getTaxonomy(): TaxonomyInterface
    {
        return $this->taxonomy ??= AdaptedTaxonomy::fromName($this->term->taxonomy);
    }

    public function count(): int
    {
        return $this->term->count;
    }
}
