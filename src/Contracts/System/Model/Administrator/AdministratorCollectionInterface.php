<?php

namespace Leonidas\Contracts\System\Model\Administrator;

use Leonidas\Contracts\System\Model\ModelCollectionInterface;

interface AdministratorCollectionInterface extends ModelCollectionInterface
{
    public function getById(int $id): AdministratorInterface;
}
