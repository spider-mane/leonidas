<?php

namespace Leonidas\Contracts\System\Model\User;

use Leonidas\Contracts\System\Model\MutableUserModelInterface;
use Leonidas\Contracts\System\Model\User\Profile\UserProfileInterface;

interface UserInterface extends MutableUserModelInterface
{
    public function getProfile(): UserProfileInterface;

    public function setProfile(UserProfileInterface $profile): UserInterface;
}
