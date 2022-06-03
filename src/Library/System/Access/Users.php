<?php

namespace Leonidas\Library\System\Access;

use Leonidas\Contracts\System\Model\User\UserRepositoryInterface;
use Leonidas\Library\Core\Access\_Facade;

class Users extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return UserRepositoryInterface::class;
    }
}
