<?php

namespace Leonidas\Contracts\System\Model\Post;

use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\CommentableInterface;
use Leonidas\Contracts\System\Model\FilterableInterface;
use Leonidas\Contracts\System\Model\MimeInterface;
use Leonidas\Contracts\System\Model\MutableAuthoredInterface;
use Leonidas\Contracts\System\Model\MutableContentInterface;
use Leonidas\Contracts\System\Model\MutableDatableInterface;
use Leonidas\Contracts\System\Model\MutablePostModelInterface;
use Leonidas\Contracts\System\Model\PingableInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use Leonidas\Contracts\System\Model\RestrictableInterface;
use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;

interface PostInterface extends
    FilterableInterface,
    MutableAuthoredInterface,
    MutableContentInterface,
    MutablePostModelInterface,
    PingableInterface,
    CommentableInterface,
    RestrictableInterface,
    MimeInterface,
    MutableDatableInterface
{
    public function getExcerpt(): string;

    public function setExcerpt(string $excerpt): self;

    public function getStatus(): PostStatusInterface;

    public function setStatus(PostStatusInterface $status): self;

    public function getTags(): TagCollectionInterface;

    public function setTags(TagCollectionInterface $tags): self;

    public function addTags(TagCollectionInterface $tags): self;

    public function getCategories(): CategoryCollectionInterface;

    public function setCategories(CategoryCollectionInterface $categories): self;

    public function addCategories(CategoryCollectionInterface $categories): self;
}
