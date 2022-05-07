<?php

namespace Leonidas\Library\System\Model\Post\Abstracts;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Category\CategoryInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;
use Leonidas\Contracts\System\Model\Tag\TagInterface;

trait MutablePostTrait
{
    use PostTrait;

    public function setExcerpt(string $excerpt): self
    {
        $this->post->post_excerpt = $excerpt;

        return $this;
    }

    public function setStatus(PostStatusInterface $status): self
    {
        $this->post->post_status = $status->getName();

        return $this;
    }

    public function setCategories(CategoryCollectionInterface $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function addCategories(CategoryInterface ...$categories): self
    {
        $this->getCategories()->collect(...$categories);

        return $this;
    }

    public function mergeCategories(CategoryCollectionInterface $categories): self
    {
        $this->getCategories()->collect(...$categories->values());

        return $this;
    }

    public function setTags(TagCollectionInterface $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function addTags(TagInterface ...$tags): self
    {
        $this->getTags()->collect(...$tags);

        return $this;
    }

    public function mergeTags(TagCollectionInterface $tags): self
    {
        $this->getTags()->collect(...$tags->values());

        return $this;
    }
}
