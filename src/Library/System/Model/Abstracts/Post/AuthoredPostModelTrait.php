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

    protected AuthorRepositoryInterface $authorRepository;

    public function getAuthor(): AuthorInterface
    {
        return $this->lazyLoadable('author');
    }

    public function getAuthorId(): int
    {
        return (int) $this->post->post_author;
    }

    protected function getAuthorFromRepository(): AuthorInterface
    {
        return $this->authorRepository->select($this->getAuthorId());
    }
}
