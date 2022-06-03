<?php

namespace Leonidas\Library\System\Access;

use Leonidas\Contracts\System\Model\Page\PageRepositoryInterface;
use Leonidas\Library\Core\Access\_Facade;

class Pages extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return PageRepositoryInterface::class;
    }
}
