<?php

namespace Leonidas\Contracts\System\Model\Administrator\Profile;

use Leonidas\Contracts\System\Model\Administrator\AdministratorInterface;
use Leonidas\Contracts\System\Model\ProfileInterface;

interface AdministratorProfileInterface extends ProfileInterface
{
    public function getAdministrator(): AdministratorInterface;

    public function setAdministrator(AdministratorInterface $administrator): self;
}
