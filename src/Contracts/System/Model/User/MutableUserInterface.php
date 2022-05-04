<?php

namespace Leonidas\Contracts\System\Model\User;

use Leonidas\Contracts\System\Model\User\Profile\UserProfileInterface;

interface MutableUserInterface extends UserInterface
{
    public function setProfile(UserProfileInterface $profile): UserInterface;
}
