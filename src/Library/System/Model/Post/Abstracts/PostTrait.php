<?php

namespace Leonidas\Library\System\Model\Post\Abstracts;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;
use Leonidas\Contracts\System\Model\Tag\TagRepositoryInterface;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;
use Leonidas\Library\System\Model\Abstracts\Post\MappedToWpPostTrait;
use Leonidas\Library\System\Model\Post\Status\PostStatus;

trait PostTrait
{
    use LazyLoadableRelationshipsTrait;
    use MappedToWpPostTrait;

    protected TagCollectionInterface $tags;

    protected CategoryCollectionInterface $categories;

    protected TagRepositoryInterface $tagRepository;

    protected CategoryRepositoryInterface $categoryRepository;

    public function getExcerpt(): string
    {
        return $this->post->post_excerpt;
    }

    public function getStatus(): PostStatusInterface
    {
        return new PostStatus($this->post->post_status);
    }

    public function getCategories(): CategoryCollectionInterface
    {
        return $this->lazyLoadable('categories');
    }

    public function getTags(): TagCollectionInterface
    {
        return $this->lazyLoadable('tags');
    }

    protected function getCategoriesFromRepository(): CategoryCollectionInterface
    {
        return $this->categoryRepository->withPost($this);
    }

    protected function getTagsFromRepository(): TagCollectionInterface
    {
        return $this->tagRepository->withPost($this);
    }
}
