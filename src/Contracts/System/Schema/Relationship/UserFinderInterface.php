<?php

namespace Leonidas\Contracts\System\Schema\Relationship;

use Leonidas\Contracts\System\Model\User\UserInterface;

interface UserFinderInterface
{
    public function byId(int $id): UserInterface;

    public function byName(string $name): UserInterface;
}
