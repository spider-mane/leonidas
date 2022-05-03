<?php

namespace Leonidas\Library\System\Model\Category;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\GetAccessProviderInterface;
use Leonidas\Contracts\System\Model\Post\PostCollectionInterface;
use Leonidas\Contracts\System\Model\Post\PostRepositoryInterface;
use Leonidas\Contracts\System\Model\SetAccessProviderInterface;
use Leonidas\Library\System\Model\Abstracts\Term\MutableTermModelTrait;
use Leonidas\Library\System\Model\Abstracts\Term\ValidatesTaxonomyTrait;
use ReturnTypeWillChange;
use WP_Term;

class Category implements CategoryInterface
{
    use MutableTermModelTrait;
    use ValidatesTaxonomyTrait;

    protected WP_Term $term;

    protected PostCollectionInterface $posts;

    protected CategoryInterface $parent;

    protected CategoryCollectionInterface $children;

    protected PostRepositoryInterface $postRepository;

    protected CategoryRepositoryInterface $categoryRepository;

    protected GetAccessProviderInterface $getAccessProvider;

    protected SetAccessProviderInterface $setAccessProvider;

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

    #[ReturnTypeWillChange]
    public function __get($name)
    {
        return $this->getAccessProvider->get($name);
    }

    public function __set($name, $value): void
    {
        $this->setAccessProvider->set($name, $value);
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
        return $this->parent ??= $this->getParentFromRepository();
    }

    public function setParent(?CategoryInterface $parent): CategoryInterface
    {
        $this->parent = $parent;

        return $this;
    }

    public function getParentId(): int
    {
        return $this->getParent()->getId();
    }

    public function getChildren(): CategoryCollectionInterface
    {
        return $this->children ??= $this->getChildrenFromRepository();
    }

    protected function getPostsFromRepository(): PostCollectionInterface
    {
        return $this->postRepository->withCategory($this);
    }

    protected function getParentFromRepository(): ?CategoryInterface
    {
        return $this->categoryRepository->select($this->term->parent);
    }

    protected function getChildrenFromRepository(): CategoryCollectionInterface
    {
        return $this->categoryRepository->withParent($this);
    }
}
