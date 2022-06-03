<?php

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Model\Abstracts\AllAccessGrantedTrait;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;
use Leonidas\Library\System\Model\Abstracts\Term\HierarchicalTermTrait;
use Leonidas\Library\System\Model\Abstracts\Term\MutableTermModelTrait;
use Leonidas\Library\System\Model\Abstracts\Term\ValidatesTaxonomyTrait;
use WP_Term;

class Category implements CategoryInterface
{
    use AllAccessGrantedTrait;
    use HierarchicalTermTrait;
    use LazyLoadableRelationshipsTrait;
    use MutableTermModelTrait;
    use ValidatesTaxonomyTrait;

    protected PostCollectionInterface $posts;

    protected ?CategoryInterface $parent;

    protected CategoryCollectionInterface $children;

    public function __construct(
        WP_Term $term,
        AutoInvokerInterface $autoInvoker,
        ?PostCollectionInterface $posts = null,
        ?CategoryInterface $parent = null,
        ?CategoryCollectionInterface $children = null
    ) {
        $this->assertTaxonomy($term, 'category');

        $this->term = $term;
        $this->autoInvoker = $autoInvoker;

        $posts && $this->posts = $posts;
        $parent && $this->parent = $parent;
        $children && $this->children = $children;

        $this->getAccessProvider = new CategoryGetAccessProvider($this);
        $this->setAccessProvider = new CategorySetAccessProvider($this, $autoInvoker);
    }

    public function getDescription(): string
    {
        return $this->term->description;
    }

    public function setDescription(string $description): self
    {
        $this->term->description = $description;

        return $this;
    }

    public function getPosts(): PostCollectionInterface
    {
        return $this->lazyLoadable('posts', fn (
            PostRepositoryInterface $posts
        ) => $posts->whereCategory($this));
    }

    public function setPosts(PostCollectionInterface $posts): CategoryInterface
    {
        $this->posts = $posts;

        return $this;
    }

    public function getParent(): ?CategoryInterface
    {
        return $this->lazyLoadableNullable('parent', fn (
            CategoryRepositoryInterface $categories
        ) => $categories->select($this->getParentId()));
    }

    public function setParent(?CategoryInterface $parent): CategoryInterface
    {
        $this->mirror('parent', $parent, 'parent', $parent ? $parent->getId() : 0);

        return $this;
    }

    public function getChildren(): CategoryCollectionInterface
    {
        return $this->lazyLoadable('children', fn (
            CategoryRepositoryInterface $categories
        ) => $categories->whereParent($this));
    }
}
