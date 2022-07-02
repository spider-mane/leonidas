<?php

namespace Leonidas\Library\Access;

use Leonidas\Contracts\System\Model\Author\AuthorRepositoryInterface;

class Authors extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return AuthorRepositoryInterface::class;
    }
}
