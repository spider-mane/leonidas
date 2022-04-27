<?php

namespace Leonidas\Contracts\System\Model\Administrator;

use Leonidas\Contracts\System\Model\SystemModelCollectionInterface;

interface AdministratorCollectionInterface extends SystemModelCollectionInterface
{
    public function getById(int $id): AdministratorInterface;
}
