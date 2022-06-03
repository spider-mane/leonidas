<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Library\System\Model\Abstracts\LazyLoadableRelationshipsTrait;

trait AuthoredPostModelTrait
{
    use LazyLoadableRelationshipsTrait;
    use MappedToWpPostTrait;

    protected AuthorInterface $author;

    public function getAuthor(): AuthorInterface
    {
        return $this->lazyLoadable('author', fn (
            AuthorRepositoryInterface $authors
        ) => $authors->select($this->getAuthorId()));
    }

    public function getAuthorId(): int
    {
        return (int) $this->post->post_author;
    }
}
