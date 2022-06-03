<?php

namespace Leonidas\Library\System\Access;

use Leonidas\Contracts\System\Model\Category\CategoryRepositoryInterface;
use Leonidas\Library\Core\Access\_Facade;

class Categories extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return CategoryRepositoryInterface::class;
    }
}
