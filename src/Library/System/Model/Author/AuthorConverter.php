<?php

namespace Leonidas\Library\System\Model\Author;

use Leonidas\Contracts\System\Model\Author\AuthorInterface;
use Leonidas\Contracts\System\Schema\User\UserConverterInterface;
use Leonidas\Library\System\Model\Abstracts\AbstractModelConverter;
use Leonidas\Library\System\Schema\Exceptions\UnexpectedEntityException;
use WP_User;

class AuthorConverter extends AbstractModelConverter implements UserConverterInterface
{
    public function convert(WP_User $user): Author
    {
        return new Author($user, $this->autoInvoker);
    }

    public function revert(object $entity): WP_User
    {
        if ($entity instanceof AuthorInterface) {
            return get_user_by('id', $entity->getId());
        }

        throw new UnexpectedEntityException(
            AuthorInterface::class,
            $entity,
            __METHOD__
        );
    }
}
