<?php

namespace Leonidas\Library\Core\Proxies;

use Leonidas\Contracts\Database\DatabaseAbstractionInterface;

class Database extends BaseStaticObjectProxy
{
    protected static function _getServiceToProxy()
    {
        return DatabaseAbstractionInterface::class;
    }
}
