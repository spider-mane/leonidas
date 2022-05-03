<?php

namespace Leonidas\Library\System\Model\Post\Abstracts;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;

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

    public function addCategories(CategoryCollectionInterface $categories): self
    {
        $this->categories = $this->categories->merge($categories);

        return $this;
    }

    public function setTags(TagCollectionInterface $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function addTags(TagCollectionInterface $tags): self
    {
        $this->tags = $this->tags->merge($tags);

        return $this;
    }
}
