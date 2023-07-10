<?php

namespace Leonidas\Library\System\Request\Abstracts;

use Psr\Http\Message\ServerRequestInterface;
use WP_Comment;

trait ExpectsCommentEntityTrait
{
    protected function getComment(ServerRequestInterface $request): ?WP_Comment
    {
        return $request->getAttribute('comment');
    }

    protected function getCommentId(ServerRequestInterface $request): ?int
    {
        return ($comment = $this->getComment($request))
            ? $comment->comment_ID
            : null;
    }
}
