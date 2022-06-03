<?php

namespace Leonidas\Library\System\Model\Abstracts;

use Leonidas\Contracts\Util\AutoInvokerInterface;

class AbstractModelConverter
{
    protected AutoInvokerInterface $autoInvoker;

    public function __construct(AutoInvokerInterface $autoInvoker)
    {
        $this->autoInvoker = $autoInvoker;
    }
}
