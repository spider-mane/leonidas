<?php

namespace Leonidas\Library\System\Model\Abstracts\User;

use WP_User;

trait MappedToWpUserTrait
{
    protected WP_User $user;

    protected function mirror(string $local, $localVal, string $mapped, $mappedVal): void
    {
        $this->{$local} = $localVal;
        $this->user->{$mapped} = $mappedVal;
    }
}
