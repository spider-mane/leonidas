<?php

namespace Leonidas\Library\System\Model\Comment;

use InvalidArgumentException;
use Leonidas\Contracts\System\Model\Comment\CommentInterface;
use Leonidas\Contracts\System\Schema\Comment\CommentConverterInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelConverter;
use WP_Comment;

class CommentConverter extends AbstractModelConverter implements CommentConverterInterface
{
    public function convert(WP_Comment $comment): Comment
    {
        return new Comment($comment, $this->autoInvoker);
    }

    public function revert(object $entity): WP_Comment
    {
        if ($entity instanceof CommentInterface) {
            return get_comment($entity->getId());
        }

        throw new InvalidArgumentException(
            '$entity must be an instance of ' . CommentInterface::class
        );
    }
}
