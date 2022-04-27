<?php

namespace Leonidas\Contracts\System\Model\Post;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Category\CategoryCollectionInterface;
use Leonidas\Contracts\System\Model\CommentableInterface;
use Leonidas\Contracts\System\Model\MimeInterface;
use Leonidas\Contracts\System\Model\MutableDatableInterface;
use Leonidas\Contracts\System\Model\MutablePostModelInterface;
use Leonidas\Contracts\System\Model\PingableInterface;
use Leonidas\Contracts\System\Model\Post\Status\PostStatusInterface;
use Leonidas\Contracts\System\Model\RestrictableInterface;
use Leonidas\Contracts\System\Model\Tag\TagCollectionInterface;

interface PostInterface extends
    MutablePostModelInterface,
    PingableInterface,
    CommentableInterface,
    RestrictableInterface,
    MimeInterface,
    MutableDatableInterface
{
    public function getAuthor(): AuthorInterface;

    public function setAuthor(AuthorInterface $author): self;

    public function getContent(): string;

    public function setContent(string $content): self;

    public function getExcerpt(): string;

    public function setExcerpt(string $excerpt): self;

    public function getStatus(): PostStatusInterface;

    public function setStatus(PostStatusInterface $status): self;

    public function getContentFiltered(): string;

    public function setContentFiltered(string $contentFiltered): self;

    public function getFilter(): string;

    public function applyFilter(string $filter);

    public function getTags(): TagCollectionInterface;

    public function setTags(TagCollectionInterface $tags): self;

    public function getCategories(): CategoryCollectionInterface;

    public function setCategories(CategoryCollectionInterface $categories): self;
}
