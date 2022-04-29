<?php

namespace Leonidas\Library\System\Model\Abstracts\Post;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use WP_Post;

trait AuthoredPostModelTrait
{
    protected WP_Post $post;

    protected AuthorRepositoryInterface $authorRepository;

    public function getAuthor(): AuthorInterface
    {
        return $this->authorRepository->select(
            (int) $this->post->post_author
        );
    }
}
