<?php

namespace Leonidas\Library\System\Access;

use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;
use Leonidas\Library\Core\Access\_Facade;

class Comments extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return CommentRepositoryInterface::class;
    }
}
