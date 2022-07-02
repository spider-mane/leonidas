<?php

namespace Leonidas\Library\Access;

use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;

class Categories extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return CategoryRepositoryInterface::class;
    }
}
