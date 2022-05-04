<?php

namespace Leonidas\Contracts\System\Model\User\Profile;

use Leonidas\Contracts\System\Model\MutableProfileInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;

interface MutableUserProfileInterface extends UserProfileInterface, MutableProfileInterface
{
    public function setUser(UserInterface $user): self;
}
