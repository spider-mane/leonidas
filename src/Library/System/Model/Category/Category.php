<?php

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
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

    protected WP_Term $term;

    protected PostCollectionInterface $posts;

    protected CategoryInterface $parent;

    protected CategoryCollectionInterface $children;

    protected PostRepositoryInterface $postRepository;

    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(
        WP_Term $term,
        PostRepositoryInterface $postRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->validateTaxonomy($term, 'category');

        $this->term = $term;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;

        $this->getAccessProvider = new CategoryGetAccessProvider($this);
        $this->setAccessProvider = new CategorySetAccessProvider($this);
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
        return $this->posts ??= $this->getPostsFromRepository();
    }

    public function setPosts(PostCollectionInterface $posts): CategoryInterface
    {
        $this->posts = $posts;

        return $this;
    }

    public function getParent(): ?CategoryInterface
    {
        return $this->lazyLoadableNullable('parent');
    }

    public function setParent(?CategoryInterface $parent): CategoryInterface
    {
        $this->parent = $parent;
        $this->term->parent = $parent ? $parent->getId() : 0;

        return $this;
    }

    public function getChildren(): CategoryCollectionInterface
    {
        return $this->lazyLoadable('children');
    }

    protected function getPostsFromRepository(): PostCollectionInterface
    {
        return $this->postRepository->withCategory($this);
    }

    protected function getParentFromRepository(): ?CategoryInterface
    {
        return $this->categoryRepository->select($this->getParentId());
    }

    protected function getChildrenFromRepository(): CategoryCollectionInterface
    {
        return $this->categoryRepository->withParent($this);
    }
}
