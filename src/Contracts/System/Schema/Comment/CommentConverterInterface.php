<?php

namespace Leonidas\Contracts\System\Schema\Comment;

use WP_Comment;

interface CommentConverterInterface
{
    public function convert(WP_Comment $comment): object;

    public function revert(object $entity): WP_Comment;
}
