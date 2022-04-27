<?php

namespace Leonidas\Contracts\System\Model\Comment;

use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;

interface CommentCollectionInterface extends SystemModelCollectionInterface
{
    public function getById(int $id): CommentInterface;
}
