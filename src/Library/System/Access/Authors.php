<?php

namespace Leonidas\Library\System\Access;

use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;
use Leonidas\Library\Core\Access\_Facade;

class Authors extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return AuthorRepositoryInterface::class;
    }
}
