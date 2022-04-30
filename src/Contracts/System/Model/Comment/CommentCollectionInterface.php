<?php

namespace Leonidas\Contracts\System\Model\Comment;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface CommentCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): CommentInterface;
}
