<?php

namespace Leonidas\Library\Access;

use Leonidas\Contracts\System\Model\Comment\CommentRepositoryInterface;

class Comments extends _Facade
{
    protected static function _getFacadeAccessor()
    {
        return CommentRepositoryInterface::class;
    }
}
