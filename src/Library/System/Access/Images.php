<?php

namespace Leonidas\Library\System\Access;

use Leonidas\Contracts\System\Model\Image\ImageRepositoryInterface;
use Leonidas\Library\Core\Access\_Facade;

class Images extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return ImageRepositoryInterface::class;
    }
}
