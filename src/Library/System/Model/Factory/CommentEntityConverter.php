<?php

namespace Leonidas\Library\System\Model\Factory;

use Leonidas\Contracts\System\Schema\Comment\CommentConverterInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_Comment;

class CommentEntityConverter implements CommentConverterInterface
{
    public function __construct(
        protected string $type,
        protected string $class,
        protected AutoInvokerInterface $invoker
    ) {
        //
    }

    public function convert(WP_Comment $post): object
    {
        return new $this->class($post, $this->invoker);
    }

    public function revert(object $entity): WP_Comment
    {
        if ($entity instanceof $this->type) {
            return get_comment($entity->getId());
        }

        throw new UnexpectedEntityException(
            $this->type,
            $entity,
            __METHOD__
        );
    }
}
