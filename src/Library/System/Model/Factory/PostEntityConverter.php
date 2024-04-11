<?php

namespace Leonidas\Library\System\Model\Factory;

use Leonidas\Contracts\System\Schema\Post\PostConverterInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_Post;

class PostEntityConverter implements PostConverterInterface
{
    public function __construct(
        protected string $type,
        protected string $class,
        protected AutoInvokerInterface $invoker
    ) {
        //
    }

    public function convert(WP_Post $post): object
    {
        return new $this->class($post, $this->invoker);
    }

    public function revert(object $entity): WP_Post
    {
        if ($entity instanceof $this->type) {
            return get_post($entity->getId());
        }

        throw new UnexpectedEntityException(
            $this->type,
            $entity,
            __METHOD__
        );
    }
}
