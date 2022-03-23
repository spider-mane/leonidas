<?php

namespace Leonidas\Contracts\System\Model\Comment;

interface CommentCollectionInterface
{
    /**
     * @return CommentInterface[]
     */
    public function all(): array;
}
