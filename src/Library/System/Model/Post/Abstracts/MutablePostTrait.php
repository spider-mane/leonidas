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
        wp_set_object_terms(
            $this->post->ID,
            $categories->extract('id'),
            'category',
            false
        );

        return $this;
    }

    public function addCategories(CategoryCollectionInterface $categories): self
    {
        wp_set_object_terms(
            $this->post->ID,
            $categories->extract('id'),
            'category',
            true
        );

        return $this;
    }

    public function setTags(TagCollectionInterface $tags): self
    {
        wp_set_object_terms(
            $this->post->ID,
            $tags->extract('name'),
            'post_tag',
            false
        );

        return $this;
    }

    public function addTags(TagCollectionInterface $tags): self
    {
        wp_set_object_terms(
            $this->post->ID,
            $tags->extract('name'),
            'post_tag',
            true
        );

        return $this;
    }
}
