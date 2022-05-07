<?php

namespace Leonidas\Library\System\Model\Abstracts\User;

use InvalidArgumentException;
use WP_User;

trait ValidatesRoleTrait
{
    protected function assertRole(WP_User $user, string $role): void
    {
        if (!in_array($role, $user->roles, true)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The user "%s" does not have the role "%s".',
                    $user->user_login,
                    $role
                )
            );
        }
    }
}
