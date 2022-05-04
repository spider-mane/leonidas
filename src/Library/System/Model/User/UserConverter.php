<?php

namespace Leonidas\Library\System\Model\User;

use Leonidas\Contracts\System\Model\User\UserInterface;
use Leonidas\Contracts\System\Schema\User\UserConverterInterface;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_User;

class UserConverter implements UserConverterInterface
{
    public function convert(WP_User $user): User
    {
        return new User($user);
    }

    public function revert(object $entity): WP_User
    {
        if ($entity instanceof UserInterface) {
            return get_user_by('id', $entity->getId());
        }

        throw new UnexpectedEntityException(
            UserInterface::class,
            $entity,
            __METHOD__
        );
    }
}
