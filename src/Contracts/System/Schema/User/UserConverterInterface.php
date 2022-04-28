<?php

namespace Leonidas\Contracts\System\Schema\User;

use WP_User;

interface UserConverterInterface
{
    public function convert(WP_User $user): object;

    public function revert(object $entity): WP_User;
}
