<?php

namespace Leonidas\Library\System\Model\Category;

use InvalidArgumentException;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Taxonomy\TaxonomyInterface;
use Leonidas\Library\System\Model\Taxonomy\AdaptedTaxonomy;
use WP_Term;

class Category implements CategoryInterface
{
    protected WP_Term $category;

    public function __construct(WP_Term $category)
    {
        if ($category->taxonomy === 'category') {
            $this->category = $category;
        }

        throw new InvalidArgumentException('Term provided for "$category" must be of taxonomy "category"');
    }

    public function getId(): int
    {
        return $this->category->term_id;
    }

    public function getName(): string
    {
        return $this->category->name;
    }

    public function getSlug(): string
    {
        return $this->category->slug;
    }

    public function getDescription(): string
    {
        return $this->category->description;
    }

    public function getCount(): int
    {
        return $this->category->count;
    }

    public function getTaxonomy(): TaxonomyInterface
    {
        return new AdaptedTaxonomy(get_taxonomy($this->category->taxonomy));
    }
}
