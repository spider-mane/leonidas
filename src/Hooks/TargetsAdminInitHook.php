<?php

namespace Leonidas\Hooks;

use Closure;

trait TargetsAdminInitHook
{
    protected function targetAdminInitHook()
    {
        add_action(
            'admin_init',
            Closure::fromCallable([$this, 'doAdminInitAction']),
            10,
            PHP_INT_MAX
        );

        return $this;
    }

    abstract protected function doAdminInitAction(): void;
}
