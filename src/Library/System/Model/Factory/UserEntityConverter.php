<?php

namespace Leonidas\Library\System\Model\Factory;

use Leonidas\Contracts\System\Schema\User\UserConverterInterface;
use Leonidas\Contracts\Util\AutoInvokerInterface;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_User;

class UserEntityConverter implements UserConverterInterface
{
    public function __construct(
        protected string $type,
        protected string $class,
        protected AutoInvokerInterface $invoker
    ) {
        //
    }

    public function convert(WP_User $post): object
    {
        return new $this->class($post, $this->invoker);
    }

    public function revert(object $entity): WP_User
    {
        if ($entity instanceof $this->type) {
            return get_user_by('id', $entity->getId());
        }

        throw new UnexpectedEntityException(
            $this->type,
            $entity,
            __METHOD__
        );
    }
}
