<?php

namespace Leonidas\Contracts\System\Model\Administrator;

interface AdministratorRepositoryInterface
{
    public function select(int $id): AdministratorInterface;
}
