<?php

namespace Leonidas\Contracts\System\Model\Administrator;

use Leonidas\Contracts\System\Model\Administrator\Profile\AdministratorProfileInterface;
use Leonidas\Contracts\System\Model\UserModelInterface;

interface AdministratorInterface extends UserModelInterface
{
    public function getProfile(): AdministratorProfileInterface;

    public function setProfile(AdministratorProfileInterface $profile): self;
}
