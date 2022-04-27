<?php

namespace Leonidas\Contracts\System\Model\Comment;

interface CommentRepositoryInterface
{
    public function select(int $id): CommentInterface;
}
