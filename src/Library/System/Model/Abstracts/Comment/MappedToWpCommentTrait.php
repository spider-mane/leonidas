<?php

namespace Leonidas\Library\System\Model\Abstracts\Comment;

use WP_Comment;

trait MappedToWpCommentTrait
{
    protected WP_Comment $comment;

    protected function mirror(string $local, $localVal, string $mapped, $mappedVal): void
    {
        $this->{$local} = $localVal;
        $this->comment->{$mapped} = $mappedVal;
    }
}
