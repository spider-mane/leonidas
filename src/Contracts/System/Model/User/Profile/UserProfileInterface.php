<?php

namespace Leonidas\Contracts\System\Model\User\Profile;

use Leonidas\Contracts\System\Model\ProfileInterface;
use Leonidas\Contracts\System\Model\User\UserInterface;

interface UserProfileInterface extends ProfileInterface
{
    public function getUser(): UserInterface;
}
