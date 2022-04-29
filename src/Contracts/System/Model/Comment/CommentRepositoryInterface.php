<?php

namespace Leonidas\Contracts\System\Model\Comment;

use Leonidas\Contracts\System\Model\Post\PostInterface;

interface CommentRepositoryInterface
{
    public function select(int $id): CommentInterface;

    public function wherePost(PostInterface $post): CommentCollectionInterface;
}
