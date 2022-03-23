<?php

namespace Leonidas\Contracts\System\Model\User;

use WP_User;

interface UserConverterInterface
{
    public function convert(UserInterface $user): WP_User;

    public function revert(WP_User $user): UserInterface;
}
