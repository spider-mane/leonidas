<?php

namespace Leonidas\Library\Access;

use Leonidas\Contracts\System\Model\User\UserRepositoryInterface;

class Users extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return UserRepositoryInterface::class;
    }
}
