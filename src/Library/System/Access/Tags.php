<?php

namespace Leonidas\Library\System\Access;

use Leonidas\Contracts\System\Model\Tag\TagRepositoryInterface;
use Leonidas\Library\Core\Access\_Facade;

class Tags extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return TagRepositoryInterface::class;
    }
}
